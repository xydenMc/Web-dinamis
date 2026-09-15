<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\KategoriModel;
use App\Models\TransaksiModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    protected $produkModel;
    protected $kategoriModel;
    protected $transaksiModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        $this->kategoriModel = new KategoriModel();
        $this->transaksiModel = new TransaksiModel();
    }

    public function index()
    {
        // Check if user is logged in and is admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/katalog');
        }

        $data['title'] = 'Dashboard - Griya Pot Bunga';
        $data['user'] = session()->get('username');
        $data['role'] = session()->get('role');

        // Data real-time dari database
        $data['jumlahProduk'] = $this->produkModel->countAllResults();
        $data['jumlahKategori'] = $this->kategoriModel->countAllResults();
        $data['jumlahTransaksi'] = $this->transaksiModel->countAllResults();
        $data['totalPendapatan'] = $this->transaksiModel->getTotalPendapatan('Selesai');
        $data['jumlahTransaksiSelesai'] = $this->transaksiModel->getCountByStatus('Selesai');
        $data['jumlahProdukTerjual'] = $this->getTotalProdukTerjual();
        $data['jumlahStokMenipis'] = $this->getStokMenipis();

        // Transaksi terbaru
        $data['transaksiTerbaru'] = $this->transaksiModel->getTransaksiTerbaru(10);

        return view('dashboard_view', $data);
    }

    private function getTotalProdukTerjual()
    {
        $builder = $this->db->table('detail_transaksi dt');
        $builder->select('SUM(dt.jumlah) as total')
            ->join('transaksi t', 'dt.id_transaksi = t.id_transaksi')
            ->where('t.status', 'Selesai');

        $result = $builder->get()->getRowArray();
        return $result['total'] ?? 0;
    }

    private function getStokMenipis()
    {
        return $this->produkModel->where('stok', '<', 3)
            ->where('status', 'aktif')
            ->countAllResults();
    }
}