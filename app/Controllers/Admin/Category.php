<?php

namespace App\Controllers\Admin;

use App\Models\CategoryModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\Files\UploadedFile;

class Category extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        helper(['form', 'url']);
    }

    /**
     * Display category list
     */
    public function index()
    {
        $data['title'] = 'Kelola Kategori - Admin';
        $data['categories'] = $this->categoryModel->orderBy('created_at', 'DESC')->findAll();

        return view('admin/categories/index', $data);
    }

    /**
     * Display create category page
     */
    public function createPage()
    {
        $data['title'] = 'Tambah Kategori - Admin';
        return view('admin/categories/create', $data);
    }

    /**
     * Create category
     */
    public function create()
    {
        $file = $this->request->getFile('gambar');

        $imageName = null;
        if ($file && $file->isValid()) {
            $validation = $this->validateFile($file);
            if (!$validation['valid']) {
                return redirect()->back()->with('errors', $validation['errors']);
            }

            $imageName = $this->generateUniqueFilename($file);
            $file->move(WRITEPATH . 'uploads/categories', $imageName);
        }

        $nama = $this->request->getPost('nama');
        $data = [
            'nama' => $nama,
            'slug' => $this->generateSlug($nama),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'image' => $imageName,
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->categoryModel->insert($data);

        if ($result) {
            return redirect()->to('/admin/kategori')->with('success', [
                'message' => 'Kategori berhasil ditambahkan'
            ]);
        }

        return redirect()->back()->with('errors', $this->categoryModel->errors())->withInput();
    }

    /**
     * Display edit category page
     */
    public function edit(int $id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return redirect()->to('/admin/kategori')->with('errors', [
                'message' => 'Kategori tidak ditemukan'
            ]);
        }

        $data['title'] = 'Edit Kategori - Admin';
        $data['category'] = $category;

        return view('admin/categories/edit', $data);
    }

    /**
     * Update category
     */
    public function update(int $id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return redirect()->to('/admin/kategori')->with('errors', [
                'message' => 'Kategori tidak ditemukan'
            ]);
        }

        $file = $this->request->getFile('gambar');
        $imageName = $category['image'];

        if ($file && $file->getTempName()) {
            $validation = $this->validateFile($file);
            if (!$validation['valid']) {
                return redirect()->back()->with('errors', $validation['errors']);
            }

            // Delete old image
            if ($imageName) {
                $oldPath = WRITEPATH . 'uploads/categories/' . $imageName;
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $imageName = $this->generateUniqueFilename($file);
            $file->move(WRITEPATH . 'uploads/categories', $imageName);
        }

        $nama = $this->request->getPost('nama');
        $data = [
            'nama' => $nama,
            'slug' => $this->generateSlug($nama, $category['id']),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'image' => $imageName,
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->categoryModel->update($id, $data);

        if ($result) {
            return redirect()->to('/admin/kategori')->with('success', [
                'message' => 'Kategori berhasil diperbarui'
            ]);
        }

        return redirect()->back()->with('errors', $this->categoryModel->errors())->withInput();
    }

    /**
     * Delete category
     */
    public function delete(int $id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return redirect()->to('/admin/kategori')->with('errors', [
                'message' => 'Kategori tidak ditemukan'
            ]);
        }

        // Delete image
        if ($category['image']) {
            $imagePath = WRITEPATH . 'uploads/categories/' . $category['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $this->categoryModel->delete($id);

        return redirect()->to('/admin/kategori')->with('success', [
            'message' => 'Kategori berhasil dihapus'
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
            return ['valid' => false, 'errors' => ['gambar' => 'Tipe file tidak valid']];
        }

        return ['valid' => true, 'errors' => []];
    }

    /**
     * Generate unique filename
     */
    private function generateUniqueFilename(UploadedFile $file): string
    {
        $extension = $file->getExtension();
        return uniqid('cat_', true) . '.' . $extension;
    }

    /**
     * Generate slug
     */
    private function generateSlug(string $nama, int $notExistId = 0): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $nama)));
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');

        // Check if slug exists, exclude current ID
        $builder = $this->categoryModel->db->table('categories');
        $builder->where('slug', $slug);
        if ($notExistId > 0) {
            $builder->where('id !=', $notExistId);
        }

        if ($builder->countAllResults() > 0) {
            $count = 1;
            $baseSlug = $slug;
            $slug = $baseSlug . '-' . $count;
            while ($builder->where('slug', $slug)->countAllResults() > 0) {
                $count++;
                $slug = $baseSlug . '-' . $count;
            }
        }

        return $slug;
    }
}