<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Detail Transaksi - Griya Pot Bunga</title>
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
    <header class="bg-surface-container-lowest/65 backdrop-blur-2xl rounded-full shadow-lg mx-auto mt-4 mb-4">
        <div class="flex items-center justify-between px-6 py-4">
            <div class="flex items-center gap-3">
                <a href="<?= base_url('admin/transaksi') ?>" class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <h1 class="text-xl font-bold">Detail Transaksi</h1>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4">
        <?php if (isset($transaksi) && $transaksi): ?>
            <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold"><?= esc($transaksi['nomor_transaksi']) ?></h2>
                            <p class="text-on-surface-variant">Tanggal: <?= date('d M Y', strtotime($transaksi['tanggal'])) ?></p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Customer Info -->
                    <div class="border border-gray-100 rounded-2xl p-4 mb-6">
                        <h3 class="font-semibold mb-3">Informasi Pelanggan</h3>
                        <?php if (isset($transaksi['id_pelanggan']) && $transaksi['id_pelanggan']): ?>
                            <?php
                            $userModel = new \App\Models\UserModel();
                            $pelanggan = $userModel->find($transaksi['id_pelanggan']);
                            ?>
                            <?php if ($pelanggan): ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-on-surface-variant">Nama</p>
                                        <p class="font-medium"><?= esc($pelanggan['nama'] ?? $pelanggan['username'] ?? '-') ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-on-surface-variant">Email</p>
                                        <p class="font-medium"><?= esc($pelanggan['email']) ?></p>
                                    </div>
                                </div>
                            <?php else: ?>
                                <p class="text-sm text-on-surface-variant">Pelanggan tidak ditemukan</p>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if (!empty($transaksi['alamat_kirim'])): ?>
                            <div class="mt-3">
                                <p class="text-sm text-on-surface-variant">Alamat Kirim</p>
                                <p class="font-medium"><?= esc($transaksi['alamat_kirim']) ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($transaksi['nomor_telepon'])): ?>
                            <div class="mt-3">
                                <p class="text-sm text-on-surface-variant">No. Telepon</p>
                                <p class="font-medium"><?= esc($transaksi['nomor_telepon']) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Status Update -->
                    <div class="border border-gray-100 rounded-2xl p-4 mb-6">
                        <h3 class="font-semibold mb-3">Status Transaksi</h3>
                        <form action="<?= base_url('admin/transaksi/update-status/' . $transaksi['id_transaksi']) ?>" method="post" class="flex items-center gap-3">
                            <?= csrf_field() ?>
                            <select name="status" class="px-4 py-2.5 rounded-xl border border-outline/30">
                                <option value="Pending" <?= $transaksi['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Diproses" <?= $transaksi['status'] === 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                                <option value="Selesai" <?= $transaksi['status'] === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                <option value="Dibatalkan" <?= $transaksi['status'] === 'Dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                            </select>
                            <button type="submit" class="px-4 py-2.5 rounded-full bg-primary text-white font-medium">
                                Perbarui Status
                            </button>
                        </form>
                    </div>

                    <!-- Items -->
                    <div class="border border-gray-100 rounded-2xl p-4 mb-6">
                        <h3 class="font-semibold mb-3">Item yang Dipesan</h3>
                        <?php if (isset($transaksi['detail']) && count($transaksi['detail']) > 0): ?>
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Produk</th>
                                        <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Qty</th>
                                        <th class="px-3 py-2 text-right text-xs font-semibold text-gray-600 uppercase">Harga</th>
                                        <th class="px-3 py-2 text-right text-xs font-semibold text-gray-600 uppercase">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transaksi['detail'] as $item): ?>
                                        <tr class="border-b border-gray-50">
                                            <td class="px-3 py-2 font-medium"><?= esc($item['nama_produk'] ?? 'Produk ID ' . $item['id_produk']) ?></td>
                                            <td class="px-3 py-2 text-center"><?= $item['jumlah'] ?></td>
                                            <td class="px-3 py-2 text-right">Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                                            <td class="px-3 py-2 text-right font-medium">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="text-on-surface-variant">Tidak ada detail transaksi</p>
                        <?php endif; ?>
                    </div>

                    <!-- Summary -->
                    <div class="border border-gray-100 rounded-2xl p-4">
                        <div class="flex justify-end gap-4">
                            <div class="flex items-center gap-4">
                                <div>
                                    <p class="text-sm text-on-surface-variant">Total Item</p>
                                    <p class="font-bold"><?= $transaksi['total_item'] ?? 0 ?> item</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-on-surface-variant">Total Bayar</p>
                                    <p class="text-2xl font-bold text-primary">Rp <?= number_format($transaksi['total_harga'], 0, ',', '.') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($transaksi['metode_pembayaran'])): ?>
                        <div class="mt-4 text-sm text-on-surface-variant">
                            <strong>Metode Pembayaran:</strong> <?= esc($transaksi['metode_pembayaran']) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($transaksi['catatan'])): ?>
                        <div class="mt-4">
                            <strong>Catatan:</strong>
                            <p class="text-on-surface-variant mt-1"><?= esc($transaksi['catatan']) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <p class="text-on-surface-variant">Transaksi tidak ditemukan</p>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
