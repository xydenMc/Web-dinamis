<?php $videos = $videos ?? []; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Video - Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Rounded" rel="stylesheet">

    <style>
        :root { --primary: #9f3c16; }
        body { background-color: #f5f5f5; font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar { min-height: 100vh; background-color: #212529; }
        .sidebar .nav-link { color: #adb5bd; padding: 0.75rem 1rem; }
        .sidebar .nav-link:hover { color: white; background-color: #343a40; }
        .sidebar .nav-link.active { color: white; background-color: var(--primary); }
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
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/admin/produk') ?>">Produk</a></li>
                </ul>
            </nav>

            <main class="col-md-9 col-lg-10 ms-auto">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="fw-bold mb-0">Daftar Video</h1>
                        <a href="<?= base_url('/admin/video/create') ?>" class="btn btn-primary">
                            <span class="material-symbols-outlined">add</span>
                            <span class="ms-1">Tambah Video</span>
                        </a>
                    </div>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= esc($error) ?></div>
                    <?php endif; ?>

                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?= esc($success) ?></div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-body">
                            <?php if (count($videos) > 0): ?>
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>thumbnail</th>
                                            <th>Judul</th>
                                            <th>Urutan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($videos as $video):
                                            $vidId = $video->id ?? $video['id'];
                                            $vidJudul = $video->judul ?? $video['judul'];
                                            $vidUrl = $video->youtube_url ?? $video['youtube_url'];
                                            $vidUrutan = $video->urutan ?? $video['urutan'];
                                            $vidActive = $video->is_active ?? $video['is_active'] ?? true;
                                        ?>
                                            <tr>
                                                <td>#<?= esc($vidId) ?></td>
                                                <td>
                                                    <iframe src="https://www.youtube.com/embed/<?= esc(getYouTubeId($vidUrl)) ?>"
                                                            width="80" height="45" style="border: none;" allowfullscreen></iframe>
                                                </td>
                                                <td><?= esc($vidJudul) ?></td>
                                                <td><?= esc($vidUrutan) ?></td>
                                                <td>
                                                    <?php if ($vidActive): ?>
                                                        <span class="badge bg-success">Aktif</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('/admin/video/' . $vidId . '/edit') ?>" class="btn btn-sm btn-outline-primary">
                                                        <span class="material-symbols-outlined">edit</span>
                                                    </a>
                                                    <a href="<?= base_url('/admin/video/' . $vidId . '/delete') ?>" class="btn btn-sm btn-outline-danger"
                                                       onclick="deleteVideo(<?= $vidId ?>)">
                                                        <span class="material-symbols-outlined">delete</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <i class="material-symbols-outlined text-muted" style="font-size: 48px;">video_library</i>
                                    <p class="mt-2 text-muted">Belum ada video</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function deleteVideo(videoId) {
            if (confirm('Yakin ingin menghapus video ini?')) {
                fetch('<?= base_url('/admin/video/') ?>' + videoId + '/delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        _csrf_token: '<?= csrf_hash() ?>'
                    })
                })
                .then(function(response) { return response.json(); })
                .then(function(data) {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Gagal menghapus video');
                    }
                });
            }
        }

        function getYouTubeId(url) {
            var regExp = /^.*(youtu.be\/|(youtu\.)?(embedded|v)\/)(.*)*/;
            var match = url.match(regExp);
            if (match && match[7]) {
                return match[7];
            }
            return '';
        }
    </script>
</body>
</html>