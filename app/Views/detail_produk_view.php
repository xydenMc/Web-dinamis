<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= esc($produk['nama_produk'] ?? 'Detail Produk - Griya Pot Bunga') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#9f3c16",
                        "primary-container": "#bf542c",
                        "secondary": "#45664e",
                        "secondary-container": "#c4e9cb",
                        "tertiary": "#825026",
                        "background": "#fcf9f4",
                        "surface-container-low": "#f6f3ee",
                        "surface-container-high": "#ebe8e3",
                        "on-surface": "#1c1c19",
                        "on-surface-variant": "#57423b"
                    }
                }
            }
        };
    </script>
</head>
<body class="bg-background font-body-md text-on-surface min-h-screen">
    <header class="fixed top-0 inset-x-0 z-40">
        <div class="w-full max-w-[1280px] mx-auto px-4 lg:px-8 h-20 bg-surface-container-lowest/65 backdrop-blur-2xl rounded-full shadow-lg flex items-center justify-between transition-all">
            <a href="<?= base_url('katalog') ?>" class="flex items-center gap-2 text-on-surface">
                <span class="material-symbols-outlined">arrow_back</span>
                <span>Katalog</span>
            </a>
            <div class="flex items-center gap-space-sm">
                <a href="<?= base_url('katalog') ?>" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary text-on-primary font-label-md text-label-md">
                    <span class="material-symbols-outlined">shopping_cart</span>
                    <span>Keranjang</span>
                </a>
            </div>
        </div>
    </header>

    <main class="relative z-10 w-full pt-24 max-w-6xl mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Product Image -->
            <div class="rounded-3xl overflow-hidden bg-surface-container-low/60">
                <?php if (!empty($produk['gambar'])): ?>
                    <img class="w-full h-96 object-cover" src="<?= esc($produk['gambar']) ?>" alt="<?= esc($produk['nama_produk']) ?>" onerror="this.src='https://via.placeholder.com/500x500/f5f5f5/cccccc?text=Produk'" />
                <?php else: ?>
                    <div class="w-full h-96 flex items-center justify-center text-6xl">🪴</div>
                <?php endif; ?>
            </div>

            <!-- Product Details -->
            <div class="space-y-4">
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-secondary-container text-on-secondary-container inline-block">
                    <?= esc($produk['kategori'] ?? 'Umum') ?>
                </span>
                <h1 class="text-3xl font-bold text-on-surface"><?= esc($produk['nama_produk']) ?></h1>

                <?php if (!empty($produk['deskripsi'])): ?>
                    <div class="prose prose-sm max-w-none text-on-surface-variant">
                        <?= esc($produk['deskripsi']) ?>
                    </div>
                <?php endif; ?>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-primary-container/20 p-4 rounded-2xl">
                        <p class="text-xs text-on-surface-variant mb-1">Harga</p>
                        <p class="text-xl font-bold text-primary">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>
                    </div>
                    <div class="bg-primary-container/20 p-4 rounded-2xl">
                        <p class="text-xs text-on-surface-variant mb-1">Stok</p>
                        <p class="text-xl font-bold text-on-surface"><?= $produk['stok'] ?> unit</p>
                    </div>
                </div>

                <div class="pt-4">
                    <form action="/cart/add" method="post" id="addToCartForm">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_produk" value="<?= esc($produk['id_produk']) ?>">

                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="updateQuantity(-1)" class="w-8 h-8 rounded-full bg-surface-container-low border border-outline/30 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-sm">-</span>
                                </button>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?= $produk['stok'] ?>" class="w-10 text-center font-bold">
                                <button type="button" onclick="updateQuantity(1)" class="w-8 h-8 rounded-full bg-surface-container-low border border-outline/30 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-sm">+</span>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-full bg-primary text-on-primary font-semibold shadow-lg hover:bg-primary-container transition-all">
                            <span class="material-symbols-outlined">shopping_cart</span>
                            <span>Tambah ke Keranjang</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        function updateQuantity(delta) {
            const input = document.getElementById('quantity');
            const newValue = parseInt(input.value) + delta;
            if (newValue >= 1 && newValue <= <?= $produk['stok'] ?>) {
                input.value = newValue;
            }
        }
    </script>
</body>
</html>