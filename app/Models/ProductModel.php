<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'category_id',
        'nama',
        'slug',
        'deskripsi',
        'harga',
        'stok',
        'berat',
        'image',
        'is_active',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama' => 'required|min_length[3]|max_length[255]',
        'slug' => 'required|alpha_dash',
        'harga' => 'required|decimal|greater_than_equal_to[0]',
        'stok' => 'required|integer|greater_than_equal_to[0]',
        'berat' => 'permit_empty|integer|greater_than_equal_to[0]',
        'category_id' => 'permit_empty|integer',
        'deskripsi' => 'permit_empty|max_length[5000]',
        'image' => 'permit_empty|max_length[255]'
    ];

    protected $validationMessages = [
        'nama' => [
            'required' => 'Nama produk wajib diisi.',
            'min_length' => 'Nama produk minimal 3 karakter.',
            'max_length' => 'Nama produk maksimal 255 karakter.'
        ],
        'slug' => [
            'required' => 'Slug produk wajib diisi.',
            'alpha_dash' => 'Slug hanya boleh berisi huruf, angka, garis bawah, dan strip.'
        ],
        'harga' => [
            'required' => 'Harga produk wajib diisi.',
            'decimal' => 'Harga harus berupa angka.',
            'greater_than_equal_to' => 'Harga tidak boleh negatif.'
        ],
        'stok' => [
            'required' => 'Stok produk wajib diisi.',
            'integer' => 'Stok harus berupa angka bulat.',
            'greater_than_equal_to' => 'Stok tidak boleh negatif.'
        ]
    ];

    /**
     * Get active products with category info
     */
    public function getActiveProductsWithCategory(): array
    {
        return $this->select('products.*, categories.nama as category_nama, categories.slug as category_slug')
                    ->join('categories', 'products.category_id = categories.id', 'left')
                    ->where('products.is_active', 1)
                    ->orderBy('products.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Search products by name/description
     */
    public function searchProducts(string $keyword, int $limit = 20, int $offset = 0): array
    {
        return $this->select('products.*, categories.nama as category_nama, categories.slug as category_slug')
                    ->join('categories', 'products.category_id = categories.id', 'left')
                    ->where('products.is_active', 1)
                    ->groupStart()
                        ->like('nama', $keyword)
                        ->orLike('deskripsi', $keyword)
                        ->orLike('categories.nama', $keyword)
                    ->groupEnd()
                    ->orderBy('products.created_at', 'DESC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get products by category
     */
    public function getProductsByCategory(int $categoryId, int $limit = 20, int $offset = 0): array
    {
        return $this->select('products.*, categories.nama as category_nama, categories.slug as category_slug')
                    ->join('categories', 'products.category_id = categories.id', 'left')
                    ->where('products.is_active', 1)
                    ->where('products.category_id', $categoryId)
                    ->orderBy('products.created_at', 'DESC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Find product by slug
     */
    public function findBySlug(string $slug): array|null
    {
        return $this->select('products.*, categories.nama as category_nama, categories.slug as category_slug')
                    ->join('categories', 'products.category_id = categories.id', 'left')
                    ->where('products.slug', $slug)
                    ->where('products.is_active', 1)
                    ->first();
    }

    /**
     * Get product count (for pagination)
     */
    public function getProductCount(string $keyword = '', int $categoryId = 0): int
    {
        $builder = $this->db->table('products');
        $builder->where('products.is_active', 1);

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('products.nama', $keyword)
                ->orLike('products.deskripsi', $keyword)
            ->groupEnd();
        }

        if ($categoryId > 0) {
            $builder->where('products.category_id', $categoryId);
        }

        return (int) $builder->countAllResults();
    }

    /**
     * Reduce stock
     */
    public function reduceStock(int $productId, int $quantity): bool
    {
        $product = $this->find($productId);
        if (!$product || $product['stok'] < $quantity) {
            return false;
        }

        return $this->update($productId, [
            'stok' => $product['stok'] - $quantity
        ]);
    }

    /**
     * Validate image upload
     */
    public static function validateImage(array $file): array
    {
        $errors = [];

        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Gagal mengunggah gambar.';
            return ['valid' => false, 'errors' => $errors];
        }

        if (!isset($file['size']) || $file['size'] > 2 * 1024 * 1024) {
            $errors[] = 'Ukuran gambar maksimal 2MB.';
        }

        $allowedMime = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (!isset($file['type']) || !in_array($file['type'], $allowedMime)) {
            $errors[] = 'Tipe gambar tidak valid. Hanya JPG, PNG, WEBP yang diizinkan.';
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }
}