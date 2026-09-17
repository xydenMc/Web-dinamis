<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionItemsModel extends Model
{
    protected $table = 'transaction_items';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'transaction_id',
        'product_id',
        'nama_produk',
        'harga_satuan',
        'qty',
        'subtotal'
    ];

    protected $useTimestamps = false;

    /**
     * Get items for a transaction
     */
    public function getTransactionItems(int $transactionId): array
    {
        return $this->where('transaction_id', $transactionId)
                    ->orderBy('id', 'ASC')
                    ->findAll();
    }

    /**
     * Insert transaction items
     */
    public function insertTransactionItems(int $transactionId, array $items): bool
    {
        foreach ($items as $item) {
            $result = $this->insert([
                'transaction_id' => $transactionId,
                'product_id' => $item['product_id'] ?? $item['id_produk'],
                'nama_produk' => $item['nama_produk'],
                'harga_satuan' => $item['harga_satuan'] ?? $item['harga'],
                'qty' => $item['qty'] ?? $item['quantity'],
                'subtotal' => $item['subtotal']
            ]);

            if (!$result) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get total items for transaction
     */
    public function getTotalItems(int $transactionId): int
    {
        $result = $this->select('SUM(qty) as total')
                       ->where('transaction_id', $transactionId)
                       ->get()->getRowArray();

        return $result['total'] ?? 0;
    }

    /**
     * Get total amount for transaction
     */
    public function getTotalAmount(int $transactionId): float
    {
        $result = $this->select('SUM(subtotal) as total')
                       ->where('transaction_id', $transactionId)
                       ->get()->getRowArray();

        return $result['total'] ?? 0;
    }
}