<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        // Check if table already exists using query
        $query = $this->db->query("SHOW TABLES LIKE 'transactions'");
        if ($query->getNumRows() > 0) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'invoice_number' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'nama_penerima' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'telepon' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'alamat_lengkap' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'kota' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'provinsi' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'kode_pos' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'metode_bayar' => [
                'type' => "ENUM('transfer','cod','qris')",
                'null' => false,
            ],
            'subtotal' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'unsigned' => true,
                'default' => 0,
            ],
            'ongkos_kirim' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'unsigned' => true,
                'default' => 0,
            ],
            'total' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'unsigned' => true,
                'default' => 0,
            ],
            'status' => [
                'type' => "ENUM('pending','processing','shipped','completed','cancelled')",
                'default' => 'pending',
            ],
            'catatan' => [
                'type' => 'TEXT',
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
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addUniqueKey('invoice_number');
        $this->forge->addKey('status');
        $this->forge->addKey('created_at');
        $this->forge->addKey('metode_bayar');
        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions', true);
    }
}