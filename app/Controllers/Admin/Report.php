<?php

namespace App\Controllers\Admin;

use App\Models\TransactionModel;
use CodeIgniter\Controller;
use CodeIgniter\Database\BaseConnection;

class Report extends BaseController
{
    protected $transactionModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
    }

    /**
     * Display sales report
     */
    public function index()
    {
        $data['title'] = 'Laporan Penjualan - Admin';

        // Get filters
        $filters = [
            'status' => $this->request->getGet('status') ?? '',
            'start_date' => $this->request->getGet('start_date') ?? date('Y-m-01'),
            'end_date' => $this->request->getGet('end_date') ?? date('Y-m-d'),
            'keyword' => $this->request->getGet('search') ?? ''
        ];

        // Get transactions with filters
        $data['transactions'] = $this->getFilteredTransactions($filters);

        // Get summary
        $data['summary'] = $this->getSummary($filters);

        // Chart data
        $data['chart_data'] = $this->getChartAndTableData($filters);

        return view('admin/reports/index', $data);
    }

    /**
     * Export report to CSV
     */
    public function exportCsv()
    {
        $filters = [
            'status' => $this->request->getGet('status') ?? '',
            'start_date' => $this->request->getGet('start_date') ?? date('Y-m-01'),
            'end_date' => $this->request->getGet('end_date') ?? date('Y-m-d'),
            'keyword' => $this->request->getGet('search') ?? ''
        ];

        $transactions = $this->getFilteredTransactions($filters);

        // Generate CSV
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Invoice', 'Tanggal', 'Pembeli', 'Item', 'Subtotal', 'Ongkos', 'Total', 'Bayar', 'Status', 'Catatan']);

        foreach ($transactions as $txn) {
            fputcsv($output, [
                $txn['invoice_number'],
                date('Y-m-d H:i:s', strtotime($txn['created_at'])),
                $txn['user_nama'],
                $txn['total_item'] ?? 0,
                number_format($txn['subtotal'], 2, ',', '.'),
                number_format($txn['ongkos_kirim'] ?? 0, 2, ',', '.'),
                number_format($txn['total'], 2, ',', '.'),
                $txn['metode_bayar'] ?? '',
                $txn['status'],
                $txn['catatan'] ?? ''
            ]);
        }

        fclose($output);

        // Set headers for download
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=laporan-transaksi-' . date('YmdHis') . '.csv');

        return null;
    }

    /**
     * Get filtered transactions
     */
    private function getFilteredTransactions(array $filters): array
    {
        $builder = $this->db->table('transactions');
        $builder->select('transactions.*, users.nama as user_nama');
        $builder->join('users', 'transactions.user_id = users.id', 'left');

        if (!empty($filters['status'])) {
            $builder->where('transactions.status', $filters['status']);
        }

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $builder->where('transactions.created_at >=', $filters['start_date']);
            $builder->where('transactions.created_at <=', $filters['end_date'] . ' 23:59:59');
        }

        if (!empty($filters['keyword'])) {
            $builder->groupStart()
                ->like('transactions.invoice_number', $filters['keyword'])
                ->orLike('users.nama', $filters['keyword'])
                ->orLike('users.email', $filters['keyword'])
            ->groupEnd();
        }

        $builder->orderBy('transactions.created_at', 'DESC');

        $page = $this->request->getGet('page') ?? 1;
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        return $builder->limit($perPage, $offset)->get()->getResultArray();
    }

    /**
     * Get summary data
     */
    private function getSummary(array $filters): array
    {
        // Total revenue
        $builder = $this->db->table('transactions');
        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $builder->where('status', $filters['status']);
        } else {
            $builder->where('status !=', 'cancelled');
        }

        if (!empty($filters['start_date'])) {
            $builder->where('created_at >=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $builder->where('created_at <=', $filters['end_date'] . ' 23:59:59');
        }

        $totalRevenue = (float) ($builder->select('SUM(total) as total')->get()->getRowArray()['total'] ?? 0);

        // Count by status
        $statusCounts = [];
        $builder = $this->db->table('transactions');
        $builder->select('status, COUNT(*) as count');
        if (!empty($filters['start_date'])) {
            $builder->where('created_at >=', $filters['start_date']);
        }
        if (!empty($filters['end_date'])) {
            $builder->where('created_at <=', $filters['end_date'] . ' 23:59:59');
        }
        $builder->groupBy('status');
        $results = $builder->get()->getResultArray();

        foreach ($results as $row) {
            $statusCounts[$row['status']] = (int) $row['count'];
        }

        return [
            'total_revenue' => $totalRevenue,
            'total_transactions' => $builder->countAllResults(false),
            'status_counts' => $statusCounts
        ];
    }

    /**
     * Get chart and table data
     */
    private function getChartAndTableData(array $filters): array
    {
        // Daily sales
        $builder = $this->db->table('transactions');
        $builder->select("DATE(created_at) as date, SUM(total) as total, COUNT(*) as count");
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $builder->where('created_at >=', $filters['start_date']);
            $builder->where('created_at <=', $filters['end_date'] . ' 23:59:59');
        }
        $builder->where('status !=', 'cancelled');
        $builder->groupBy('DATE(created_at)');
        $builder->orderBy('date', 'ASC');

        return [
            'daily_sales' => $builder->get()->getResultArray()
        ];
    }
}