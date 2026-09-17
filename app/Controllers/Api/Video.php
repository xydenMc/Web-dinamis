<?php

namespace App\Controllers\Api;

use App\Models\VideoModel;
use CodeIgniter\Controller;

class Video extends BaseController
{
    protected $videoModel;

    public function __construct()
    {
        $this->videoModel = new VideoModel();
    }

    /**
     * API: Get videos list
     */
    public function index()
    {
        $videos = $this->videoModel->getActiveVideos();

        $result = [
            'status' => 'success',
            'data' => []
        ];

        foreach ($videos as $video) {
            $result['data'][] = [
                'id' => $video['id'],
                'judul' => $video['judul'],
                'youtube_id' => $video['youtube_id'],
                'embed_url' => VideoModel::getEmbedUrl($video['youtube_id']),
                'thumbnail_url' => VideoModel::getYoutubeThumbnail($video['youtube_id']),
                'deskripsi' => $video['deskripsi'],
                'urutan' => $video['urutan'],
                'is_active' => (bool) $video['is_active'],
                'created_at' => $video['created_at']
            ];
        }

        return $this->response->setJSON($result);
    }
}