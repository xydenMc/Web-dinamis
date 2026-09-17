<?php

namespace App\Controllers\Admin;

use App\Models\VideoModel;
use CodeIgniter\Controller;

class Video extends BaseController
{
    protected $videoModel;

    public function __construct()
    {
        $this->videoModel = new VideoModel();
        helper(['form', 'url']);
    }

    /**
     * Display video list
     */
    public function index()
    {
        $data['title'] = 'Kelola Video - Admin';
        $data['videos'] = $this->videoModel->orderBy('urutan', 'ASC')->findAll();

        return view('admin/videos/index', $data);
    }

    /**
     * Display create video page
     */
    public function createPage()
    {
        $data['title'] = 'Tambah Video - Admin';
        return view('admin/videos/create', $data);
    }

    /**
     * Create video
     */
    public function create()
    {
        $post = $this->request->getPost();

        // Extract YouTube ID from URL if needed
        $youtubeId = VideoModel::extractYoutubeId($post['youtube_url'] ?? $post['youtube_id'] ?? '');

        $data = [
            'judul' => $post['judul'],
            'youtube_id' => $youtubeId,
            'deskripsi' => $post['deskripsi'] ?? '',
            'urutan' => (int) ($post['urutan'] ?? 0),
            'is_active' => $post['is_active'] ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->videoModel->insert($data);

        if ($result) {
            return redirect()->to('/admin/video')->with('success', [
                'message' => 'Video berhasil ditambahkan'
            ]);
        }

        return redirect()->back()->with('errors', $this->videoModel->errors())->withInput();
    }

    /**
     * Display edit video page
     */
    public function edit(int $id)
    {
        $video = $this->videoModel->find($id);

        if (!$video) {
            return redirect()->to('/admin/video')->with('errors', [
                'message' => 'Video tidak ditemukan'
            ]);
        }

        $data['title'] = 'Edit Video - Admin';
        $data['video'] = $video;

        return view('admin/videos/edit', $data);
    }

    /**
     * Update video
     */
    public function update(int $id)
    {
        $video = $this->videoModel->find($id);

        if (!$video) {
            return redirect()->to('/admin/video')->with('errors', [
                'message' => 'Video tidak ditemukan'
            ]);
        }

        $post = $this->request->getPost();

        // Extract YouTube ID from URL if needed
        $youtubeId = VideoModel::extractYoutubeId($post['youtube_url'] ?? $post['youtube_id'] ?? $video['youtube_id']);

        $data = [
            'judul' => $post['judul'],
            'youtube_id' => $youtubeId,
            'deskripsi' => $post['deskripsi'] ?? '',
            'urutan' => (int) ($post['urutan'] ?? 0),
            'is_active' => $post['is_active'] ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->videoModel->update($id, $data);

        if ($result) {
            return redirect()->to('/admin/video')->with('success', [
                'message' => 'Video berhasil diperbarui'
            ]);
        }

        return redirect()->back()->with('errors', $this->videoModel->errors())->withInput();
    }

    /**
     * Delete video
     */
    public function delete(int $id)
    {
        $video = $this->videoModel->find($id);

        if (!$video) {
            return redirect()->to('/admin/video')->with('errors', [
                'message' => 'Video tidak ditemukan'
            ]);
        }

        $this->videoModel->delete($id);

        return redirect()->to('/admin/video')->with('success', [
            'message' => 'Video berhasil dihapus'
        ]);
    }
}