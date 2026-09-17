<?php

namespace App\Models;

use CodeIgniter\Model;

class VideoModel extends Model
{
    protected $table = 'videos';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'judul',
        'youtube_id',
        'deskripsi',
        'urutan',
        'is_active',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'judul' => 'required|min_length[3]|max_length[255]',
        'youtube_id' => 'required',
        'urutan' => 'permit_empty|integer|greater_than_equal_to[0]'
    ];

    protected $validationMessages = [
        'judul' => [
            'required' => 'Judul video wajib diisi.',
            'min_length' => 'Judul video minimal 3 karakter.'
        ],
        'youtube_id' => [
            'required' => 'ID YouTube video wajib diisi.'
        ]
    ];

    /**
     * Get active videos ordered by urutan
     */
    public function getActiveVideos(): array
    {
        return $this->where('is_active', 1)
                    ->orderBy('urutan', 'ASC')
                    ->findAll();
    }

    /**
     * Extract YouTube ID from URL
     */
    public static function extractYoutubeId(string $url): string
    {
        $patterns = [
            '/(?:https?:\/\/)?(?:www\.|youtube\.com\/)(?:watch\?v=|embed\/|v\/)([^?&]+)/',
            '/(?:https?:\/\/)?(?:www\.|)youtu\.be\/([^?&]+)/'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return $url;
    }

    /**
     * Get YouTube thumbnail URL
     */
    public static function getYoutubeThumbnail(string $youtubeId, string $quality = 'hqdefault'): string
    {
        return "https://img.youtube.com/vi/{$youtubeId}/{$quality}.jpg";
    }

    /**
     * Get video embed URL
     */
    public static function getEmbedUrl(string $youtubeId): string
    {
        return "https://www.youtube.com/embed/{$youtubeId}";
    }
}