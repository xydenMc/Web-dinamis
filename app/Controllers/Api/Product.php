<?php

namespace App\Controllers\Api;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use CodeIgniter\Controller;

class Product extends BaseController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    /**
     * API: Get products list with filtering
     */
    public function index()
    {
        $search = $this->request->getGet('search') ?? '';
        $category = $this->request->getGet('category') ?? '';
        $limit = (int) ($this->request->getGet('limit') ?? 20);
        $page = (int) ($this->request->getGet('page') ?? 1);
        $offset = ($page - 1) * $limit;

        $builder = $this->productModel->builder()
            ->join('categories', 'products.category_id = categories.id', 'left')
            ->where('products.is_active', 1);

        if (!empty($search)) {
            $builder->groupStart()
                ->like('products.nama', $search)
                ->orLike('products.deskripsi', $search)
                ->orLike('categories.nama', $search)
            ->groupEnd();
        }

        if (!empty($category)) {
            $builder->where('categories.slug', $category);
        }

        $products = $builder->limit($limit, $offset)->get()->getResultArray();
        $total = $builder->countAllResults(false);

        // Prepare response
        $result = [
            'status' => 'success',
            'data' => [],
            'meta' => [
                'current_page' => $page,
                'per_page' => $limit,
                'total' => $total,
                'total_pages' => ceil($total / $limit)
            ]
        ];

        foreach ($products as $product) {
            $result['data'][] = [
                'id' => $product['id'],
                'nama' => $product['nama'],
                'slug' => $product['slug'],
                'deskripsi' => $product['deskripsi'],
                'harga' => (float) $product['harga'],
                'stok' => (int) $product['stok'],
                'berat' => $product['berat'] ? (int) $product['berat'] : null,
                'image' => $product['image'],
                'image_url' => $product['image'] ? base_url('uploads/products/' . $product['image']) : null,
                'category' => [
                    'id' => $product['category_id'],
                    'nama' => $product['nama'] ?? null,
                    'slug' => $product['slug'] ?? null
                ],
                'is_active' => (bool) $product['is_active'],
                'created_at' => $product['created_at']
            ];
        }

        return $this->response->setJSON($result);
    }

    /**
     * API: Get single product
     */
    public function show(int $id)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => [
                'id' => $product['id'],
                'nama' => $product['nama'],
                'slug' => $product['slug'],
                'deskripsi' => $product['deskripsi'],
                'harga' => (float) $product['harga'],
                'stok' => (int) $product['stok'],
                'berat' => $product['berat'] ? (int) $product['berat'] : null,
                'image' => $product['image'],
                'image_url' => $product['image'] ? base_url('uploads/products/' . $product['image']) : null,
                'category' => [
                    'id' => $product['category_id'],
                    'nama' => $product['category_nama'] ?? null,
                    'slug' => $product['category_slug'] ?? null
                ],
                'is_active' => (bool) $product['is_active'],
                'created_at' => $product['created_at']
            ]
        ]);
    }

    /**
     * API: Search products
     */
    public function search()
    {
        $query = $this->request->getGet('q') ?? '';

        if (empty($query)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Query pencarian tidak diberikan'
            ], 400);
        }

        $products = $this->productModel->searchProducts($query, 20);

        $result = [
            'status' => 'success',
            'data' => [],
            'query' => $query
        ];

        foreach ($products as $product) {
            $result['data'][] = [
                'id' => $product['id'],
                'nama' => $product['nama'],
                'harga' => (float) $product['harga'],
                'image' => $product['image'],
                'image_url' => $product['image'] ? base_url('uploads/products/' . $product['image']) : null
            ];
        }

        return $this->response->setJSON($result);
    }
}