<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Get category IDs
        $categories = $this->db->table('categories')
            ->select('id, slug')
            ->get()
            ->getResultArray();

        $catMap = [];
        foreach ($categories as $cat) {
            $catMap[$cat['slug']] = $cat['id'];
        }

        $data = [
            // Keramik products
            [
                'category_id' => $catMap['keramik'] ?? 1,
                'nama' => 'Pot Bunga Keramik Minimalis',
                'slug' => 'pot-bunga-keramik-minimalis',
                'deskripsi' => 'Pot bunga keramik dengan desain minimalis modern cocok untuk tanaman hias indoor dan meja kerja.',
                'harga' => 85000.00,
                'stok' => 14,
                'berat' => 500,
                'image' => 'products/pot-keramik-minimalis.jpg',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category_id' => $catMap['keramik'] ?? 1,
                'nama' => 'Vas Terakota Klasik Artisan',
                'slug' => 'vas-terakota-klasik-artisan',
                'deskripsi' => 'Vas tanah liat merah bakar tradisional dengan finishing matte halus, mempertahankan sirkulasi akar optimal.',
                'harga' => 95000.00,
                'stok' => 4,
                'berat' => 750,
                'image' => 'products/vas-terakota.jpg',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category_id' => $catMap['keramik'] ?? 1,
                'nama' => 'Pot Relief Flora Etnik',
                'slug' => 'pot-relief-flora-etnik',
                'deskripsi' => 'Ukiran tangan bermotif daun pakis elegan, pilihan ideal untuk tanaman monstera ataupun sansevieria.',
                'harga' => 140000.00,
                'stok' => 19,
                'berat' => 600,
                'image' => 'products/pot-relief.jpg',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category_id' => $catMap['keramik'] ?? 1,
                'nama' => 'Pot Bunga Putih Elegan',
                'slug' => 'pot-bunga-putih-elegan',
                'deskripsi' => 'Pot bunga berwarna putih dengan pola abstrak yang elegan, cocuk untuk ruang tamu dan dapur.',
                'harga' => 110000.00,
                'stok' => 12,
                'berat' => 450,
                'image' => 'products/pot-putih.jpg',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            // Kayu products
            [
                'category_id' => $catMap['kayu'] ?? 2,
                'nama' => 'Set Pot Bunga Kayu Ekstra',
                'slug' => 'set-pot-bunga-kayu-ekstra',
                'deskripsi' => 'Set 3 pot bunga kayu dengan ukuran berbeda, natural finish ramah lingkungan dari kayu jati pilihan.',
                'harga' => 125000.00,
                'stok' => 8,
                'berat' => 1200,
                'image' => 'products/set-kayu.jpg',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category_id' => $catMap['kayu'] ?? 2,
                'nama' => 'Pot Gantung Kayu Cendrawasih',
                'slug' => 'pot-gantung-kayu-cendrawasih',
                'deskripsi' => 'Pot gantung kayu dengan motifs cendrawasih ala alam, cocok untuk dekorasi beranda atau teras.',
                'harga' => 98000.00,
                'stok' => 6,
                'berat' => 800,
                'image' => 'products/pot-gantung-kayu.jpg',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            // Beton products
            [
                'category_id' => $catMap['beton'] ?? 3,
                'nama' => 'Pot Bunga Gantung Beton',
                'slug' => 'pot-bunga-gantung-beton',
                'deskripsi' => 'Pot gantung beton dengan tekstur raw kontemporer dan desain industrial untuk teras maupun balkon.',
                'harga' => 100000.00,
                'stok' => 3,
                'berat' => 900,
                'image' => 'products/pot-gantung-beton.jpg',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category_id' => $catMap['beton'] ?? 3,
                'nama' => 'Pot Silinder Terrazzo Pastel',
                'slug' => 'pot-silinder-terrazzo-pastel',
                'deskripsi' => 'Campuran pecahan marmer alami dengan warna pastel mewah, memberikan aksen eksklusif bagi sudut ruangan.',
                'harga' => 115000.00,
                'stok' => 7,
                'berat' => 650,
                'image' => 'products/pot-terrazzo.jpg',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            // Terakota products
            [
                'category_id' => $catMap['terakota'] ?? 4,
                'nama' => 'Vas Beruk Besar',
                'slug' => 'vas-beruk-besar',
                'deskripsi' => 'Vas berukuran besar dengan bahan terakota merah, cocok untuk tanaman menara seperti palma atau Dracaena.',
                'harga' => 180000.00,
                'stok' => 5,
                'berat' => 1200,
                'image' => 'products/vas-beruk.jpg',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category_id' => $catMap['terakota'] ?? 4,
                'nama' => 'Pot Mini Rustic',
                'slug' => 'pot-mini-rustic',
                'deskripsi' => 'Pot mini dengan finish rustic yang unik, perfect untuk tanaman hias pintu atau jendela.',
                'harga' => 65000.00,
                'stok' => 15,
                'berat' => 300,
                'image' => 'products/pot-mini.jpg',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('products')->insertBatch($data);
    }
}