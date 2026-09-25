<?php
$product = $product ?? (object)[];
$categories = $categories ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Admin</title>

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
                </ul>
            </nav>

            <main class="col-md-9 col-lg-10 ms-auto">
                <div class="p-4">
                    <h1 class="fw-bold mb-4">Edit Produk</h1>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= esc($error) ?></div>
                    <?php endif; ?>

                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?= esc($success) ?></div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-body">
                            <form action="<?= base_url('/admin/produk/' . ($product->id ?? 0) . '/update') ?>" method="POST" enctype="multipart/form-data" id="productForm">
                                <?= csrf_field() ?>

                                <div class="row">
                                    <div class="col-md-8">
                                        <h5 class="mb-3">Informasi Produk</h5>

                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama Produk *</label>
                                            <input type="text" class="form-control" id="nama" name="nama" required
                                                   value="<?= esc($product->nama ?? '') ?>" placeholder="Nama produk">
                                        </div>

                                        <div class="mb-3">
                                            <label for="slug" class="form-label">Slug *</label>
                                            <input type="text" class="form-control" id="slug" name="slug"
                                                   value="<?= esc($product->slug ?? '') ?>" placeholder="slug-produk" required>
                                            <small class="text-muted">Unik, tanpa spasi</small>
                                        </div>

                                        <div class="mb-3">
                                            <label for="kategori_id" class="form-label">Kategori *</label>
                                            <select class="form-select" id="kategori_id" name="kategori_id" required>
                                                <option value="">Pilih kategori</option>
                                                <?php foreach ($categories as $category): ?>
                                                    <option value="<?= esc($category->id ?? $category['id']) ?>"
                                                        <?= (($category->id ?? $category['id']) == ($product->kategori_id ?? '')) ? 'selected' : '' ?>>
                                                        <?= esc($category->nama ?? $category['nama']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="harga" class="form-label">Harga (Rp) *</label>
                                            <input type="number" class="form-control" id="harga" name="harga" required min="0" step="1000"
                                                   value="<?= esc($product->harga ?? 0) ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="stok" class="form-label">Stok *</label>
                                            <input type="number" class="form-control" id="stok" name="stok" required min="0"
                                                   value="<?= esc($product->stok ?? 0) ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="berat" class="form-label">Berat (gram)</label>
                                            <input type="number" class="form-control" id="berat" name="berat" min="0"
                                                   value="<?= esc($product->berat ?? '') ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="deskripsi" class="form-label">Deskripsi</label>
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" placeholder="Deskripsi produk..."><?= esc($product->deskripsi ?? '') ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <h5 class="mb-3">Gambar Produk</h5>

                                        <?php if (isset($product->image) && $product->image): ?>
                                            <div id="imagePreview" class="mb-3">
                                                <img src="<?= base_url('uploads/products/' . $product->image) ?>"
                                                     alt="Preview" class="img-fluid rounded" style="max-height: 200px; width: 100%; object-fit: cover;">
                                                <small class="text-muted">Kosongkan untuk mempertahankan gambar saat ini</small>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!isset($product->image) || !$product->image): ?>
                                            <div class="mb-3">
                                                <label for="new_image" class="form-label">Upload Gambar *</label>
                                                <input class="form-control" type="file" id="new_image" name="new_image" accept="image/*" required>
                                                <small class="text-muted">Format: JPG, PNG (maks 2MB)</small>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (isset($product->image) && $product->image): ?>
                                            <div class="mb-3">
                                                <label for="new_image" class="form-label">Ganti Gambar (Opsional)</label>
                                                <input class="form-control" type="file" id="new_image" name="new_image" accept="image/*">
                                                <small class="text-muted">Format: JPG, PNG (maks 2MB)</small>
                                            </div>
                                        <?php endif; ?>

                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                                                   <?= (isset($product->is_active) ? ($product->is_active ? 'checked' : '') : 'checked') ?>>
                                            <label class="form-check-label" for="is_active">Produk Aktif</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    <a href="<?= base_url('/admin/produk') ?>" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Image preview
        document.getElementById('new_image')?.addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');

            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (preview) {
                        preview.innerHTML = '<img src="' + e.target.result + '" class="img-fluid rounded" style="max-height: 200px; width: 100%; object-fit: cover;">';
                    }
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
</body>
</html>