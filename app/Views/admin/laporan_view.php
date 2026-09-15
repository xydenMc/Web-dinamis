<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Laporan Penjualan - Griya Pot Bunga</title>
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
                <a href="<?= base_url('dashboard') ?>" class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white">
                    <span class="material-symbols-outlined">dashboard</span>
                </a>
                <h1 class="text-xl font-bold">Laporan Penjualan</h1>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4">
        <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-2xl font-bold">Laporan Penjualan</h2>
                <p class="text-on-surface-variant">Ringkasan transaksi dan pendapatan</p>
            </div>

            <div class="p-6">
                <!-- Filter Tanggal -->
                <form method="get" class="flex items-center gap-3 mb-6">
                    <div>
                        <label class="text-xs text-on-surface-variant">Dari</label>
                        <input type="date" name="tanggal_mulai" value="<?= esc($tanggalMulai) ?>" class="mt-1 px-3 py-1.5 rounded-xl border border-outline/30">
                    </div>
                    <div>
                        <label class="text-xs text-on-surface-variant">Sampai</label>
                        <input type="date" name="tanggal_akhir" value="<?= esc($tanggalAkhir) ?>" class="mt-1 px-3 py-1.5 rounded-xl border border-outline/30">
                    </div>
                    <button type="submit" class="px-4 py-2.5 rounded-full bg-primary text-white font-medium">
                        Filter
                    </button>
                    <a href="?" class="px-4 py-2.5 rounded-full border border-outline/30 text-on-surface-variant">
                        Reset
                    </a>
                </form>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="border border-gray-100 rounded-2xl p-4">
                        <p class="text-sm text-on-surface-variant mb-1">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-primary">Rp <?= number_format($totalPendapatan ?? 0, 0, ',', '.') ?></p>
                    </div>
                    <div class="border border-gray-100 rounded-2xl p-4">
                        <p class="text-sm text-on-surface-variant mb-1">Transaksi Selesai</p>
                        <p class="text-2xl font-bold text-on-surface"><?= $jumlahTransaksi ?? 0 ?></p>
                    </div>
                    <div class="border border-gray-100 rounded-2xl p-4">
                        <p class="text-sm text-on-surface-variant mb-1">Total Item Terjual</p>
                        <p class="text-2xl font-bold text-on-surface"><?= $totalItemTerjual ?? 0 ?></p>
                    </div>
                    <div class="border border-gray-100 rounded-2xl p-4">
                        <p class="text-sm text-on-surface-variant mb-1">Produk Terlaris</p>
                        <p class="text-2xl font-bold text-on-surface"><?= count($produkTerlaris ?? []) ?> Produk</p>
                    </div>
                </div>

                <!-- Produk Terlaris -->
                <h3 class="text-lg font-bold mb-3">Produk Terlaris</h3>
                <?php if (isset($produkTerlaris) && count($produkTerlaris) > 0): ?>
                    <table class="w-full border border-gray-100 rounded-2xl mb-6">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Produk</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Terjual</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produkTerlaris as $produk): ?>
                                <tr class="border-b border-gray-100">
                                    <td class="px-4 py-3"><?= esc($produk['nama_produk']) ?></td>
                                    <td class="px-4 py-3 text-right"><?= $produk['terjual'] ?> pcs</td>
                                    <td class="px-4 py-3 text-right font-medium text-primary">Rp <?= number_format($produk['pendapatan'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>

                <!-- Transaksi List -->
                <h3 class="text-lg font-bold mb-3">Daftar Transaksi</h3>
                <?php if (isset($transaksi) && count($transaksi) > 0): ?>
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">No. Transaksi</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                                <th class="px-3 py-2 text-right text-xs font-semibold text-gray-600 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transaksi as $t): ?>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="px-3 py-2 font-medium">
                                        <a href="<?= base_url('transaksi/' . $t['id_transaksi']) ?>" class="text-primary hover:underline">
                                            <?= esc($t['nomor_transaksi']) ?>
                                        </a>
                                    </td>
                                    <td class="px-3 py-2"><?= date('d/m/Y', strtotime($t['tanggal'])) ?></td>
                                    <td class="px-3 py-2 text-right font-medium">Rp <?= number_format($t['total_harga'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-on-surface-variant py-4">Tidak ada transaksi dalam periode ini</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>