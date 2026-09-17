<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 'carts';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'product_id',
        'qty',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get cart items for a user
     */
    public function getUserCart(int $userId): array
    {
        return $this->select('carts.*, products.nama, products.image, products.harga, products.stok as produk_stok')
                    ->join('products', 'carts.product_id = products.id', 'left')
                    ->where('carts.user_id', $userId)
                    ->findAll();
    }

    /**
     * Add or update cart item
     */
    public function addOrUpdate(int $userId, int $productId, int $qty): array
    {
        $existing = $this->where('user_id', $userId)
                         ->where('product_id', $productId)
                         ->first();

        if ($existing) {
            $result = $this->update($existing['id'], ['qty' => $qty]);
            return ['action' => 'updated', 'result' => $result];
        }

        $result = $this->insert([
            'user_id' => $userId,
            'product_id' => $productId,
            'qty' => $qty,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return ['action' => 'added', 'result' => $result];
    }

    /**
     * Remove item from cart
     */
    public function remove(int $userId, int $productId): bool
    {
        return $this->where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->delete();
    }

    /**
     * Clear user cart
     */
    public function clearUserCart(int $userId): bool
    {
        return $this->where('user_id', $userId)->delete();
    }

    /**
     * Get cart subtotal
     */
    public function getCartSubtotal(int $userId): float
    {
        $items = $this->getUserCart($userId);
        $subtotal = 0;

        foreach ($items as $item) {
            $subtotal += $item['harga'] * $item['qty'];
        }

        return $subtotal;
    }

    /**
     * Check if product is in cart
     */
    public function isProductInCart(int $userId, int $productId): bool
    {
        return $this->where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->countAllResults() > 0;
    }

    /**
     * Decrease stock validation
     */
    public function validateStock(int $userId, int $productId, int $qty): array
    {
        $productModel = new ProductModel();
        $product = $productModel->find($productId);

        if (!$product) {
            return ['valid' => false, 'message' => 'Produk tidak ditemukan'];
        }

        $currentQty = $this->where('user_id', $userId)
                           ->where('product_id', $productId)
                           ->first();

        $totalQty = ($currentQty ? $currentQty['qty'] : 0) + $qty;

        if ($product['stok'] < $totalQty) {
            return ['valid' => false, 'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $product['stok']];
        }

        return ['valid' => true, 'message' => 'OK'];
    }
}