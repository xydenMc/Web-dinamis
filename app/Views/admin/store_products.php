<?php
$products = $products ?? [];
$totalProducts = count($products);
$activeProducts = count(array_filter($products, static fn (array $product): bool => ($product['status'] ?? '') === 'aktif'));
$totalStock = array_sum(array_map(static fn (array $product): int => (int) ($product['stok'] ?? 0), $products));
$inventoryValue = array_sum(array_map(static fn (array $product): float => (float) ($product['harga'] ?? 0) * (int) ($product['stok'] ?? 0), $products));
$categories = array_values(array_unique(array_filter(array_map(static fn (array $product): string => trim((string) ($product['kategori'] ?? '')), $products))));
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Kelola Produk | Griya Pot Bunga') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: {
            primary: '#9f3c16', 'primary-container': '#bf542c', background: '#fcf9f4',
            'surface-container-low': '#f6f3ee', 'surface-container-lowest': '#ffffff',
            'surface-container-high': '#ebe8e3', 'surface-container': '#f0ede9',
            'on-surface': '#1c1c19', 'on-surface-variant': '#57423b', secondary: '#45664e',
            'secondary-container': '#c4e9cb', error: '#ba1a1a', 'error-container': '#ffdad6',
            'primary-fixed': '#ffdbcf', 'tertiary-fixed': '#ffdcc3', 'on-primary-fixed-variant': '#822801',
            'on-tertiary-fixed-variant': '#693c13'
        }, fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] } } };
    </script>
    <style>
        body{font-family:'Plus Jakarta Sans',sans-serif}.edit-row{display:none}.edit-row.open{display:table-row}
        .edit-form-grid{display:grid;grid-template-columns:repeat(4,minmax(150px,1fr));gap:12px}
        .field{width:100%;border:1px solid #ded6ce;border-radius:12px;padding:10px 12px;background:#fff;color:#261e1a;font:inherit}
        .field:focus{outline:2px solid #bf542c;outline-offset:1px}
        @media(max-width:800px){.admin-sidebar{display:none}.admin-content{padding-left:0!important}.edit-form-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
        @media(max-width:520px){.edit-form-grid{grid-template-columns:1fr}}
    </style>
</head>
<body class="min-h-screen bg-background text-on-surface antialiased">
    <aside class="admin-sidebar fixed inset-y-0 left-0 z-30 flex w-72 flex-col justify-between bg-surface-container-low/90 p-6 shadow-[0_1px_12px_rgba(42,30,23,0.06)] backdrop-blur-2xl">
        <div>
            <a class="mb-8 flex items-center gap-3 border-b border-stone-200 pb-6 text-inherit no-underline" href="<?= base_url('/katalog') ?>">
                <span class="material-symbols-outlined grid h-11 w-11 place-items-center rounded-2xl bg-primary text-2xl text-white">potted_plant</span>
                <span><strong class="block text-base">Griya Pot Bunga</strong><small class="text-xs font-semibold uppercase tracking-wider text-primary">Studio Kasongan / Admin</small></span>
            </a>
            <p class="mb-2 px-3 text-xs font-bold uppercase tracking-widest text-on-surface-variant">Menu utama</p>
            <nav class="space-y-1">
                <a class="flex items-center gap-3 rounded-xl px-3 py-3 text-on-surface-variant transition hover:bg-surface-container-high" href="<?= base_url('/dashboard') ?>"><span class="material-symbols-outlined">dashboard</span>Dashboard</a>
                <a aria-current="page" class="flex items-center gap-3 rounded-xl bg-primary-container px-3 py-3 font-semibold text-white" href="<?= base_url('/admin/kelola-produk') ?>"><span class="material-symbols-outlined">potted_plant</span>Kelola Produk</a>
                <a class="flex items-center gap-3 rounded-xl px-3 py-3 text-on-surface-variant transition hover:bg-surface-container-high" href="<?= base_url('/transaksi') ?>"><span class="material-symbols-outlined">local_shipping</span>Pesanan Masuk</a>
                <a class="flex items-center gap-3 rounded-xl px-3 py-3 text-on-surface-variant transition hover:bg-surface-container-high" href="<?= base_url('/admin/laporan') ?>"><span class="material-symbols-outlined">summarize</span>Laporan</a>
            </nav>
            <p class="mb-2 mt-7 px-3 text-xs font-bold uppercase tracking-widest text-on-surface-variant">Akses toko</p>
            <a class="flex items-center gap-3 rounded-xl px-3 py-3 text-on-surface-variant transition hover:bg-surface-container-high" href="<?= base_url('/katalog') ?>"><span class="material-symbols-outlined">storefront</span>Lihat Etalase</a>
        </div>
        <a class="flex items-center gap-3 rounded-xl px-3 py-3 text-on-surface-variant transition hover:bg-error-container hover:text-error" href="<?= base_url('/logout') ?>"><span class="material-symbols-outlined">logout</span>Keluar Sesi Admin</a>
    </aside>

    <div class="admin-content min-h-screen pl-72">
        <header class="sticky top-0 z-20 flex min-h-16 items-center justify-between gap-4 border-b border-stone-200/70 bg-background/90 px-5 py-3 backdrop-blur-xl lg:px-10">
            <div class="min-w-0 text-sm text-on-surface-variant">Griya Pot Bunga <span class="mx-2">/</span><strong class="text-on-surface">Kelola Produk</strong></div>
            <button class="inline-flex shrink-0 items-center gap-2 rounded-full bg-primary px-4 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-primary-container" type="button" onclick="openAddProduct()"><span class="material-symbols-outlined text-lg">add</span><span class="hidden sm:inline">Tambah Produk</span></button>
        </header>

        <main class="mx-auto max-w-[1600px] px-4 py-7 sm:px-6 lg:px-10">
            <div class="mb-7 flex flex-col justify-between gap-4 md:flex-row md:items-end">
                <div><p class="mb-2 text-xs font-bold uppercase tracking-[.16em] text-primary">Studio Kasongan Pottery Suite</p><h1 class="text-3xl font-bold tracking-tight">Kelola Produk &amp; Koleksi Studio</h1><p class="mt-2 max-w-2xl text-sm leading-6 text-on-surface-variant">Perbarui produk yang terhubung langsung ke etalase publik.</p></div>
                <a class="inline-flex items-center gap-2 self-start rounded-full bg-white px-4 py-2.5 text-sm font-semibold text-primary shadow-sm transition hover:bg-surface-container-low md:self-auto" href="<?= base_url('/katalog') ?>"><span class="material-symbols-outlined text-lg">open_in_new</span>Lihat Etalase</a>
            </div>

            <?php if ($message = session()->getFlashdata('success')): ?><div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800"><?= esc($message) ?></div><?php endif; ?>
            <?php if ($message = session()->getFlashdata('error')): ?><div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800"><?= esc($message) ?></div><?php endif; ?>

            <section class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                <article class="rounded-2xl bg-white/80 p-5 shadow-sm"><div class="flex justify-between text-sm text-on-surface-variant"><span>Total produk</span><span class="material-symbols-outlined text-primary">potted_plant</span></div><div class="mt-3 text-3xl font-bold"><?= number_format($totalProducts) ?></div><div class="mt-1 text-xs text-on-surface-variant"><?= number_format($activeProducts) ?> produk aktif</div></article>
                <article class="rounded-2xl bg-white/80 p-5 shadow-sm"><div class="flex justify-between text-sm text-on-surface-variant"><span>Total stok fisik</span><span class="material-symbols-outlined text-secondary">inventory_2</span></div><div class="mt-3 text-3xl font-bold"><?= number_format($totalStock) ?></div><div class="mt-1 text-xs text-on-surface-variant">Jumlah stok dari tabel produk</div></article>
                <article class="rounded-2xl bg-white/80 p-5 shadow-sm"><div class="flex justify-between text-sm text-on-surface-variant"><span>Nilai inventaris</span><span class="material-symbols-outlined text-primary">payments</span></div><div class="mt-3 text-2xl font-bold text-primary">Rp <?= number_format($inventoryValue, 0, ',', '.') ?></div><div class="mt-1 text-xs text-on-surface-variant">Harga produk dikalikan stok</div></article>
            </section>

            <section class="mb-5 flex flex-col gap-3 rounded-2xl bg-white/85 p-4 shadow-sm lg:flex-row lg:items-center">
                <label class="relative min-w-60 flex-1"><span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-lg text-on-surface-variant">search</span><input class="field rounded-full bg-surface-container-low pl-10" id="productSearch" type="search" placeholder="Cari nama produk atau kategori..."></label>
                <select class="field w-full rounded-full bg-surface-container-low lg:w-auto" id="categoryFilter"><option value="all">Semua kategori</option><?php foreach ($categories as $category): ?><option value="<?= esc(mb_strtolower($category, 'UTF-8')) ?>"><?= esc($category) ?></option><?php endforeach; ?></select>
                <select class="field w-full rounded-full bg-surface-container-low lg:w-auto" id="stockFilter"><option value="all">Semua stok</option><option value="safe">Stok aman (&gt;10)</option><option value="low">Stok terbatas (≤10)</option></select>
            </section>

            <section class="overflow-hidden rounded-2xl bg-white/90 shadow-sm">
                <div class="flex flex-col justify-between gap-2 bg-surface-container-low/60 px-5 py-4 sm:flex-row sm:items-center"><div class="flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-primary"></span><h2 class="font-semibold">Daftar Produk</h2><span class="rounded-full bg-surface-container-high px-2.5 py-1 text-xs text-on-surface-variant"><?= number_format($totalProducts) ?> produk</span></div><span class="text-xs text-on-surface-variant">Gambar, harga, dan stok dari data produk.</span></div>
                <div class="w-full overflow-x-auto"><table class="w-full min-w-[940px] border-collapse text-left">
                    <thead class="bg-surface-container-low/50 text-xs uppercase tracking-wider text-on-surface-variant"><tr><th class="px-5 py-3">Produk</th><th class="px-4 py-3">Kategori</th><th class="px-4 py-3">Harga</th><th class="px-4 py-3">Stok</th><th class="px-4 py-3">Status</th><th class="px-5 py-3 text-right">Aksi</th></tr></thead>
                    <tbody id="productRows" class="divide-y divide-stone-100">
                    <?php foreach ($products as $product):
                        $id = (int) ($product['id_produk'] ?? 0);
                        $name = (string) ($product['nama_produk'] ?? 'Produk');
                        $category = trim((string) ($product['kategori'] ?? ''));
                        $stock = (int) ($product['stok'] ?? 0);
                        $image = trim((string) ($product['gambar'] ?? ''));
                        $imageUrl = $image === '' ? '' : (filter_var($image, FILTER_VALIDATE_URL) ? $image : base_url('uploads/' . ltrim($image, '/')));
                        $isActive = ($product['status'] ?? '') === 'aktif';
                    ?>
                        <tr class="product-row transition-colors hover:bg-surface-container-low/50" data-name="<?= esc(mb_strtolower($name . ' ' . $category, 'UTF-8')) ?>" data-category="<?= esc(mb_strtolower($category, 'UTF-8')) ?>" data-stock="<?= $stock ?>">
                            <td class="px-5 py-4"><div class="flex items-center gap-3"><div class="grid h-14 w-14 shrink-0 place-items-center overflow-hidden rounded-xl bg-surface-container text-primary"><?php if ($imageUrl !== ''): ?><img class="h-full w-full object-cover" src="<?= esc($imageUrl) ?>" alt="<?= esc($name) ?>" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.classList.remove('hidden')"><span class="material-symbols-outlined hidden">potted_plant</span><?php else: ?><span class="material-symbols-outlined">potted_plant</span><?php endif; ?></div><div class="min-w-0"><div class="truncate font-semibold"><?= esc($name) ?></div><div class="max-w-[300px] truncate text-xs text-on-surface-variant"><?= esc($product['deskripsi'] ?? 'Koleksi Griya Pot Bunga') ?></div></div></div></td>
                            <td class="px-4 py-4"><span class="inline-flex rounded-full bg-primary-fixed px-2.5 py-1 text-xs font-medium text-on-primary-fixed-variant"><?= esc($category ?: 'Umum') ?></span></td>
                            <td class="whitespace-nowrap px-4 py-4 font-semibold">Rp <?= number_format((float) ($product['harga'] ?? 0), 0, ',', '.') ?></td>
                            <td class="px-4 py-4"><div class="flex items-center gap-2"><span class="font-semibold <?= $stock <= 10 ? 'text-error' : '' ?>"><?= number_format($stock) ?></span><span class="rounded-full px-2 py-0.5 text-xs <?= $stock <= 10 ? 'bg-error-container text-error' : 'bg-secondary-container/80 text-secondary' ?>"><?= $stock <= 10 ? 'Terbatas' : 'Aman' ?></span></div></td>
                            <td class="px-4 py-4"><span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold <?= $isActive ? 'bg-secondary-container text-secondary' : 'bg-surface-container-high text-on-surface-variant' ?>"><span class="h-1.5 w-1.5 rounded-full <?= $isActive ? 'bg-secondary' : 'bg-stone-400' ?>"></span><?= esc(ucfirst((string) ($product['status'] ?? 'non aktif'))) ?></span></td>
                            <td class="px-5 py-4 text-right"><div class="inline-flex items-center gap-2"><button class="rounded-lg bg-surface-container px-3 py-2 text-xs font-semibold transition hover:bg-surface-container-high" type="button" onclick="toggleEdit(<?= $id ?>)">Edit</button><form method="post" action="<?= base_url('/admin/kelola-produk/hapus/' . $id) ?>" onsubmit="return confirm('Hapus produk ini dari katalog?')"><?= csrf_field() ?><button class="rounded-lg bg-primary px-3 py-2 text-xs font-semibold text-white transition hover:bg-primary-container" type="submit">Hapus</button></form></div></td>
                        </tr>
                        <tr class="edit-row bg-surface-container-low/50" id="edit-row-<?= $id ?>"><td class="px-5 py-4" colspan="6"><form class="edit-form-grid" method="post" action="<?= base_url('/admin/kelola-produk/edit/' . $id) ?>"><?= csrf_field() ?><label class="text-xs font-semibold">Nama<input class="field mt-1" name="nama_produk" value="<?= esc($name) ?>" required minlength="3"></label><label class="text-xs font-semibold">Kategori<input class="field mt-1" name="kategori" value="<?= esc($category) ?>"></label><label class="text-xs font-semibold">Harga<input class="field mt-1" name="harga" type="number" min="0" step="1" value="<?= esc($product['harga'] ?? 0) ?>" required></label><label class="text-xs font-semibold">Stok<input class="field mt-1" name="stok" type="number" min="0" step="1" value="<?= $stock ?>" required></label><label class="text-xs font-semibold">Status<select class="field mt-1" name="status"><option value="aktif" <?= $isActive ? 'selected' : '' ?>>Aktif</option><option value="non aktif" <?= !$isActive ? 'selected' : '' ?>>Non aktif</option></select></label><label class="text-xs font-semibold">URL/path foto<input class="field mt-1" name="gambar" value="<?= esc($image) ?>"></label><label class="text-xs font-semibold md:col-span-2">Deskripsi<input class="field mt-1" name="deskripsi" value="<?= esc($product['deskripsi'] ?? '') ?>"></label><div class="flex items-end gap-2"><button class="rounded-xl bg-primary px-4 py-2.5 text-sm font-semibold text-white" type="submit">Simpan</button><button class="rounded-xl bg-white px-4 py-2.5 text-sm font-semibold" type="button" onclick="toggleEdit(<?= $id ?>)">Batal</button></div></form></td></tr>
                    <?php endforeach; ?>
                    <?php if (!$products): ?><tr><td colspan="6" class="px-5 py-10 text-center text-sm text-on-surface-variant">Belum ada produk.</td></tr><?php endif; ?>
                    </tbody>
                </table></div>
            </section>
        </main>
    </div>

    <div id="addProductModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4" onclick="if(event.target===this)closeAddProduct()">
        <form class="w-full max-w-2xl space-y-4 rounded-2xl bg-white p-6 shadow-xl" method="post" action="<?= base_url('/tambah') ?>">
            <?= csrf_field() ?>
            <div class="flex items-center justify-between"><h2 class="text-xl font-bold">Tambah Produk</h2><button type="button" class="rounded-full px-3 py-1 hover:bg-surface-container-low" onclick="closeAddProduct()">Tutup</button></div>
            <div class="grid gap-4 sm:grid-cols-2"><label class="text-sm font-semibold">Nama produk<input class="field mt-1" name="nama_produk" required minlength="3"></label><label class="text-sm font-semibold">Kategori<input class="field mt-1" name="kategori"></label><label class="text-sm font-semibold">Harga (Rp)<input class="field mt-1" name="harga" type="number" min="0" required></label><label class="text-sm font-semibold">Stok<input class="field mt-1" name="stok" type="number" min="0" required></label><label class="text-sm font-semibold sm:col-span-2">URL gambar<input class="field mt-1" name="gambar" type="url" placeholder="https://..."></label><label class="text-sm font-semibold sm:col-span-2">Deskripsi<textarea class="field mt-1" name="deskripsi" rows="3"></textarea></label><label class="text-sm font-semibold">Status<select class="field mt-1" name="status"><option value="aktif">Aktif</option><option value="non aktif">Nonaktif</option></select></label></div>
            <div class="flex justify-end"><button class="rounded-full bg-primary px-5 py-2.5 text-sm font-semibold text-white hover:bg-primary-container" type="submit">Simpan Produk</button></div>
        </form>
    </div>
    <script>
        function openAddProduct() { const modal = document.getElementById('addProductModal'); modal.classList.remove('hidden'); modal.classList.add('flex'); }
        function closeAddProduct() { const modal = document.getElementById('addProductModal'); modal.classList.add('hidden'); modal.classList.remove('flex'); }
        function toggleEdit(id) { document.getElementById('edit-row-' + id)?.classList.toggle('open'); }
        const search = document.getElementById('productSearch');
        const category = document.getElementById('categoryFilter');
        const stock = document.getElementById('stockFilter');
        function filterProducts() {
            const query = (search.value || '').toLocaleLowerCase().trim();
            document.querySelectorAll('.product-row').forEach(row => {
                const matchesQuery = row.dataset.name.includes(query);
                const matchesCategory = category.value === 'all' || row.dataset.category === category.value;
                const amount = Number.parseInt(row.dataset.stock || '0', 10);
                const matchesStock = stock.value === 'all' || (stock.value === 'safe' ? amount > 10 : amount <= 10);
                const visible = matchesQuery && matchesCategory && matchesStock;
                row.hidden = !visible;
                const editor = document.getElementById(row.nextElementSibling?.id || '');
                if (editor?.classList.contains('edit-row')) editor.hidden = !visible;
            });
        }
        search.addEventListener('input', filterProducts);
        category.addEventListener('change', filterProducts);
        stock.addEventListener('change', filterProducts);
    </script>
</body>
</html>
