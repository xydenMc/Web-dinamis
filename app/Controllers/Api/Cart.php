<?php

namespace App\Controllers\Api;

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
    }

    /**
     * API: Get cart count
     */
    public function getCartCount()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'login_required'
            ]);
        }

        $userId = session()->get('user_id');
        $cartItems = $this->cartModel->getUserCart($userId);

        $cartCount = 0;
        foreach ($cartItems as $item) {
            $cartCount += $item['qty'];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'cart_count' => $cartCount
        ]);
    }

    /**
     * API: Get full cart
     */
    public function index()
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
        $ongkosKirim = $subtotal > 50000 ? 0 : 15000;
        $total = $subtotal + $ongkosKirim;

        $cartCount = 0;
        foreach ($cartItems as $item) {
            $cartCount += $item['qty'];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'cart' => $cartItems,
            'cart_count' => $cartCount,
            'subtotal' => $subtotal,
            'ongkos_kirim' => $ongkosKirim,
            'total' => $total
        ]);
    }
}