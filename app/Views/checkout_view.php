<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Checkout - Griya Pot Bunga</title>
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
    <style>
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-background font-body-md text-on-surface min-h-screen">
    <!-- Flashdata Notifications -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="fixed top-20 right-4 z-50 flex items-center gap-3 px-6 py-3 rounded-lg bg-green-500 text-white shadow-lg animate-slideDown">
            <span class="material-symbols-outlined">check_circle</span>
            <span><?= esc(session()->getFlashdata('success')) ?></span>
            <button onclick="this.parentElement.remove()" class="ml-2">✕</button>
        </div>
        <style>
            @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        </style>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="fixed top-20 right-4 z-50 flex items-center gap-3 px-6 py-3 rounded-lg bg-red-500 text-white shadow-lg">
            <span class="material-symbols-outlined">error_circle</span>
            <span><?= esc(session()->getFlashdata('error')) ?></span>
        </div>
    <?php endif; ?>

    <header class="fixed top-0 inset-x-0 z-40">
        <div class="w-full max-w-[1280px] mx-auto px-4 lg:px-8 h-20 bg-surface-container-lowest/65 backdrop-blur-2xl rounded-full shadow-lg flex items-center justify-between transition-all">
            <a href="<?= base_url('katalog') ?>" class="flex items-center gap-2 text-on-surface">
                <span class="material-symbols-outlined">arrow_back</span>
                <span>Katalog</span>
            </a>
        </div>
    </header>

    <main class="relative z-10 w-full pt-24 max-w-4xl mx-auto px-4 lg:px-8">
        <h1 class="text-3xl font-bold mb-6">Checkout Pembelian</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Order Summary -->
            <div>
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden mb-6">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-xl font-bold">Ringkasan Pesanan</h2>
                    </div>
                    <div class="p-6">
                        <?php if (!empty($cart)): ?>
                            <?php $subtotal = 0; ?>
                            <?php foreach ($cart as $item): ?>
                                <div class="flex items-center gap-4 py-3 border-b border-gray-100 last:border-b-0">
                                    <?php if (!empty($item['gambar'])): ?>
                                        <img src="<?= esc($item['gambar']) ?>" alt="<?= esc($item['nama_produk']) ?>" class="w-16 h-16 rounded-lg object-cover">
                                    <?php else: ?>
                                        <div class="w-16 h-16 rounded-lg bg-gray-100 flex items-center justify-center">
                                            <span class="text-2xl">🪴</span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="flex-1">
                                        <h4 class="font-medium"><?= esc($item['nama_produk']) ?></h4>
                                        <p class="text-sm text-on-surface-variant">Rp <?= number_format($item['harga'], 0, ',', '.') ?> × <?= $item['quantity'] ?> = Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></p>
                                    </div>
                                </div>
                            <?php $subtotal += $item['subtotal']; ?>
                            <?php endforeach; ?>

                            <div class="border-t border-gray-100 pt-4">
                                <div class="flex justify-between">
                                    <span class="text-lg font-bold">Subtotal (<?= count($cart) ?> item)</span>
                                    <span class="text-lg font-bold text-primary">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="text-on-surface-variant text-center py-8">Keranjang Anda kosong</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Checkout Form -->
            <div>
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-xl font-bold">Detail Pengiriman</h2>
                    </div>
                    <div class="p-6">
                        <form action="/checkout/process" method="post" id="checkoutForm">
                            <?= csrf_field() ?>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Nomor Telepon *</label>
                                    <input type="tel" name="nomor_telepon" required minlength="10" maxlength="20"
                                           class="w-full px-4 py-2.5 rounded-xl border border-outline/30 focus:ring-2 focus:ring-primary"
                                           placeholder="08xxxxxxxxxx">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-1">Alamat Kirim *</label>
                                    <textarea name="alamat_kirim" rows="3" required minlength="10" maxlength="500"
                                              class="w-full px-4 py-2.5 rounded-xl border border-outline/30 focus:ring-2 focus:ring-primary"
                                              placeholder="Masukkan alamat lengkap Anda"></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-1">Metode Pembayaran *</label>
                                    <select name="metode_pembayaran" required class="w-full px-4 py-2.5 rounded-xl border border-outline/30">
                                        <option value="">Pilih metode pembayaran</option>
                                        <option value="Transfer Bank">Transfer Bank</option>
                                        <option value="COD (Bayar di Tempat)">COD (Bayar di Tempat)</option>
                                        <option value="QRIS">QRIS (GoPay/OVO/DANA)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-1">Catatan (Opsional)</label>
                                    <textarea name="catatan" rows="2" maxlength="500"
                                              class="w-full px-4 py-2.5 rounded-xl border border-outline/30 focus:ring-2 focus:ring-primary"
                                              placeholder="Spesialkan pesanan Anda..."></textarea>
                                </div>
                            </div>

                            <div class="mt-6 pt-4 border-t border-gray-100">
                                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-full bg-primary text-on-primary font-semibold shadow-lg hover:bg-primary-container transition-all">
                                    <span class="material-symbols-outlined">payment</span>
                                    <span> Lakukan Pembayaran </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>