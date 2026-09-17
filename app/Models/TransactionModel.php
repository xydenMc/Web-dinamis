<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'invoice_number',
        'user_id',
        'nama_penerima',
        'telepon',
        'email',
        'alamat_lengkap',
        'kota',
        'provinsi',
        'kode_pos',
        'metode_bayar',
        'subtotal',
        'ongkos_kirim',
        'total',
        'status',
        'catatan',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'invoice_number' => 'required|is_unique[transactions.invoice_number]',
        'nama_penerima' => 'required|min_length[3]|max_length[255]',
        'telepon' => 'required|min_length[10]|max_length[20]',
        'email' => 'permit_empty|valid_email',
        'alamat_lengkap' => 'required|min_length[5]|max_length[1000]',
        'kota' => 'permit_empty|max_length[100]',
        'provinsi' => 'permit_empty|max_length[100]',
        'kode_pos' => 'permit_empty|max_length[10]',
        'metode_bayar' => 'required|in_list[transfer,cod,qris]',
        'status' => 'in_list[pending,processing,shipped,completed,cancelled]'
    ];

    protected $validationMessages = [
        'invoice_number' => [
            'required' => 'Nomor invoice wajib diisi.',
            'is_unique' => 'Nomor invoice sudah ada.'
        ],
        'nama_penerima' => [
            'required' => 'Nama penerima wajib diisi.',
            'min_length' => 'Nama penerima minimal 3 karakter.'
        ],
        'telepon' => [
            'required' => 'Nomor telepon wajib diisi.',
            'min_length' => 'Nomor telepon minimal 10 digit.',
            'max_length' => 'Nomor telepon maksimal 20 digit.'
        ],
        'metode_bayar' => [
            'required' => 'Metode pembayaran wajib dipilih.',
            'in_list' => 'Metode pembayaran tidak valid.'
        ],
        'status' => [
            'in_list' => 'Status tidak valid.'
        ]
    ];

    /**
     * Generate unique invoice number
     */
    public static function generateInvoiceNumber(): string
    {
        return 'TRX-' . date('Ymd') . '-' . str_pad(random_int(1, 99999), 5, '0', STR_PAD_LEFT);
    }

    /**
     * Get transactions by user
     */
    public function getUserTransactions(int $userId): array
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get transactions by status
     */
    public function getTransactionsByStatus(string $status): array
    {
        return $this->where('status', $status)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get transactions with date range
     */
    public function getTransactionsByDateRange(string $startDate, string $endDate): array
    {
        return $this->where('created_at >=', $startDate)
                    ->where('created_at <=', $endDate . ' 23:59:59')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get transactions with filters
     */
    public function getFilteredTransactions(array $filters = []): array
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
                ->orLike('transactions.nama_penerima', $filters['keyword'])
                ->orLike('transactions.email', $filters['keyword'])
            ->groupEnd();
        }

        $builder->orderBy('transactions.created_at', 'DESC');

        return $builder->get()->getResultArray();
    }

    /**
     * Get daily sales report
     */
    public function getDailySalesReport(int $days = 30): array
    {
        $startDate = date('Y-m-d', strtotime("-{$days} days"));

        $builder = $this->db->table('transactions');

        $builder->select("DATE(created_at) as tanggal,
                         SUM(total) as total_omzet,
                         COUNT(*) as jumlah_transaksi");
        $builder->where('created_at >=', $startDate);
        $builder->where('status !=', 'cancelled');
        $builder->groupBy('DATE(created_at)');
        $builder->orderBy('tanggal', 'ASC');

        return $builder->get()->getResultArray();
    }

    /**
     * Get total revenue (with optional filters)
     */
    public function getTotalRevenue(array $filters = []): float
    {
        $builder = $this->db->table('transactions');

        if (!empty($filters['status'])) {
            $builder->where('status', $filters['status']);
        }

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $builder->where('created_at >=', $filters['start_date']);
            $builder->where('created_at <=', $filters['end_date'] . ' 23:59:59');
        }

        $result = $builder->select('SUM(total) as total')->get()->getRowArray();

        return isset($result['total']) ? (float) $result['total'] : 0;
    }

    /**
     * Update transaction status
     */
    public function updateStatus(int $id, string $status): bool
    {
        return $this->update($id, ['status' => $status]);
    }
}