<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= esc($title ?? 'Kelola Transaksi - Griya Pot Bunga') ?></title>
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
    <!-- Flashdata Notifications -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="fixed top-20 right-4 z-50 flex items-center gap-3 px-6 py-3 rounded-lg bg-green-500 text-white shadow-lg">
            <span class="material-symbols-outlined">check_circle</span>
            <span><?= esc(session()->getFlashdata('success')) ?></span>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="fixed top-20 right-4 z-50 flex items-center gap-3 px-6 py-3 rounded-lg bg-red-500 text-white shadow-lg">
            <span class="material-symbols-outlined">error_circle</span>
            <span><?= esc(session()->getFlashdata('error')) ?></span>
        </div>
    <?php endif; ?>

    <header class="bg-surface-container-lowest/65 backdrop-blur-2xl rounded-full shadow-lg mx-auto mt-4 mb-4">
        <div class="flex items-center justify-between px-6 py-4">
            <div class="flex items-center gap-3">
                <a href="<?= base_url('dashboard') ?>" class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white">
                    <span class="material-symbols-outlined">dashboard</span>
                </a>
                <h1 class="text-xl font-bold">Kelola Transaksi</h1>
            </div>
            <a href="<?= base_url('dashboard') ?>" class="px-4 py-2 rounded-full border border-outline/30 text-on-surface-variant">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4">
        <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-2xl font-bold">Daftar Transaksi</h2>
                <p class="text-on-surface-variant">Kelola semua transaksi pembelian</p>
            </div>

            <div class="p-6">
                <!-- Filter Status -->
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-sm font-medium text-on-surface-variant">Filter:</span>
                    <form method="get" class="flex gap-1">
                        <a href="?status=all" class="px-3 py-1 rounded-full <?= $status_filter === 'all' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700' ?> text-sm">Semua</a>
                        <a href="?status=Pending" class="px-3 py-1 rounded-full <?= $status_filter === 'Pending' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700' ?> text-sm">Pending</a>
                        <a href="?status=Diproses" class="px-3 py-1 rounded-full <?= $status_filter === 'Diproses' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700' ?> text-sm">Diproses</a>
                        <a href="?status=Selesai" class="px-3 py-1 rounded-full <?= $status_filter === 'Selesai' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700' ?> text-sm">Selesai</a>
                        <a href="?status=Dibatalkan" class="px-3 py-1 rounded-full <?= $status_filter === 'Dibatalkan' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700' ?> text-sm">Dibatalkan</a>
                    </form>
                </div>

                <?php if (isset($transaksis) && count($transaksis) > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No. Transaksi</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Total</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Status</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transaksis as $transaksi): ?>
                                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-on-surface">
                                            <a href="<?= base_url('transaksi/' . $transaksi['id_transaksi']) ?>" class="text-primary hover:underline">
                                                <?= esc($transaksi['nomor_transaksi']) ?>
                                            </a>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-on-surface-variant">
                                            <?= date('d M Y H:i', strtotime($transaksi['tanggal'])) ?>
                                        </td>
                                        <td class="px-4 py-3 text-right font-medium text-on-surface">
                                            Rp <?= number_format($transaksi['total_harga'], 0, ',', '.') ?>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <?php if ($transaksi['status'] === 'Selesai'): ?>
                                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                            <?php elseif ($transaksi['status'] === 'Pending'): ?>
                                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            <?php elseif ($transaksi['status'] === 'Diproses'): ?>
                                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Diproses</span>
                                            <?php else: ?>
                                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Dibatalkan</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <a href="<?= base_url('transaksi/' . $transaksi['id_transaksi']) ?>" class="text-primary hover:text-primary-container">Detail</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12">
                        <div class="text-4xl mb-3">📋</div>
                        <h3 class="font-bold mb-2">Belum ada Transaksi</h3>
                        <p class="text-on-surface-variant">Transaksi pertama akan muncul di sini</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>