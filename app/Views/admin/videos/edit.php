<?php
$categories = $categories ?? [];
$video = $video ?? (object)[];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Video - Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Rounded" rel="stylesheet">

    <style>
        :root { --primary: #9f3c16; }
        body { background-color: #f5f5f5; font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar { min-height: 100vh; background-color: #212529; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-none d-md-block bg-dark sidebar">
                <div class="p-3 mb-4"><h4 class="text-white fw-bold">Admin Panel</h4></div>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?= base_url('/admin/video') ?>">Video</a></li>
                </ul>
            </nav>

            <main class="col-md-9 col-lg-10 ms-auto">
                <div class="p-4">
                    <h1 class="fw-bold mb-4">Edit Video</h1>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= esc($error) ?></div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-body">
                            <form action="<?= base_url('/admin/video/' . ($video->id ?? 0) . '/update') ?>" method="POST">
                                <?= csrf_field() ?>

                                <div class="mb-3">
                                    <label for="judul" class="form-label">Judul Video *</label>
                                    <input type="text" class="form-control" id="judul" name="judul" required
                                           value="<?= esc($video->judul ?? '') ?>" placeholder="Judul video">
                                </div>

                                <div class="mb-3">
                                    <label for="youtube_url" class="form-label">URL YouTube *</label>
                                    <input type="url" class="form-control" id="youtube_url" name="youtube_url" required
                                           value="<?= esc($video->youtube_url ?? '') ?>" placeholder="https://www.youtube.com/watch?v=example">
                                    <small class="text-muted">Masukkan URL lengkap video YouTube</small>
                                </div>

                                <div class="mb-3">
                                    <label for="urutan" class="form-label">Urutan Tampil</label>
                                    <input type="number" class="form-control" id="urutan" name="urutan" value="<?= esc($video->urutan ?? 0) ?>" min="0">
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                                           <?= (!$video->is_active ?? true) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="is_active">Video Aktif</label>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    <a href="<?= base_url('/admin/video') ?>" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>