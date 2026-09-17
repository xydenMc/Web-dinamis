<?php

namespace App\Controllers\Admin;

use App\Models\TransactionModel;
use App\Models\TransactionItemsModel;
use CodeIgniter\Controller;

class Transaction extends BaseController
{
    protected $transactionModel;
    protected $transactionItemsModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->transactionItemsModel = new TransactionItemsModel();
    }

    /**
     * Display transaction list
     */
    public function index()
    {
        $data['title'] = 'Kelola Transaksi - Admin';
        $data['transactions'] = $this->getFilteredTransactions();

        return view('admin/transactions/index', $data);
    }

    /**
     * Display transaction details
     */
    public function detail(int $id)
    {
        $transaction = $this->transactionModel->find($id);

        if (!$transaction) {
            return redirect()->to('/admin/transaksi')->with('errors', [
                'message' => 'Transaksi tidak ditemukan'
            ]);
        }

        $items = $this->transactionItemsModel->getTransactionItems($id);

        $data['title'] = 'Detail Transaksi - ' . $transaction['invoice_number'];
        $data['transaction'] = $transaction;
        $data['items'] = $items;

        return view('admin/transactions/detail', $data);
    }

    /**
     * Update transaction status
     */
    public function updateStatus(int $id)
    {
        $transaction = $this->transactionModel->find($id);

        if (!$transaction) {
            return redirect()->to('/admin/transaksi')->with('errors', [
                'message' => 'Transaksi tidak ditemukan'
            ]);
        }

        $newStatus = $this->request->getPost('status');
        $validStatuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];

        if (!in_array($newStatus, $validStatuses)) {
            return redirect()->back()->with('errors', [
                'status' => 'Status tidak valid'
            ]);
        }

        $this->transactionModel->update($id, ['status' => $newStatus]);

        return redirect()->back()->with('success', [
            'message' => 'Status transaksi berhasil diperbarui'
        ]);
    }

    /**
     * Cancel transaction
     */
    public function cancel(int $id)
    {
        $transaction = $this->transactionModel->find($id);

        if (!$transaction) {
            return redirect()->to('/admin/transaksi')->with('errors', [
                'message' => 'Transaksi tidak ditemukan'
            ]);
        }

        // Only cancel if pending
        if ($transaction['status'] !== 'pending') {
            return redirect()->back()->with('errors', [
                'status' => 'Transaksi hanya dapat dibatalkan jika statusnya pending'
            ]);
        }

        $this->transactionModel->update($id, ['status' => 'cancelled']);

        return redirect()->back()->with('success', [
            'message' => 'Transaksi berhasil dibatalkan'
        ]);
    }

    /**
     * Get filtered transactions
     */
    private function getFilteredTransactions(): array
    {
        $builder = $this->db->table('transactions');
        $builder->select('transactions.*, users.nama as user_nama, users.email as user_email');
        $builder->join('users', 'transactions.user_id = users.id', 'left');

        // Filters
        $status = $this->request->getGet('status');
        $search = $this->request->getGet('search');
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        $category = $this->request->getGet('category');

        if ($status) {
            $builder->where('transactions.status', $status);
        }

        if ($search) {
            $builder->groupStart()
                ->like('transactions.invoice_number', $search)
                ->orLike('users.nama', $search)
                ->orLike('users.email', $search)
            ->groupEnd();
        }

        if ($startDate) {
            $builder->where('transactions.created_at >=', $startDate . ' 00:00:00');
        }

        if ($endDate) {
            $builder->where('transactions.created_at <=', $endDate . ' 23:59:59');
        }

        if ($category) {
            $builder->where('transactions.category', $category);
        }

        $builder->orderBy('transactions.created_at', 'DESC');

        // Pagination
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        $builder->limit($perPage, $offset);

        return $builder->get()->getResultArray();
    }
}