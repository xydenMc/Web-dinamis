<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;
use CodeIgniter\Controller;

class AdminTransaksi extends Controller
{
    protected $transaksiModel;
    protected $detailTransaksiModel;
    protected $produkModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->detailTransaksiModel = new DetailTransaksiModel();
        $this->produkModel = new \App\Models\ProdukModel();
    }

    public function index()
    {
        $statusFilter = $this->request->getGet('status') ?? 'all';

        $data['title'] = 'Kelola Transaksi - Griya Pot Bunga';
        $data['user'] = session()->get('username');
        $data['role'] = session()->get('role');

        if ($statusFilter === 'all') {
            $data['transaksis'] = $this->transaksiModel->orderBy('tanggal', 'DESC')->findAll();
        } else {
            $data['transaksis'] = $this->transaksiModel->getTransaksiByStatus($statusFilter);
        }

        $data['status_filter'] = $statusFilter;

        return view('admin/transaksi_view', $data);
    }

    public function detail($id = null)
    {
        if ($id === null) {
            return redirect()->to('/transaksi')->with('error', 'ID transaksi tidak diberikan.');
        }

        $transaksi = $this->transaksiModel->getTransaksiWithDetails($id);

        if (!$transaksi) {
            return redirect()->to('/transaksi')->with('error', 'Transaksi tidak ditemukan.');
        }

        $data['title'] = 'Detail Transaksi - Griya Pot Bunga';
        $data['user'] = session()->get('username');
        $data['role'] = session()->get('role');
        $data['transaksi'] = $transaksi;

        return view('admin/transaksi_detail_view', $data);
    }

    public function updateStatus($id = null)
    {
        if ($id === null) {
            return redirect()->to('/transaksi')->with('error', 'ID transaksi tidak diberikan.');
        }

        if ($this->request->getMethod() !== 'POST') {
            return redirect()->to('/transaksi');
        }

        $status = $this->request->getPost('status');

        $allowedStatuses = ['Pending', 'Diproses', 'Selesai', 'Dibatalkan'];
        if (!in_array($status, $allowedStatuses)) {
            return redirect()->to('/transaksi')->with('error', 'Status tidak valid.');
        }

        $transaksi = $this->transaksiModel->find($id);
        if (!$transaksi) {
            return redirect()->to('/transaksi')->with('error', 'Transaksi tidak ditemukan.');
        }

        // Jika status berubah ke Selesai, stok sudah diupdate sekali saat checkout
        // Jika status berubah ke Dibatalkan, kembalikan stok
        if ($status === 'Dibatalkan' && $transaksi['status'] === 'Selesai') {
            // Kembalikan stok
            $details = $this->detailTransaksiModel->getByTransaksi($id);
            foreach ($details as $detail) {
                $produk = $this->produkModel->find($detail['id_produk']);
                if ($produk) {
                    $this->produkModel->update($detail['id_produk'], [
                        'stok' => $produk['stok'] + $detail['jumlah']
                    ]);
                }
            }
        }

        // Jika status berubah dari Pending/Diproses ke Selesai atau Dibatalkan
        if (in_array($transaksi['status'], ['Pending', 'Diproses']) && in_array($status, ['Selesai', 'Dibatalkan'])) {
            // Stok sudah diupdate saat checkout
        }

        $this->transaksiModel->update($id, ['status' => $status]);

        return redirect()->to('/transaksi')->with('success', 'Status transaksi berhasil diperbarui.');
    }
}