<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Keramik',
                'slug' => 'keramik',
                'deskripsi' => 'Pot bunga dan gerabah berbahan keramik dengan berbagai ukuran dan motif',
                'image' => null,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama' => 'Kayu',
                'slug' => 'kayu',
                'deskripsi' => 'Pot dan gerabah kayu alami dengan finish natural yang ramah lingkungan',
                'image' => null,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama' => 'Beton',
                'slug' => 'beton',
                'deskripsi' => 'Pot bahan beton dengan tekstur industrial dan desain minimalis',
                'image' => null,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama' => 'Terakota',
                'slug' => 'terakota',
                'deskripsi' => 'Vas dan pot terakota tradisional dengan finishing bakar',
                'image' => null,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('categories')->insertBatch($data);
    }
}