<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailTransaksiModel extends Model
{
    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id_detail';

    protected $allowedFields = [
        'id_transaksi',
        'id_produk',
        'jumlah',
        'harga_satuan',
        'subtotal',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getByTransaksi($id_transaksi)
    {
        return $this->where('id_transaksi', $id_transaksi)->findAll();
    }

    public function getTotalByTransaksi($id_transaksi)
    {
        $builder = $this->db->table('detail_transaksi');
        $query = $builder->select('SUM(subtotal) as total')
            ->where('id_transaksi', $id_transaksi)
            ->get();
        $result = $query->getRowArray();
        return $result['total'] ?? 0;
    }

    public function getDetailWithProduk($id_transaksi)
    {
        $builder = $this->db->table('detail_transaksi dt');
        $builder->select('dt.*, p.nama_produk, p.gambar')
            ->join('produk p', 'dt.id_produk = p.id_produk')
            ->where('dt.id_transaksi', $id_transaksi);

        return $builder->get()->getResultArray();
    }
}