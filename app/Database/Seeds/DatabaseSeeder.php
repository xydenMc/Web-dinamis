<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed admin user
        $this->call('UserSeeder');

        // Seed categories
        $this->call('CategorySeeder');

        // Seed products
        $this->call('ProductSeeder');

        // Seed videos
        $this->call('VideoSeeder');
    }
}