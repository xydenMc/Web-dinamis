<?php

namespace App\Controllers\Admin;

use App\Models\ProdukModel;

class StoreProducts extends BaseController
{
    protected ProdukModel $products;

    public function __construct()
    {
        $this->products = new ProdukModel();
    }

    public function index()
    {
        return view('admin/store_products', [
            'title' => 'Kelola Produk - Griya Pot Bunga',
            'products' => $this->products->orderBy('nama_produk', 'ASC')->findAll(),
        ]);
    }

    public function update(int $id)
    {
        $product = $this->products->find($id);
        if (!$product) {
            return redirect()->to('/admin/kelola-produk')->with('error', 'Produk tidak ditemukan.');
        }

        $rules = [
            'nama_produk' => 'required|min_length[3]|max_length[255]',
            'kategori' => 'permit_empty|max_length[100]',
            'deskripsi' => 'permit_empty|max_length[5000]',
            'gambar' => 'permit_empty|max_length[500]',
            'harga' => 'required|numeric|greater_than_equal_to[0]',
            'stok' => 'required|integer|greater_than_equal_to[0]',
            'status' => 'required|in_list[aktif,non aktif]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->to('/admin/kelola-produk')->with('error', implode(' ', $this->validator->getErrors()));
        }

        $this->products->update($id, [
            'nama_produk' => trim((string) $this->request->getPost('nama_produk')),
            'kategori' => trim((string) $this->request->getPost('kategori')),
            'deskripsi' => trim((string) $this->request->getPost('deskripsi')),
            'gambar' => trim((string) $this->request->getPost('gambar')),
            'harga' => (int) $this->request->getPost('harga'),
            'stok' => (int) $this->request->getPost('stok'),
            'status' => $this->request->getPost('status'),
        ]);

        return redirect()->to('/admin/kelola-produk')->with('success', 'Produk berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        if (!$this->products->find($id)) {
            return redirect()->to('/admin/kelola-produk')->with('error', 'Produk tidak ditemukan.');
        }

        $this->products->delete($id);
        return redirect()->to('/admin/kelola-produk')->with('success', 'Produk berhasil dihapus.');
    }
}
