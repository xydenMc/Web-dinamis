<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    protected $allowedFields = [
        'nama_produk',
        'deskripsi',
        'kategori',
        'harga',
        'stok',
        'status',
        'gambar'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
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
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;

    public function getProduk()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    public function getProdukById($id)
    {
        return $this->find($id);
    }

    public function getProdukByKategori($kategori)
    {
        return $this->where('kategori', $kategori)->findAll();
    }

    public function getProdukAktif()
    {
        return $this->where('status', 'aktif')->orderBy('created_at', 'DESC')->findAll();
    }
}
