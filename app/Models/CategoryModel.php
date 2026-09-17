<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama',
        'slug',
        'deskripsi',
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
        'slug' => 'required|is_unique[categories.slug]|alpha_dash',
        'deskripsi' => 'permit_empty|max_length[1000]'
    ];

    protected $validationMessages = [
        'nama' => [
            'required' => 'Nama kategori wajib diisi.',
            'min_length' => 'Nama kategori minimal 3 karakter.',
            'max_length' => 'Nama kategori maksimal 255 karakter.'
        ],
        'slug' => [
            'required' => 'Slug kategori wajib diisi.',
            'is_unique' => 'Slug kategori sudah ada.',
            'alpha_dash' => 'Slug hanya boleh berisi huruf, angka, garis bawah, dan strip.'
        ]
    ];

    /**
     * Get active categories
     */
    public function getActiveCategories(): array
    {
        return $this->where('is_active', 1)
                    ->orderBy('nama', 'ASC')
                    ->findAll();
    }

    /**
     * Find category by slug
     */
    public function findBySlug(string $slug): array|null
    {
        return $this->where('slug', $slug)->first();
    }

    /**
     * Get category with product count
     */
    public function getCategoriesWithProductCount(): array
    {
        $builder = $this->db->table('categories');
        $builder->select('categories.*, COUNT(products.id) as product_count');
        $builder->join('products', 'categories.id = products.category_id', 'left');
        $builder->where('categories.is_active', 1);
        $builder->groupBy('categories.id');
        $builder->orderBy('categories.nama', 'ASC');

        return $builder->get()->getResultArray();
    }
}