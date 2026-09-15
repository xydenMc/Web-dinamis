<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\ProdukModel;
use App\Models\KategoriModel;
use CodeIgniter\Controller;

class AdminLaporan extends Controller
{
    protected $transaksiModel;
    protected $produkModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->produkModel = new ProdukModel();
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $data['title'] = 'Laporan Penjualan - Griya Pot Bunga';
        $data['user'] = session()->get('username');
        $data['role'] = session()->get('role');

        // Filter tanggal
        $tanggalMulai = $this->request->getGet('tanggal_mulai') ?? date('Y-m-01');
        $tanggalAkhir = $this->request->getGet('tanggal_akhir') ?? date('Y-m-t');

        // Gunakan query builder dengan raw query untuk filter tanggal
        $db = \Config\Database::connect();

        // Total transaksi selesai dalam periode
        $totalPendapatanQuery = $db->query("SELECT SUM(total_harga) as total FROM transaksi WHERE status = 'Selesai' AND tanggal >= ? AND tanggal <= ?", [$tanggalMulai, $tanggalAkhir]);
        $totalPendapatanResult = $totalPendapatanQuery->getRowArray();
        $data['totalPendapatan'] = $totalPendapatanResult['total'] ?? 0;

        // Jumlah transaksi selesai
        $jumlahTransaksiQuery = $db->query("SELECT COUNT(*) as count FROM transaksi WHERE status = 'Selesai' AND tanggal >= ? AND tanggal <= ?", [$tanggalMulai, $tanggalAkhir]);
        $jumlahResult = $jumlahTransaksiQuery->getRowArray();
        $data['jumlahTransaksi'] = $jumlahResult['count'] ?? 0;

        // Total item terjual
        $totalItemQuery = $db->query("SELECT COALESCE(SUM(dt.jumlah), 0) as total FROM detail_transaksi dt JOIN transaksi t ON dt.id_transaksi = t.id_transaksi WHERE t.status = 'Selesai' AND t.tanggal >= ? AND t.tanggal <= ?", [$tanggalMulai, $tanggalAkhir]);
        $totalItemResult = $totalItemQuery->getRowArray();
        $data['totalItemTerjual'] = $totalItemResult['total'] ?? 0;

        // Produk terlaris
        $produkTerlarisQuery = $db->query("SELECT p.nama_produk, SUM(dt.jumlah) as terjual, SUM(dt.subtotal) as pendapatan FROM detail_transaksi dt JOIN transaksi t ON dt.id_transaksi = t.id_transaksi JOIN produk p ON dt.id_produk = p.id_produk WHERE t.status = 'Selesai' AND t.tanggal >= ? AND t.tanggal <= ? GROUP BY dt.id_produk ORDER BY terjual DESC LIMIT 10", [$tanggalMulai, $tanggalAkhir]);
        $data['produkTerlaris'] = $produkTerlarisQuery->getResultArray();

        // Transaksi dalam periode
        $transaksiQuery = $db->query("SELECT * FROM transaksi WHERE tanggal >= ? AND tanggal <= ? ORDER BY tanggal DESC", [$tanggalMulai, $tanggalAkhir]);
        $data['transaksi'] = $transaksiQuery->getResultArray();

        $data['tanggalMulai'] = $tanggalMulai;
        $data['tanggalAkhir'] = $tanggalAkhir;

        return view('admin/laporan_view', $data);
    }
}