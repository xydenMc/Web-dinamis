<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use CodeIgniter\Controller;

class Toko extends Controller
{
    protected $produkModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        $data['produks'] = $this->produkModel->getProduk();
        $data['title'] = 'Griya Pot Bunga - Toko Pot dan Tanaman Hias';
        $data['user'] = null;
        $data['role'] = null;

        // Perbaikan: cek logged_in atau role
        if (session()->get('logged_in')) {
            $data['user'] = session()->get('username');
            $data['role'] = session()->get('role');
        }

        return view('toko_view', $data);
    }

    public function tambah()
    {
        if ($this->request->getMethod() === 'POST') {
            $validation = $this->validate([
                'nama_produk' => [
                    'rules'  => 'required|min_length[3]|max_length[255]',
                    'errors' => [
                        'required' => 'Nama produk wajib diisi.',
                        'min_length' => 'Nama produk minimal 3 karakter.',
                        'max_length' => 'Nama produk maksimal 255 karakter.'
                    ]
                ],
                'harga' => [
                    'rules'  => 'required|numeric|greater_than_equal_to[0]',
                    'errors' => [
                        'required' => 'Harga wajib diisi.',
                        'numeric' => 'Harga harus berupa angka.',
                        'greater_than_equal_to' => 'Harga tidak boleh negatif.'
                    ]
                ],
                'stok' => [
                    'rules'  => 'required|numeric|greater_than_equal_to[0]',
                    'errors' => [
                        'required' => 'Stok wajib diisi.',
                        'numeric' => 'Stok harus berupa angka.',
                        'greater_than_equal_to' => 'Stok tidak boleh negatif.'
                    ]
                ]
            ]);

            if ($validation) {
                $data = [
                    'nama_produk' => $this->request->getPost('nama_produk'),
                    'deskripsi'   => $this->request->getPost('deskripsi'),
                    'kategori'    => $this->request->getPost('kategori'),
                    'harga'       => (int) $this->request->getPost('harga'),
                    'stok'        => (int) $this->request->getPost('stok'),
                    'status'      => $this->request->getPost('status') ?? 'aktif',
                    'gambar'      => $this->request->getPost('gambar')
                ];

                $this->produkModel->insert($data);

                return redirect()->to('/katalog')->with('success', 'Produk berhasil ditambahkan.');
            } else {
                return redirect()->to('/katalog')->with('errors', $this->validator->getErrors());
            }
        }

        return redirect()->to('/katalog');
    }

    public function hapus($id = null)
    {
        if ($id === null) {
            return redirect()->to('/katalog');
        }

        $produk = $this->produkModel->find($id);

        if ($produk) {
            $this->produkModel->delete($id);
            return redirect()->to('/katalog')->with('success', 'Produk berhasil dihapus.');
        }

        return redirect()->to('/katalog')->with('error', 'Produk tidak ditemukan.');
    }

    public function edit($id = null)
    {
        if ($id === null) {
            return redirect()->to('/katalog');
        }

        $produk = $this->produkModel->find($id);

        if ($produk) {
            if ($this->request->getMethod() === 'POST') {
                $validation = $this->validate([
                    'nama_produk' => [
                        'rules'  => 'required|min_length[3]|max_length[255]',
                        'errors' => [
                            'required' => 'Nama produk wajib diisi.',
                            'min_length' => 'Nama produk minimal 3 karakter.',
                            'max_length' => 'Nama produk maksimal 255 karakter.'
                        ]
                    ],
                    'harga' => [
                        'rules'  => 'required|numeric|greater_than_equal_to[0]',
                        'errors' => [
                            'required' => 'Harga wajib diisi.',
                            'numeric' => 'Harga harus berupa angka.',
                            'greater_than_equal_to' => 'Harga tidak boleh negatif.'
                        ]
                    ],
                    'stok' => [
                        'rules'  => 'required|numeric|greater_than_equal_to[0]',
                        'errors' => [
                            'required' => 'Stok wajib diisi.',
                            'numeric' => 'Stok harus berupa angka.',
                            'greater_than_equal_to' => 'Stok tidak boleh negatif.'
                        ]
                    ]
                ]);

                if ($validation) {
                    $data = [
                        'nama_produk' => $this->request->getPost('nama_produk'),
                        'deskripsi'   => $this->request->getPost('deskripsi'),
                        'kategori'    => $this->request->getPost('kategori'),
                        'harga'       => (int) $this->request->getPost('harga'),
                        'stok'        => (int) $this->request->getPost('stok'),
                        'status'      => $this->request->getPost('status') ?? 'aktif',
                        'gambar'      => $this->request->getPost('gambar')
                    ];

                    $this->produkModel->update($id, $data);

                    return redirect()->to('/katalog')->with('success', 'Produk berhasil diperbarui.');
                } else {
                    return redirect()->to('/katalog')->with('errors', $this->validator->getErrors());
                }
            }

            $data['produk'] = $produk;
            $data['title'] = 'Edit Produk - Griya Pot Bunga';
            return view('toko_view', $data);
        }

        return redirect()->to('/katalog')->with('error', 'Produk tidak ditemukan.');
    }

    public function apiProduk()
    {
        $produks = $this->produkModel->getProduk();
        return $this->response->setJSON($produks);
    }

    // Tambahkan method ini di kelas Toko
    public function getImageUrl($gambar)
    {
        if (empty($gambar)) {
            return 'https://via.placeholder.com/400x400/f5f5f5/cccccc?text=Produk';
        }

        if (filter_var($gambar, FILTER_VALIDATE_URL)) {
            return $gambar;
        }

        // If relative path, prepend base URL
        return base_url('uploads/' . $gambar);
    }

    // Update method apiProdukById untuk mengembalikan gambar URL yang lengkap
    public function apiProdukById($id = null)
    {
        if ($id === null) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ID tidak diberikan']);
        }

        $produk = $this->produkModel->find($id);

        if ($produk) {
            $produk['gambar_url'] = $this->getImageUrl($produk['gambar']);
            return $this->response->setJSON($produk);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Produk tidak ditemukan']);
    }
}
