<?php

namespace App\Controllers\Admin;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\Files\UploadedFile;

class Product extends BaseController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        helper(['form', 'url']);
    }

    /**
     * Display product list
     */
    public function index()
    {
        $data['title'] = 'Kelola Produk - Admin';
        $data['products'] = $this->productModel->orderBy('created_at', 'DESC')->findAll();
        $data['categories'] = $this->categoryModel->getActiveCategories();

        return view('admin/products/index', $data);
    }

    /**
     * Display create product page
     */
    public function createPage()
    {
        $data['title'] = 'Tambah Produk - Admin';
        $data['categories'] = $this->categoryModel->getActiveCategories();

        return view('admin/products/create', $data);
    }

    /**
     * Create product
     */
    public function create()
    {
        $file = $this->request->getFile('gambar');

        $imageName = null;
        if ($file && $file->isValid()) {
            // Validate file
            $validation = $this->validateFile($file);
            if (!$validation['valid']) {
                return redirect()->back()->with('errors', $validation['errors']);
            }

            // Generate unique filename
            $imageName = $this->generateUniqueFilename($file);
            $file->move(WRITEPATH . 'uploads/products', $imageName);
        }

        $data = [
            'category_id' => $this->request->getPost('category_id'),
            'nama' => $this->request->getPost('nama'),
            'slug' => $this->generateSlug($this->request->getPost('nama')),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga' => (float) $this->request->getPost('harga'),
            'stok' => (int) $this->request->getPost('stok'),
            'berat' => $this->request->getPost('berat') ? (int) $this->request->getPost('berat') : null,
            'image' => $imageName,
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->productModel->insert($data);

        if ($result) {
            return redirect()->to('/admin/produk')->with('success', [
                'message' => 'Produk berhasil ditambahkan'
            ]);
        }

        return redirect()->back()->with('errors', $this->productModel->errors())->withInput();
    }

    /**
     * Display edit product page
     */
    public function edit(int $id)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            return redirect()->to('/admin/produk')->with('errors', [
                'message' => 'Produk tidak ditemukan'
            ]);
        }

        $data['title'] = 'Edit Produk - Admin';
        $data['product'] = $product;
        $data['categories'] = $this->categoryModel->getActiveCategories();

        return view('admin/products/edit', $data);
    }

    /**
     * Update product
     */
    public function update(int $id)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            return redirect()->to('/admin/produk')->with('errors', [
                'message' => 'Produk tidak ditemukan'
            ]);
        }

        $file = $this->request->getFile('gambar');
        $imageName = $product['image'];

        if ($file && $file->getTempName()) {
            // Validate file
            $validation = $this->validateFile($file);
            if (!$validation['valid']) {
                return redirect()->back()->with('errors', $validation['errors']);
            }

            // Delete old image
            if ($imageName) {
                $oldPath = WRITEPATH . 'uploads/products/' . $imageName;
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Generate unique filename
            $imageName = $this->generateUniqueFilename($file);
            $file->move(WRITEPATH . 'uploads/products', $imageName);
        }

        $data = [
            'category_id' => $this->request->getPost('category_id'),
            'nama' => $this->request->getPost('nama'),
            'slug' => $this->generateSlug($this->request->getPost('nama')),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga' => (float) $this->request->getPost('harga'),
            'stok' => (int) $this->request->getPost('stok'),
            'berat' => $this->request->getPost('berat') ? (int) $this->request->getPost('berat') : null,
            'image' => $imageName,
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->productModel->update($id, $data);

        if ($result) {
            return redirect()->to('/admin/produk')->with('success', [
                'message' => 'Produk berhasil diperbarui'
            ]);
        }

        return redirect()->back()->with('errors', $this->productModel->errors())->withInput();
    }

    /**
     * Delete product
     */
    public function delete(int $id)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            return redirect()->to('/admin/produk')->with('errors', [
                'message' => 'Produk tidak ditemukan'
            ]);
        }

        // Delete image
        if ($product['image']) {
            $imagePath = WRITEPATH . 'uploads/products/' . $product['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $this->productModel->delete($id);

        return redirect()->to('/admin/produk')->with('success', [
            'message' => 'Produk berhasil dihapus'
        ]);
    }

    /**
     * Validate uploaded file
     */
    private function validateFile(UploadedFile $file): array
    {
        if ($file->getError() !== UPLOAD_ERR_OK) {
            return ['valid' => false, 'errors' => ['gambar' => 'Gagal mengunggah file']];
        }

        if ($file->getSize() > 2 * 1024 * 1024) {
            return ['valid' => false, 'errors' => ['gambar' => 'Ukuran file maksimal 2MB']];
        }

        $allowedMime = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (!in_array($file->getType(), $allowedMime)) {
            return ['valid' => false, 'errors' => ['gambar' => 'Tipe file tidak valid. Hanya JPG, PNG, WEBP yang diizinkan']];
        }

        return ['valid' => true, 'errors' => []];
    }

    /**
     * Generate unique filename
     */
    private function generateUniqueFilename(UploadedFile $file): string
    {
        $extension = $file->getExtension();
        return uniqid('produk_', true) . '.' . $extension;
    }

    /**
     * Generate slug
     */
    private function generateSlug(string $nama): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $nama)));
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');

        // Check if slug exists, append number if needed
        $count = 1;
        $originalSlug = $slug;
        while ($this->productModel->where('slug', $slug)->first()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}