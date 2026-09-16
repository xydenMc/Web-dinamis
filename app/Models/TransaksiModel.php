<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $allowedFields = [
        'nomor_transaksi',
        'id_pelanggan',
        'tanggal',
        'total_harga',
        'total_item',
        'status',
        'metode_pembayaran',
        'catatan',
        'alamat_kirim',
        'nomor_telepon'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'nomor_transaksi' => [
            'rules'  => 'required|is_unique[transaksi.nomor_transaksi,id_transaksi,{id_transaksi}]',
            'errors' => [
                'required' => 'Nomor transaksi wajib diisi.',
                'is_unique' => 'Nomor transaksi sudah ada.'
            ]
        ],
        'total_harga' => [
            'rules'  => 'required|numeric|greater_than[0]',
            'errors' => [
                'required' => 'Total harga wajib diisi.',
                'numeric' => 'Total harga harus berupa angka.',
                'greater_than' => 'Total harga harus lebih dari 0.'
            ]
        ],
        'status' => [
            'rules'  => 'required|in_list[Pending,Diproses,Selesai,Dibatalkan]',
            'errors' => [
                'required' => 'Status wajib diisi.',
                'in_list' => 'Status tidak valid.'
            ]
        ]
    ];

    public function getTransaksiByStatus($status)
    {
        return $this->where('status', $status)->orderBy('tanggal', 'DESC')->findAll();
    }

    public function getTransaksiById($id)
    {
        return $this->where('id_transaksi', $id)->first();
    }

    public function getTransaksiByPelanggan($id_pelanggan)
    {
        return $this->where('id_pelanggan', $id_pelanggan)->orderBy('tanggal', 'DESC')->findAll();
    }

    public function getTransaksiTerbaru($limit = 10)
    {
        return $this->orderBy('tanggal', 'DESC')->limit($limit)->findAll();
    }

    public function getTotalPendapatan($status = 'Selesai')
    {
        $builder = $this->db->table('transaksi');
        $query = $builder->select('SUM(total_harga) as total')
            ->where('status', $status)
            ->get();
        $result = $query->getRowArray();
        return $result['total'] ?? 0;
    }

    public function getCountByStatus($status)
    {
        return $this->where('status', $status)->countAllResults();
    }

    public function getTransaksiWithDetails($id_transaksi)
    {
        $detailModel = new DetailTransaksiModel();
        $transaksi = $this->find($id_transaksi);
        if ($transaksi) {
            $transaksi['detail'] = $detailModel->getDetailWithProduk($id_transaksi);
        }
        return $transaksi;
    }

    public function getDashboardStats()
    {
        $builder = $this->db->table('detail_transaksi dt');
        $builder->select('SUM(dt.jumlah) as total')
            ->join('transaksi t', 'dt.id_transaksi = t.id_transaksi')
            ->where('t.status', 'Selesai');

        $result = $builder->get()->getRowArray();
        return $result['total'] ?? 0;
    }
}