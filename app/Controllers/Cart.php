<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CartModel;
use CodeIgniter\Controller;

class Cart extends BaseController
{
    protected $productModel;
    protected $cartModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->cartModel = new CartModel();
        helper(['form']);
    }

    /**
     * Display cart page
     */
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('errors', [
                'login' => 'Anda harus login untuk melihat keranjang'
            ]);
        }

        $userId = session()->get('user_id');
        $cartItems = $this->cartModel->getUserCart($userId);

        $subtotal = $this->cartModel->getCartSubtotal($userId);
        $ongkosKirim = $subtotal > 50000 ? 0 : 15000; // Free shipping above 50k
        $total = $subtotal + $ongkosKirim;

        $data['title'] = 'Keranjang Belanja - Toko Online';
        $data['user'] = session()->get('nama');
        $data['cartItems'] = $cartItems;
        $data['subtotal'] = $subtotal;
        $data['ongkosKirim'] = $ongkosKirim;
        $data['total'] = $total;

        return view('cart/index', $data);
    }

    /**
     * Add product to cart
     */
    public function add()
    {
        $productId = $this->request->getPost('id_produk') ?? $this->request->getPost('product_id');
        $quantity = (int) ($this->request->getPost('quantity') ?? 1);

        if (!$productId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID produk tidak diberikan'
            ]);
        }

        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'login_required',
                'redirect' => '/login'
            ]);
        }

        $userId = session()->get('user_id');

        // Validate stock
        $validation = $this->cartModel->validateStock($userId, $productId, $quantity);
        if (!$validation['valid']) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $validation['message']
            ]);
        }

        // Add to cart
        $result = $this->cartModel->addOrUpdate($userId, $productId, $quantity);

        $cartItems = $this->cartModel->getUserCart($userId);
        $cartCount = 0;
        foreach ($cartItems as $item) {
            $cartCount += $item['qty'];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'cart_count' => $cartCount,
            'cart_items' => $cartItems
        ]);
    }

    /**
     * Get cart items (API)
     */
    public function getCart()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'login_required'
            ]);
        }

        $userId = session()->get('user_id');
        $cartItems = $this->cartModel->getUserCart($userId);
        $subtotal = $this->cartModel->getCartSubtotal($userId);
        $cartCount = 0;

        foreach ($cartItems as $item) {
            $cartCount += $item['qty'];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'cart' => $cartItems,
            'cart_count' => $cartCount,
            'subtotal' => $subtotal,
            'total' => $subtotal + ($subtotal > 50000 ? 0 : 15000)
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(int $id)
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'login_required'
            ]);
        }

        $quantity = (int) $this->request->getPost('quantity');
        $userId = session()->get('user_id');

        if ($quantity <= 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Quantity harus lebih dari 0'
            ]);
        }

        // Get cart item
        $cartItem = $this->cartModel->where('user_id', $userId)
            ->where('product_id', $id)
            ->first();

        if (!$cartItem) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Produk tidak ditemukan di keranjang'
            ]);
        }

        // Validate stock
        $validation = $this->cartModel->validateStock($userId, $id, 0); // 0 means just check existing + new

        // We need to check if new total would exceed stock
        $product = $this->productModel->find($id);
        $currentQty = $cartItem['qty'];
        if ($quantity > $product['stok'] + $currentQty) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $product['stok']
            ]);
        }

        // Update
        $this->cartModel->update($cartItem['id'], ['qty' => $quantity]);

        $cartItems = $this->cartModel->getUserCart($userId);
        $subtotal = $this->cartModel->getCartSubtotal($userId);
        $cartCount = 0;
        foreach ($cartItems as $item) {
            $cartCount += $item['qty'];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Keranjang berhasil diperbarui',
            'cart' => $cartItems,
            'cart_count' => $cartCount,
            'subtotal' => $subtotal,
            'total' => $subtotal + ($subtotal > 50000 ? 0 : 15000)
        ]);
    }

    /**
     * Remove product from cart
     */
    public function remove(int $id)
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'login_required'
            ]);
        }

        $userId = session()->get('user_id');
        $this->cartModel->remove($userId, $id);

        $cartItems = $this->cartModel->getUserCart($userId);
        $subtotal = $this->cartModel->getCartSubtotal($userId);
        $cartCount = 0;
        foreach ($cartItems as $item) {
            $cartCount += $item['qty'];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Produk berhasil dihapus dari keranjang',
            'cart' => $cartItems,
            'cart_count' => $cartCount,
            'subtotal' => $subtotal,
            'total' => $subtotal + ($subtotal > 50000 ? 0 : 15000)
        ]);
    }
}