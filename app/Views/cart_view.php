<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-stone-50 font-[Plus_Jakarta_Sans] text-stone-800">
    <header class="border-b border-stone-200 bg-white">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-4 py-5">
            <a href="<?= base_url('katalog') ?>" class="inline-flex items-center gap-2 font-semibold text-stone-700 hover:text-[#9f3c16]">
                <span class="material-symbols-outlined">arrow_back</span> Lanjut belanja
            </a>
            <span class="font-bold text-[#9f3c16]">Griya Pot Bunga</span>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-10">
        <h1 class="mb-2 text-3xl font-bold">Keranjang Belanja</h1>
        <p class="mb-7 text-stone-500"><?= esc((string) $totalItem) ?> produk dalam keranjang</p>

        <?php if ($successMessage = flash_message('success')): ?>
            <div class="mb-6 flex items-center gap-2 rounded-2xl bg-green-100 px-5 py-4 font-semibold text-green-800">
                <span class="material-symbols-outlined">check_circle</span><?= esc($successMessage) ?>
            </div>
        <?php endif; ?>
        <?php if ($errorMessage = flash_message('error')): ?>
            <div class="mb-6 flex items-center gap-2 rounded-2xl bg-red-100 px-5 py-4 font-semibold text-red-800">
                <span class="material-symbols-outlined">error</span><?= esc($errorMessage) ?>
            </div>
        <?php endif; ?>

        <?php if ($cart === []): ?>
            <section class="rounded-3xl bg-white px-6 py-16 text-center shadow-sm">
                <span class="material-symbols-outlined text-6xl text-stone-300">shopping_cart</span>
                <h2 class="mt-4 text-xl font-bold">Keranjang masih kosong</h2>
                <p class="mt-2 text-stone-500">Tambahkan produk dari katalog untuk mulai berbelanja.</p>
                <a href="<?= base_url('katalog') ?>" class="mt-6 inline-flex rounded-full bg-[#9f3c16] px-5 py-3 font-semibold text-white">Buka katalog</a>
            </section>
        <?php else: ?>
            <div class="grid gap-6 lg:grid-cols-[1fr_320px]">
                <section class="overflow-hidden rounded-3xl bg-white shadow-sm">
                    <?php foreach ($cart as $item): ?>
                        <?php $image = !empty($item['gambar']) && filter_var($item['gambar'], FILTER_VALIDATE_URL) ? $item['gambar'] : (!empty($item['gambar']) ? base_url('uploads/' . $item['gambar']) : ''); ?>
                        <article class="flex gap-4 border-b border-stone-100 p-5 last:border-0" data-product-id="<?= esc((string) $item['id_produk']) ?>">
                            <?php if ($image !== ''): ?>
                                <img src="<?= esc($image) ?>" alt="<?= esc($item['nama_produk']) ?>" class="h-20 w-20 rounded-2xl object-cover">
                            <?php else: ?>
                                <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-stone-100 text-3xl">🪴</div>
                            <?php endif; ?>
                            <div class="min-w-0 flex-1">
                                <h2 class="font-bold"><?= esc($item['nama_produk']) ?></h2>
                                <p class="mt-1 text-sm text-stone-500">Rp <?= number_format((float) $item['harga'], 0, ',', '.') ?></p>
                                <div class="mt-3 flex items-center justify-between gap-3">
                                    <div class="flex items-center rounded-full border border-stone-200">
                                        <button type="button" class="px-3 py-1.5" onclick="changeQuantity(<?= esc((int) $item['id_produk']) ?>, <?= esc((int) $item['quantity'] - 1) ?>)">−</button>
                                        <span class="min-w-8 text-center text-sm font-semibold"><?= esc((string) $item['quantity']) ?></span>
                                        <button type="button" class="px-3 py-1.5" onclick="changeQuantity(<?= esc((int) $item['id_produk']) ?>, <?= esc((int) $item['quantity'] + 1) ?>)">+</button>
                                    </div>
                                    <button type="button" class="inline-flex items-center gap-1 text-sm font-semibold text-red-600" onclick="removeItem(<?= esc((int) $item['id_produk']) ?>)">
                                        <span class="material-symbols-outlined text-lg">delete</span> Hapus
                                    </button>
                                </div>
                            </div>
                            <strong class="whitespace-nowrap">Rp <?= number_format((float) $item['subtotal'], 0, ',', '.') ?></strong>
                        </article>
                    <?php endforeach; ?>
                </section>

                <aside class="h-fit rounded-3xl bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-bold">Ringkasan Belanja</h2>
                    <div class="mt-5 flex justify-between text-stone-600"><span>Subtotal</span><strong>Rp <?= number_format((float) $subtotal, 0, ',', '.') ?></strong></div>
                    <div class="mt-3 flex justify-between text-stone-600"><span>Pengiriman</span><span>Dihitung saat checkout</span></div>
                    <a href="<?= base_url('checkout') ?>" class="mt-6 flex w-full items-center justify-center gap-2 rounded-full bg-[#9f3c16] px-4 py-3 font-bold text-white hover:bg-[#7e2f10]">
                        Checkout <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                    <button type="button" onclick="clearCart()" class="mt-3 w-full text-sm font-semibold text-stone-500 hover:text-red-600">Kosongkan keranjang</button>
                </aside>
            </div>
        <?php endif; ?>
    </main>

    <script>
        async function cartRequest(url, payload = {}) {
            const response = await fetch(url, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) });
            const data = await response.json();
            if (data.status !== 'success') throw new Error(data.message || 'Keranjang tidak dapat diperbarui.');
            location.reload();
        }
        function changeQuantity(id, quantity) {
            if (quantity <= 0) return removeItem(id);
            cartRequest('<?= base_url('cart/update') ?>', { id_produk: id, quantity });
        }
        function removeItem(id) {
            cartRequest('<?= base_url('cart/remove') ?>', { id_produk: id });
        }
        function clearCart() {
            if (confirm('Kosongkan seluruh keranjang?')) cartRequest('<?= base_url('cart/clear') ?>');
        }
    </script>
</body>
</html>
