<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use CodeIgniter\Controller;

class AdminKategori extends Controller
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $data['title'] = 'Kelola Kategori - Griya Pot Bunga';
        $data['user'] = session()->get('username');
        $data['role'] = session()->get('role');
        $data['kategoris'] = $this->kategoriModel->findAll();

        return view('admin/kategori_view', $data);
    }

    public function tambah()
    {
        if ($this->request->getMethod() === 'POST') {
            $validation = $this->validate([
                'nama_kategori' => [
                    'rules'  => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required' => 'Nama kategori wajib diisi.',
                        'min_length' => 'Nama kategori minimal 3 karakter.',
                        'max_length' => 'Nama kategori maksimal 100 karakter.'
                    ]
                ]
            ]);

            if ($validation) {
                $data = [
                    'nama_kategori' => $this->request->getPost('nama_kategori'),
                    'gambar' => $this->request->getPost('gambar'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'status' => $this->request->getPost('status') ?? 'aktif'
                ];

                $this->kategoriModel->insert($data);

                return redirect()->to('/dashboard')->with('success', 'Kategori berhasil ditambahkan.');
            } else {
                return redirect()->to('/dashboard')->with('errors', $this->validator->getErrors());
            }
        }

        return redirect()->to('/dashboard');
    }

    public function edit($id = null)
    {
        if ($id === null) {
            return redirect()->to('/dashboard')->with('error', 'ID kategori tidak diberikan.');
        }

        if ($this->request->getMethod() === 'POST') {
            $validation = $this->validate([
                'nama_kategori' => [
                    'rules'  => 'required|min_length[3]|max_length[100]|is_unique[kategori.nama_kategori,id_kategori,' . $id . ']',
                    'errors' => [
                        'required' => 'Nama kategori wajib diisi.',
                        'min_length' => 'Nama kategori minimal 3 karakter.',
                        'max_length' => 'Nama kategori maksimal 100 karakter.',
                        'is_unique' => 'Nama kategori sudah ada.'
                    ]
                ]
            ]);

            if ($validation) {
                $data = [
                    'nama_kategori' => $this->request->getPost('nama_kategori'),
                    'gambar' => $this->request->getPost('gambar'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'status' => $this->request->getPost('status') ?? 'aktif'
                ];

                $this->kategoriModel->update($id, $data);

                return redirect()->to('/dashboard')->with('success', 'Kategori berhasil diperbarui.');
            } else {
                return redirect()->to('/dashboard')->with('errors', $this->validator->getErrors());
            }
        }

        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) {
            return redirect()->to('/dashboard')->with('error', 'Kategori tidak ditemukan.');
        }

        $data['kategori'] = $kategori;
        $data['title'] = 'Edit Kategori - Griya Pot Bunga';
        $data['user'] = session()->get('username');
        $data['role'] = session()->get('role');

        return view('admin/kategori_view', $data);
    }

    public function hapus($id = null)
    {
        if ($id === null) {
            return redirect()->to('/dashboard')->with('error', 'ID kategori tidak diberikan.');
        }

        $kategori = $this->kategoriModel->find($id);

        if ($kategori) {
            // Cek apakah kategori masih digunakan oleh produk
            $produkModel = new \App\Models\ProdukModel();
            $produkCount = $produkModel->where('kategori', $kategori['nama_kategori'])->countAllResults();

            if ($produkCount > 0) {
                return redirect()->to('/dashboard')->with('error', 'Kategori masih digunakan oleh ' . $produkCount . ' produk. Hapus produk terlebih dahulu.');
            }

            $this->kategoriModel->delete($id);
            return redirect()->to('/dashboard')->with('success', 'Kategori berhasil dihapus.');
        }

        return redirect()->to('/dashboard')->with('error', 'Kategori tidak ditemukan.');
    }
}