<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk - Admin</title>

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
    <link rel="stylesheet" href="<?= base_url('css/admin-typography.css') ?>">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-none d-md-block bg-dark sidebar">
                <div class="p-3 mb-4"><h4 class="text-white fw-bold">Admin Panel</h4></div>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?= base_url('/admin/produk') ?>">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/admin/kategori') ?>">Kategori</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/admin/video') ?>">Video</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/admin/transaksi') ?>">Transaksi</a></li>
                </ul>
            </nav>

            <main class="col-md-9 col-lg-10 ms-auto">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="fw-bold mb-0">Daftar Produk</h1>
                        <a href="<?= base_url('/admin/produk/create') ?>" class="btn btn-primary">
                            <span class="material-symbols-outlined">add</span>
                            <span class="ms-1">Tambah Produk</span>
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
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Gambar</th>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $productList = $products ?? []; if (count($productList) > 0): ?>
                                        <?php foreach ($productList as $product): ?>
                                            <tr>
                                                <td>#<?= esc($product['id']) ?></td>
                                                <td>
                                                    <img src="<?= $product['image'] ? base_url('uploads/products/' . $product['image']) : base_url('assets/images/placeholder.png') ?>"
                                                         alt="<?= esc($product['nama']) ?>" class="img-fluid rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                                </td>
                                                <td><?= esc($product['nama']) ?></td>
                                                <td><?= esc($product['category_nama'] ?? '-') ?></td>
                                                <td>Rp <?= number_format($product['harga'], 0, ',', '.') ?></td>
                                                <td><?= esc($product['stok']) ?> pcs</td>
                                                <td>
                                                    <?php if ($product['is_active']): ?>
                                                        <span class="badge bg-success">Aktif</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('/admin/produk/' . $product['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">
                                                        <span class="material-symbols-outlined">edit</span>
                                                    </a>
                                                    <a href="<?= base_url('/admin/produk/' . $product['id']) ?>" class="btn btn-sm btn-outline-danger"
                                                       onclick="deleteProduct(<?= $product['id'] ?>)">
                                                        <span class="material-symbols-outlined">delete</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <i class="material-symbols-outlined text-muted" style="font-size: 48px;">inventory_2</i>
                                                <p class="mt-2 text-muted">Tidak ada produk</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function deleteProduct(id) {
            if (confirm('Yakin ingin menghapus produk ini?')) {
                fetch('<?= base_url('/admin/produk/' + id + '/delete') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        _csrf_token: '<?= csrf_hash() ?>'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
            }
        }
    </script>
</body>
</html>