<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class VideoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'judul' => 'Proses Pembuatan Pot Keramik - Dapur Gerabah',
                'youtube_id' => 'dQw4w9WgXcQ', // Placeholder - replace with actual video ID
                'deskripsi' => 'Temukan proses pembuatan pot keramik dari awal hingga akhir oleh para pengrajin lokal.',
                'urutan' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'judul' => 'Tips Perawatan Pot dan Gerabah',
                'youtube_id' => 'eY5n2jK9t3Q', // Placeholder
                'deskripsi' => 'Bagaimana cara merawat pot dan gerabah yang Anda miliki agar tahan lama?',
                'urutan' => 2,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'judul' => 'Pengrajin Griya Pot Bunga - Kisah Motivasi',
                'youtube_id' => 'aBcDeFgHiJ', // Placeholder
                'deskripsi' => 'Dengarkan kisah motivasi para pengrajin yang berjuang membangun bisnis kerajinan.',
                'urutan' => 3,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('videos')->insertBatch($data);
    }
}