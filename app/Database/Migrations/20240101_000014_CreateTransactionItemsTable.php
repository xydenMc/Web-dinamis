<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionItemsTable extends Migration
{
    public function up()
    {
        // Check if table already exists using query
        $query = $this->db->query("SHOW TABLES LIKE 'transaction_items'");
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
            'transaction_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'product_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'nama_produk' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'harga_satuan' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'unsigned' => true,
                'default' => 0,
            ],
            'qty' => [
                'type' => 'INT',
                'unsigned' => true,
                'default' => 1,
            ],
            'subtotal' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'unsigned' => true,
                'default' => 0,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('transaction_id');
        $this->forge->addKey('product_id');
        $this->forge->createTable('transaction_items');
    }

    public function down()
    {
        $this->forge->dropTable('transaction_items', true);
    }
}