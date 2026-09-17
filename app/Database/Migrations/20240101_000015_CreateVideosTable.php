<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVideosTable extends Migration
{
    public function up()
    {
        // Check if table already exists using query
        $query = $this->db->query("SHOW TABLES LIKE 'videos'");
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
            'judul' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'youtube_url' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => false,
            ],
            'urutan' => [
                'type' => 'INT',
                'unsigned' => true,
                'default' => 0,
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'unsigned' => true,
                'default' => 1,
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
        $this->forge->addKey('urutan');
        $this->forge->addKey('is_active');
        $this->forge->createTable('videos');
    }

    public function down()
    {
        $this->forge->dropTable('videos', true);
    }
}