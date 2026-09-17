<?php

namespace App\Controllers\Api;

use App\Models\CategoryModel;
use CodeIgniter\Controller;

class Category extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    /**
     * API: Get categories list
     */
    public function index()
    {
        $categories = $this->categoryModel->getActiveCategories();

        $result = [
            'status' => 'success',
            'data' => []
        ];

        foreach ($categories as $category) {
            $result['data'][] = [
                'id' => $category['id'],
                'nama' => $category['nama'],
                'slug' => $category['slug'],
                'deskripsi' => $category['deskripsi'],
                'image' => $category['image'],
                'image_url' => $category['image'] ? base_url('uploads/categories/' . $category['image']) : null,
                'is_active' => (bool) $category['is_active'],
                'created_at' => $category['created_at']
            ];
        }

        return $this->response->setJSON($result);
    }
}