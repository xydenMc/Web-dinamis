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
        $statusFilter = (string) ($this->request->getGet('status') ?? 'all');
        $allowedStatuses = ['all', 'Pending', 'Diproses', 'Selesai', 'Dibatalkan'];
        if (!in_array($statusFilter, $allowedStatuses, true)) {
            $statusFilter = 'all';
        }

        $startDate = $this->validDate((string) ($this->request->getGet('start_date') ?? ''));
        $endDate = $this->validDate((string) ($this->request->getGet('end_date') ?? ''));
        if ($startDate !== '' && $endDate !== '' && $startDate > $endDate) {
            [$startDate, $endDate] = [$endDate, $startDate];
        }

        $data['title'] = 'Kelola Transaksi - Griya Pot Bunga';
        $data['user'] = session()->get('username');
        $data['role'] = session()->get('role');

        $builder = $this->transaksiModel->builder();
        if ($statusFilter !== 'all') {
            $builder->where('status', $statusFilter);
        }
        if ($startDate !== '') {
            $builder->where('tanggal >=', $startDate . ' 00:00:00');
        }
        if ($endDate !== '') {
            $builder->where('tanggal <=', $endDate . ' 23:59:59');
        }
        $data['transaksis'] = $builder->orderBy('tanggal', 'DESC')->get()->getResultArray();

        $data['status_filter'] = $statusFilter;
        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;
        $data['pendingOrders'] = $this->transaksiModel->getCountByStatus('Pending');

        return view('admin/transaksi_view', $data);
    }

    private function validDate(string $date): string
    {
        if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $date, $matches)) {
            return '';
        }

        return checkdate((int) $matches[2], (int) $matches[3], (int) $matches[1]) ? $date : '';
    }

    public function detail($id = null)
    {
        if ($id === null) {
            return redirect()->to('/admin/transaksi')->with('error', 'ID transaksi tidak diberikan.');
        }

        $transaksi = $this->transaksiModel->getTransaksiWithDetails($id);

        if (!$transaksi) {
            return redirect()->to('/admin/transaksi')->with('error', 'Transaksi tidak ditemukan.');
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
            return redirect()->to('/admin/transaksi')->with('error', 'ID transaksi tidak diberikan.');
        }

        if ($this->request->getMethod() !== 'POST') {
            return redirect()->to('/admin/transaksi');
        }

        $status = $this->request->getPost('status');

        $allowedStatuses = ['Pending', 'Diproses', 'Selesai', 'Dibatalkan'];
        if (!in_array($status, $allowedStatuses)) {
            return redirect()->to('/admin/transaksi')->with('error', 'Status tidak valid.');
        }

        $transaksi = $this->transaksiModel->find($id);
        if (!$transaksi) {
            return redirect()->to('/admin/transaksi')->with('error', 'Transaksi tidak ditemukan.');
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

        return redirect()->to('/admin/transaksi')->with('success', 'Status transaksi berhasil diperbarui.');
    }
}
