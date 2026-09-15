<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';

    protected $allowedFields = [
        'nama_kategori',
        'gambar',
        'deskripsi',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'nama_kategori' => [
            'rules'  => 'required|min_length[3]|max_length[100]|is_unique[kategori.nama_kategori,id_kategori,{id_kategori}]',
            'errors' => [
                'required' => 'Nama kategori wajib diisi.',
                'min_length' => 'Nama kategori minimal 3 karakter.',
                'max_length' => 'Nama kategori maksimal 100 karakter.',
                'is_unique' => 'Nama kategori sudah ada.'
            ]
        ]
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;

    public function getKategoriAktif()
    {
        return $this->where('status', 'aktif')->findAll();
    }

    public function getKategoriById($id)
    {
        return $this->find($id);
    }

    public function getProductCountByKategori()
    {
        $builder = $this->db->table('produk');
        $query = $builder->select('produk.kategori, COUNT(*) as jumlah')
            ->where('produk.status', 'aktif')
            ->groupBy('produk.kategori')
            ->get();

        return $query->getResultArray();
    }
}