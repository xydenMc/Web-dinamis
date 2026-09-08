<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Hash password menggunakan password_hash()
        $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $customerPassword = password_hash('customer123', PASSWORD_DEFAULT);

        $data = [
            [
                'username'   => 'admin',
                'email'      => 'admin@gmail.com',
                'password'   => $adminPassword,
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'customer',
                'email'      => 'customer@gmail.com',
                'password'   => $customerPassword,
                'role'       => 'customer',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Clear existing users first
        $this->db->table('users')->truncate();

        // Insert new users
        $this->db->table('users')->insertBatch($data);
    }
}