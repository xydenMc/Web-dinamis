<?php

namespace App\Controllers\Admin;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\TransactionModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class Dashboard extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $transactionModel;
    protected $userModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->transactionModel = new TransactionModel();
        $this->userModel = new UserModel();
    }

    /**
     * Display admin dashboard
     */
    public function index()
    {
        $data['title'] = 'Dashboard Admin';

        // Statistics
        $data['stats'] = [
            'total_products' => $this->productModel->countAll(),
            'total_categories' => $this->categoryModel->countAll(),
            'total_users' => $this->userModel->countAll(),
            'today_transactions' => $this->getTodayTransactionsCount(),
            'today_revenue' => $this->getTodayRevenue(),
            'month_revenue' => $this->getMonthRevenue(),
            'pending_orders' => $this->getPendingOrders()
        ];

        // Chart data - last 30 days
        $data['sales_chart_data'] = $this->getSalesChartData(30);

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
        $builder = $this->db->table('transactions');
        $builder->where('DATE(created_at)', $today);
        return (int) $builder->countAllResults();
    }

    /**
     * Get today revenue
     */
    private function getTodayRevenue(): float
    {
        $today = date('Y-m-d');
        $builder = $this->db->table('transactions');
        $builder->where('DATE(created_at)', $today);
        $result = $builder->select('SUM(total) as total')->get()->getRowArray();
        return (float) ($result['total'] ?? 0);
    }

    /**
     * Get month revenue
     */
    private function getMonthRevenue(): float
    {
        $monthStart = date('Y-m-01');
        $builder = $this->db->table('transactions');
        $builder->where('created_at >=', $monthStart);
        $result = $builder->select('SUM(total) as total')->get()->getRowArray();
        return (float) ($result['total'] ?? 0);
    }

    /**
     * Get pending orders count
     */
    private function getPendingOrders(): int
    {
        return $this->transactionModel->where('status', 'pending')->countAllResults();
    }

    /**
     * Get sales chart data
     */
    private function getSalesChartData(int $days = 30): array
    {
        $date = date('Y-m-d', strtotime("-{$days} days"));

        $builder = $this->db->table('transactions');
        $builder->select("DATE(created_at) as date, SUM(total) as total");
        $builder->where('created_at >=', $date);
        $builder->where('status !=', 'cancelled');
        $builder->groupBy('DATE(created_at)');
        $builder->orderBy('date', 'ASC');

        $results = $builder->get()->getResultArray();

        $chartData = [];
        foreach ($results as $row) {
            $chartData[$row['date']] = (float) $row['total'];
        }

        // Fill missing dates with 0
        for ($i = 0; $i < $days; $i++) {
            $d = date('Y-m-d', strtotime("-$i days"));
            if (!isset($chartData[$d])) {
                $chartData[$d] = 0;
            }
        }

        ksort($chartData);
        return $chartData;
    }

    /**
     * Get recent orders
     */
    private function getRecentOrders(int $limit = 10): array
    {
        $builder = $this->db->table('transactions');
        $builder->select('transactions.*, users.nama as user_nama');
        $builder->join('users', 'transactions.user_id = users.id', 'left');
        $builder->orderBy('transactions.created_at', 'DESC');
        $builder->limit($limit);

        return $builder->get()->getResultArray();
    }
}