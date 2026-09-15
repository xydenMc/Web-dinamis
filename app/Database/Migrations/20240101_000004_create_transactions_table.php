<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('transaksi')) {
            $this->forge->addField([
                'id_transaksi' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'nomor_transaksi' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                ],
                'id_pelanggan' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                ],
                'tanggal' => [
                    'type' => 'DATETIME',
                ],
                'total_harga' => [
                    'type'     => 'INT',
                    'unsigned' => true,
                ],
                'total_item' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],
                'status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['Pending', 'Diproses', 'Selesai', 'Dibatalkan'],
                    'default'    => 'Pending',
                ],
                'metode_pembayaran' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => true,
                ],
                'catatan' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'alamat_kirim' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'nomor_telepon' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'null'       => true,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);

            $this->forge->addKey('id_transaksi', true);
            $this->forge->addUniqueKey('nomor_transaksi');
            $this->forge->createTable('transaksi');
        }

        if (! $this->db->tableExists('detail_transaksi')) {
            $this->forge->addField([
                'id_detail' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'id_transaksi' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],
                'id_produk' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],
                'jumlah' => [
                    'type'     => 'INT',
                    'unsigned' => true,
                ],
                'harga_satuan' => [
                    'type'     => 'INT',
                    'unsigned' => true,
                ],
                'subtotal' => [
                    'type'     => 'INT',
                    'unsigned' => true,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);

            $this->forge->addKey('id_detail', true);
            $this->forge->addForeignKey('id_transaksi', 'transaksi', 'id_transaksi', 'CASCADE', 'CASCADE');
            $this->forge->addForeignKey('id_produk', 'produk', 'id_produk', 'CASCADE', 'CASCADE');
            $this->forge->createTable('detail_transaksi');
        }
    }

    public function down()
    {
        $this->forge->dropTable('detail_transaksi', true);
        $this->forge->dropTable('transaksi', true);
    }
}
