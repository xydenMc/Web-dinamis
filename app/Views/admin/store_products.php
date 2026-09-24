<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box}body{margin:0;background:#fcf9f4;color:#261e1a;font:14px 'Plus Jakarta Sans',sans-serif}.wrap{max-width:1180px;margin:auto;padding:32px 20px}.top,.toolbar,.actions{display:flex;align-items:center;justify-content:space-between;gap:12px}.top{margin-bottom:24px}.title{font:700 30px 'Playfair Display',serif}.muted{color:#71655e}.button{border:0;border-radius:999px;background:#c85a32;color:white;padding:11px 17px;font:600 13px 'Plus Jakarta Sans',sans-serif;text-decoration:none;cursor:pointer}.button.light{background:white;color:#57423b;border:1px solid #eadfcf}.card{background:#ffffffd9;border:1px solid #eadfcf;border-radius:22px;padding:22px;box-shadow:0 10px 28px #352b260a}.notice{padding:12px 16px;border-radius:12px;background:#eef3ee;margin-bottom:18px}.notice.error{background:#fff0ed;color:#9b3d1c}table{border-collapse:collapse;width:100%;margin-top:20px}th{text-align:left;font-size:11px;color:#71655e;text-transform:uppercase;letter-spacing:.06em;padding:12px;border-bottom:1px solid #eadfcf}td{padding:13px 12px;border-bottom:1px solid #f0e9df}input,select{font:inherit;border:1px solid #ded2c4;border-radius:9px;padding:8px;width:100%;min-width:90px;background:white}.edit-form{display:none;grid-template-columns:2fr 1fr 1fr 1fr 1fr 2fr 2fr auto;gap:8px;padding:12px;background:#fcf9f4}.edit-form.open{display:grid}.status{padding:5px 9px;border-radius:999px;background:#eef3ee;color:#45664e;font-size:11px;font-weight:700}.status.off{background:#f2eeee;color:#71655e}.actions{justify-content:flex-start}@media(max-width:720px){.wrap{padding:18px 12px}.card{padding:14px;overflow:auto}.edit-form.open{grid-template-columns:1fr 1fr}.top{align-items:flex-start}.title{font-size:24px}}
    </style>
</head>
<body>
<main class="wrap">
    <header class="top"><div><div class="muted">Griya Pot Bunga / Panel Admin</div><h1 class="title">Kelola Produk</h1><p class="muted">Perbarui nama, harga, stok, dan status produk toko.</p></div><a class="button light" href="<?= base_url('/dashboard') ?>">Kembali ke dashboard</a></header>
    <?php if ($message = session()->getFlashdata('success')): ?><div class="notice"><?= esc($message) ?></div><?php endif; ?>
    <?php if ($message = session()->getFlashdata('error')): ?><div class="notice error"><?= esc($message) ?></div><?php endif; ?>
    <section class="card"><div class="toolbar"><div><strong><?= count($products) ?> produk</strong><div class="muted">Data stok berasal langsung dari tabel produk.</div></div><a class="button" href="<?= base_url('/katalog') ?>">Lihat etalase</a></div>
        <table><thead><tr><th>Nama</th><th>Harga</th><th>Stok</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
        <?php foreach ($products as $product): ?>
            <tr><td><strong><?= esc($product['nama_produk']) ?></strong></td><td>Rp <?= number_format((float) $product['harga'], 0, ',', '.') ?></td><td><?= esc($product['stok']) ?></td><td><span class="status <?= $product['status'] === 'aktif' ? '' : 'off' ?>"><?= esc(ucfirst($product['status'])) ?></span></td><td><div class="actions"><button class="button light" type="button" onclick="toggleEdit(<?= (int) $product['id_produk'] ?>)">Edit</button><form method="post" action="<?= base_url('/admin/kelola-produk/hapus/' . $product['id_produk']) ?>" onsubmit="return confirm('Hapus produk ini dari katalog?')"><?= csrf_field() ?><button class="button" type="submit" style="background:#a83f36">Hapus</button></form></div></td></tr>
            <tr><td colspan="5"><form id="edit-<?= (int) $product['id_produk'] ?>" class="edit-form" method="post" action="<?= base_url('/admin/kelola-produk/edit/' . $product['id_produk']) ?>"><?= csrf_field() ?><input name="nama_produk" aria-label="Nama produk" value="<?= esc($product['nama_produk']) ?>" required minlength="3"><input name="kategori" aria-label="Kategori" value="<?= esc($product['kategori']) ?>"><input type="number" name="harga" aria-label="Harga" min="0" value="<?= esc($product['harga']) ?>" required><input type="number" name="stok" aria-label="Stok" min="0" value="<?= esc($product['stok']) ?>" required><select name="status" aria-label="Status"><option value="aktif" <?= $product['status'] === 'aktif' ? 'selected' : '' ?>>Aktif</option><option value="non aktif" <?= $product['status'] === 'non aktif' ? 'selected' : '' ?>>Non aktif</option></select><input name="gambar" aria-label="URL gambar" value="<?= esc($product['gambar']) ?>" placeholder="URL gambar"><input name="deskripsi" aria-label="Deskripsi" value="<?= esc($product['deskripsi']) ?>" placeholder="Deskripsi"><button class="button" type="submit">Simpan</button></form></td></tr>
        <?php endforeach; ?>
        <?php if (!$products): ?><tr><td colspan="5" class="muted">Belum ada produk.</td></tr><?php endif; ?>
        </tbody></table>
    </section>
</main>
<script>function toggleEdit(id){document.getElementById('edit-'+id).classList.toggle('open')}</script>
</body>
</html>
