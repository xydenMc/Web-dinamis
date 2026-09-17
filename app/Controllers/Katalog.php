<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\VideoModel;
use CodeIgniter\Controller;

class Katalog extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $videoModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->videoModel = new VideoModel();
        helper(['form']);
    }

    /**
     * Display catalog listing
     */
    public function index(int $page = 1)
    {
        $data['title'] = 'Katalog Produk - Toko Online';
        $data['user'] = session()->get('nama');
        $data['role'] = session()->get('role');

        // Get filters
        $searchQuery = $this->request->getGet('search') ?? '';
        $selectedCategory = $this->request->getGet('category') ?? '';
        $sortBy = $this->request->getGet('sort') ?? 'newest';

        // Get categories for filter
        $data['kategoris'] = $this->categoryModel->getActiveCategories();

        // Build query
        $builder = $this->productModel->builder()
            ->join('categories', 'products.category_id = categories.id', 'left')
            ->where('products.is_active', 1);

        // Apply search filter
        if (!empty($searchQuery)) {
            $builder->groupStart()
                ->like('products.nama', $searchQuery)
                ->orLike('products.deskripsi', $searchQuery)
                ->orLike('categories.nama', $searchQuery)
            ->groupEnd();
        }

        // Apply category filter
        if (!empty($selectedCategory)) {
            $builder->where('categories.slug', $selectedCategory);
        }

        // Apply sorting
        switch ($sortBy) {
            case 'price_asc':
                $builder->orderBy('products.harga', 'ASC');
                break;
            case 'price_desc':
                $builder->orderBy('products.harga', 'DESC');
                break;
            case 'price':
                $builder->orderBy('products.harga', 'ASC');
                break;
            default:
                $builder->orderBy('products.created_at', 'DESC');
        }

        // Pagination
        $perPage = 12;
        $offset = ($page - 1) * $perPage;
        $data['totalProducts'] = (clone $builder)->countAllResults();
        $data['products'] = $builder->limit($perPage, $offset)->get()->getResultArray();
        $data['currentPage'] = $page;
        $data['totalPages'] = ceil($data['totalProducts'] / $perPage);

        // Set filters for UI
        $data['searchQuery'] = $searchQuery;
        $data['selectedCategory'] = $selectedCategory;
        $data['selectedCategoryName'] = '';
        if ($selectedCategory !== '') {
            $category = $this->categoryModel->findBySlug($selectedCategory);
            $data['selectedCategoryName'] = $category['nama'] ?? '';
        }
        $data['sortBy'] = $sortBy;
        $data['paginationBaseUrl'] = base_url('katalog/page');

        // Get videos for multimedia section
        $data['videos'] = $this->videoModel->getActiveVideos();

        return view('katalog/index', $data);
    }

    /**
     * Display products by category
     */
    public function category(string $slug, int $page = 1)
    {
        $category = $this->categoryModel->findBySlug($slug);

        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        $data['title'] = $category['nama'] . ' - Katalog';
        $data['user'] = session()->get('nama');
        $data['role'] = session()->get('role');
        $data['category'] = $category;

        // Get products by category
        $perPage = 12;
        $offset = ($page - 1) * $perPage;

        $data['products'] = $this->productModel->getProductsByCategory($category['id'], $perPage, $offset);
        $data['totalProducts'] = $this->productModel->getProductCount(null, $category['id']);
        $data['currentPage'] = $page;
        $data['totalPages'] = ceil($data['totalProducts'] / $perPage);

        $data['kategoris'] = $this->categoryModel->getActiveCategories();
        $data['selectedCategory'] = $slug;
        $data['selectedCategoryName'] = $category['nama'];
        $data['searchQuery'] = '';
        $data['sortBy'] = 'newest';
        $data['paginationBaseUrl'] = base_url('kategori/' . $slug . '/page');

        // Get videos
        $data['videos'] = $this->videoModel->getActiveVideos();

        return view('katalog/index', $data);
    }

    /**
     * Search products
     */
    public function search(int $page = 1)
    {
        $query = $this->request->getGet('q') ?? '';

        if (empty($query)) {
            return redirect()->to('/katalog');
        }

        $data['title'] = 'Hasil Pencarian: ' . $query . ' - Katalog';
        $data['user'] = session()->get('nama');
        $data['role'] = session()->get('role');
        $data['searchQuery'] = $query;
        $data['selectedCategory'] = '';
        $data['sortBy'] = 'newest';

        $data['kategoris'] = $this->categoryModel->getActiveCategories();

        // Search
        $perPage = 12;
        $offset = ($page - 1) * $perPage;

        $builder = $this->productModel->builder()
            ->join('categories', 'products.category_id = categories.id', 'left')
            ->where('products.is_active', 1)
            ->groupStart()
                ->like('products.nama', $query)
                ->orLike('products.deskripsi', $query)
                ->orLike('categories.nama', $query)
            ->groupEnd();

        $data['totalProducts'] = (clone $builder)->countAllResults();
        $data['products'] = $builder->limit($perPage, $offset)
            ->orderBy('products.created_at', 'DESC')
            ->get()->getResultArray();

        $data['currentPage'] = $page;
        $data['totalPages'] = ceil($data['totalProducts'] / $perPage);
        $data['selectedCategoryName'] = '';
        $data['paginationBaseUrl'] = base_url('search/page');

        // Get videos
        $data['videos'] = $this->videoModel->getActiveVideos();

        return view('katalog/index', $data);
    }

    /**
     * Show product detail in modal
     */
    public function detail(int $id)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan');
        }

        $data['title'] = $product['nama'] . ' - Detail Produk';
        $data['product'] = $product;
        $data['user'] = session()->get('nama');
        $data['role'] = session()->get('role');
        $data['isLoggedIn'] = (bool) session()->get('logged_in');

        return view('katalog/detail_modal', $data);
    }
}
