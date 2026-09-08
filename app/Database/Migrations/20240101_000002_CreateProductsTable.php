<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->addField([
            'id_produk' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_produk' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'harga' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'stok' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['aktif', 'non-aktif'],
                'default'    => 'aktif',
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_produk', true);
        $this->forge->createTable('produk');

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('produk');
    }
}