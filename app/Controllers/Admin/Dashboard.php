<?php

namespace App\Controllers\Admin;

use App\Models\ProdukModel;
use App\Models\KategoriModel;
use App\Models\TransaksiModel;
use CodeIgniter\Controller;

class Dashboard extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $transactionModel;

    public function __construct()
    {
        // Storefront checkout and stock are stored in these legacy tables.
        $this->productModel = new ProdukModel();
        $this->categoryModel = new KategoriModel();
        $this->transactionModel = new TransaksiModel();
    }

    /**
     * Display admin dashboard
     */
    public function index()
    {
        $data['title'] = 'Dashboard Admin';

        // Statistics
        $data['stats'] = [
            'total_products' => $this->productModel->countAllResults(),
            'total_categories' => $this->categoryModel->countAllResults(),
            'today_transactions' => $this->getTodayTransactionsCount(),
            'today_revenue' => $this->getTodayRevenue(),
            'month_revenue' => $this->getMonthRevenue(),
            'pending_orders' => $this->getPendingOrders()
        ];

        $data['low_stock_products'] = $this->productModel
            ->select('id_produk, nama_produk, stok')
            ->where('stok <=', 5)
            ->where('status', 'aktif')
            ->orderBy('stok', 'ASC')
            ->findAll(3);
        $data['active_products'] = $this->productModel
            ->where('status', 'aktif')
            ->countAllResults();
        $data['admin_name'] = session('nama') ?? session('name') ?? 'Admin';

        // Chart data - last 30 days
        $data['sales_chart_data'] = $this->getSalesByProductData(30);

        // Recent orders
        $data['recent_orders'] = $this->getRecentOrders(10);

        return view('admin/dashboard/index', $data);
    }

    /**
     * Get today transactions count
     */
    private function getTodayTransactionsCount(): int
    {
        $today = date('Y-m-d');
        $builder = $this->db->table('transaksi');
        $builder->where('DATE(tanggal)', $today);
        return (int) $builder->countAllResults();
    }

    /**
     * Get today revenue
     */
    private function getTodayRevenue(): float
    {
        $today = date('Y-m-d');
        $builder = $this->db->table('transaksi');
        $builder->where('DATE(tanggal)', $today)->where('status !=', 'Dibatalkan');
        $result = $builder->select('SUM(total_harga) as total')->get()->getRowArray();
        return (float) ($result['total'] ?? 0);
    }

    /**
     * Get month revenue
     */
    private function getMonthRevenue(): float
    {
        $monthStart = date('Y-m-01');
        $builder = $this->db->table('transaksi');
        $builder->where('tanggal >=', $monthStart)->where('status !=', 'Dibatalkan');
        $result = $builder->select('SUM(total_harga) as total')->get()->getRowArray();
        return (float) ($result['total'] ?? 0);
    }

    /**
     * Get pending orders count
     */
    private function getPendingOrders(): int
    {
        return $this->transactionModel->where('status', 'Pending')->countAllResults();
    }

    /**
     * Get sales chart data
     */
    private function getSalesByProductData(int $days = 30): array
    {
        $from = date('Y-m-d', strtotime('-' . ($days - 1) . ' days'));
        $builder = $this->db->table('detail_transaksi dt');
        $rows = $builder->select('p.nama_produk as label, SUM(dt.subtotal) as value')
            ->join('transaksi t', 't.id_transaksi = dt.id_transaksi')
            ->join('produk p', 'p.id_produk = dt.id_produk', 'left')
            ->where('t.tanggal >=', $from)
            ->where('t.status !=', 'Dibatalkan')
            ->groupBy('dt.id_produk, p.nama_produk')
            ->orderBy('value', 'DESC')
            ->limit(8)
            ->get()->getResultArray();

        return array_map(static fn(array $row): array => [
            'label' => $row['label'] ?? 'Produk dihapus',
            'value' => (float) $row['value'],
        ], $rows);
    }

    /**
     * Get recent orders
     */
    private function getRecentOrders(int $limit = 10): array
    {
        $builder = $this->db->table('transaksi t');
        $builder->select("t.id_transaksi as id, t.nomor_transaksi as invoice_number, t.total_harga as total, t.status, t.tanggal as created_at, t.alamat_kirim as kota, u.nama as user_nama, u.nama as nama_penerima");
        $builder->join('users u', 'u.id = t.id_pelanggan', 'left');
        $builder->orderBy('t.tanggal', 'DESC');
        $builder->limit($limit);

        return $builder->get()->getResultArray();
    }
}
