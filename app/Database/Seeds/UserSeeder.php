<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Admin Toko',
                'email' => 'admin@toko.test',
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
                'telepon' => '081234567890',
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama' => 'Customer Demo',
                'email' => 'customer@toko.test',
                'password_hash' => password_hash('customer123', PASSWORD_DEFAULT),
                'telepon' => '082345678901',
                'role' => 'customer',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('users')->insertBatch($data);
    }
}