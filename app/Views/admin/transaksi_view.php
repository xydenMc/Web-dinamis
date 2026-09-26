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
                        "on-surface-variant": "#57423b",
                        clay: {50:'#fdf8f5',100:'#faede6',200:'#f5d9cd',300:'#ecbca8',400:'#df9477',500:'#c85a32',600:'#b94e27',700:'#9b3d1c',800:'#7c331a',900:'#662d18'},
                        botanica: {sand:'#fcf9f4',surface:'#f7f2ea',dark:'#261e1a',muted:'#71655e',sage:'#5c735d',sageLight:'#eef3ee',amberLight:'#fcf6e8',amberBorder:'#f0dfbe',amberDark:'#936a16'}
                    },
                    boxShadow: {'liquid':'0 8px 32px 0 rgba(197,106,73,.08),0 2px 8px 0 rgba(0,0,0,.03)','liquid-glow':'0 10px 25px -4px rgba(200,90,50,.35)','subtle-glass':'0 4px 24px -1px rgba(50,30,20,.04)'}
                }
            }
        };
    </script>
    <style>
        .glass-sidebar{background:linear-gradient(180deg,rgba(253,250,246,.88) 0%,rgba(247,242,235,.94) 100%);backdrop-filter:blur(32px);-webkit-backdrop-filter:blur(32px)}
        @media(max-width:767px){.glass-sidebar{display:none!important}header.ml-72{margin-left:0!important}main.md\:ml-72{margin-left:0!important}}
    </style>
    <link rel="stylesheet" href="<?= base_url('css/admin-typography.css') ?>">
</head>
<body class="bg-background font-body-md text-on-surface min-h-screen">
    <!-- Flashdata Notifications -->
    <?php if ($successMessage = flash_message('success')): ?>
        <div class="fixed top-20 right-4 z-50 flex items-center gap-3 px-6 py-3 rounded-lg bg-green-500 text-white shadow-lg">
            <span class="material-symbols-outlined">check_circle</span>
            <span><?= esc($successMessage) ?></span>
        </div>
    <?php endif; ?>
    <?php if ($errorMessage = flash_message('error')): ?>
        <div class="fixed top-20 right-4 z-50 flex items-center gap-3 px-6 py-3 rounded-lg bg-red-500 text-white shadow-lg">
            <span class="material-symbols-outlined">error_circle</span>
            <span><?= esc($errorMessage) ?></span>
        </div>
    <?php endif; ?>

    <aside class="w-72 fixed inset-y-0 left-0 z-30 glass-sidebar border-r border-stone-200/60 flex flex-col justify-between p-6 shadow-subtle-glass transition-all">
        <div>
            <div class="flex items-center gap-3.5 pb-7 mb-7 border-b border-stone-200/60" data-purpose="brand-header"><div class="w-12 h-12 rounded-2xl bg-white p-1 flex items-center justify-center shadow-liquid ring-2 ring-white/80 overflow-hidden"><img class="w-full h-full rounded-xl object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDpwvO9iQZ9lDuh8yr22477P8XcdNBR4_m47lhkSeptg4KRN1mKNgHUC_C-Bz_34DomPfduGCmd0dBQDdBwb6HwRI634h8GcBl0MOAjtwlq3cPBfwREhRDd-GQ5FEATZmEjJpkd-bGJX4j_R9lpdrVgHqRAECM9rEQ_3rztgRbmHcnjL3cwdaRkP6Hbuq_l8m0_jQSJiMii3Cg5FUnvJNIht8zg3HAffzEkU_1738FKJw5_qWc3_DHqLQ" alt="Logo Griya Pot Bunga"></div><div><h1 class="font-serif font-bold text-lg text-botanica-dark tracking-tight leading-tight">Griya Pot Bunga</h1><p class="text-[10px] tracking-wider font-semibold uppercase text-clay-600 mt-0.5">STUDIO KASONGAN / PANEL ADMIN</p></div></div>
            <div class="space-y-6"><div><p class="text-[11px] font-bold tracking-widest text-botanica-muted/70 uppercase px-3 mb-2.5">Menu Studio</p><nav class="space-y-1.5">
                <a class="flex items-center gap-3 px-4 py-3 rounded-2xl text-botanica-dark/80 hover:text-clay-600 hover:bg-stone-200/40 transition font-medium text-sm" href="<?= base_url('/dashboard') ?>"><svg class="w-5 h-5 text-botanica-muted" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect height="7" rx="1.5" width="7" x="3" y="3"></rect><rect height="7" rx="1.5" width="7" x="14" y="3"></rect><rect height="7" rx="1.5" width="7" x="14" y="14"></rect><rect height="7" rx="1.5" width="7" x="3" y="14"></rect></svg><span>Dashboard</span></a>
                <a aria-current="page" class="flex items-center justify-between px-4 py-3 rounded-2xl bg-gradient-to-r from-clay-500 to-clay-600 text-white font-medium text-sm shadow-liquid-glow transition-all" href="<?= base_url('/admin/transaksi') ?>"><div class="flex items-center gap-3"><svg class="w-5 h-5 opacity-90" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-linecap="round" stroke-linejoin="round"></path></svg><span>Pesanan Masuk</span></div><?php if (!empty($pendingOrders)): ?><span class="text-xs bg-stone-200/70 text-botanica-dark font-medium px-2 py-0.5 rounded-full"><?= esc($pendingOrders) ?></span><?php endif; ?></a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-2xl text-botanica-dark/80 hover:text-clay-600 hover:bg-stone-200/40 transition font-medium text-sm" href="<?= base_url('/admin/kelola-produk') ?>"><svg class="w-5 h-5 text-botanica-muted" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-linecap="round" stroke-linejoin="round"></path></svg><span>Kelola Produk</span></a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-2xl text-botanica-dark/80 hover:text-clay-600 hover:bg-stone-200/40 transition font-medium text-sm" href="<?= base_url('/admin/laporan') ?>"><svg class="w-5 h-5 text-botanica-muted" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 3h7l5 5v13H5V3h2zm7 0v5h5M8 13h8m-8 4h8" stroke-linecap="round" stroke-linejoin="round"></path></svg><span>Laporan Pesanan</span></a>
            </nav></div><div><p class="text-[11px] font-bold tracking-widest text-botanica-muted/70 uppercase px-3 mb-2.5">Akses Toko</p><a class="flex items-center justify-between px-4 py-3 rounded-2xl text-botanica-dark/80 hover:text-clay-600 hover:bg-stone-200/40 transition font-medium text-sm group" href="<?= base_url('/') ?>" target="_blank"><div class="flex items-center gap-3"><svg class="w-5 h-5 text-botanica-muted group-hover:text-clay-600 transition" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" stroke-linecap="round" stroke-linejoin="round"></path></svg><span>Lihat Etalase</span></div><svg class="w-4 h-4 text-stone-400 group-hover:translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></a></div></div>
        </div>
        <div class="pt-4 border-t border-stone-200/60 space-y-3"><a class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-stone-500 hover:text-red-700 hover:bg-red-50/60 transition text-sm font-medium" href="<?= base_url('/admin/logout') ?>"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round"></path></svg><span>Keluar Sesi Admin</span></a></div>
    </aside>
    <header class="sticky top-0 z-20 mb-5 flex items-center justify-between border-b border-stone-200/60 bg-background/90 px-5 py-4 backdrop-blur-xl ml-72 md:px-10"><h1 class="text-xl font-bold">Pesanan Masuk</h1></header>

    <main class="mx-auto max-w-7xl px-4 md:ml-72 md:px-10">
        <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-2xl font-bold">Daftar Transaksi</h2>
                <p class="text-on-surface-variant">Kelola semua transaksi pembelian</p>
            </div>

            <div class="p-6">
                <?php $dateQuery = array_filter(['start_date' => $start_date ?? '', 'end_date' => $end_date ?? ''], static fn ($value) => $value !== ''); ?>
                <form method="get" action="<?= base_url('/admin/transaksi') ?>" class="mb-5 flex flex-wrap items-end gap-3 rounded-2xl bg-[#fcf9f4] p-4">
                    <input type="hidden" name="status" value="<?= esc($status_filter) ?>">
                    <label class="grid gap-1 text-xs font-semibold text-on-surface-variant">Dari tanggal<input class="rounded-xl border border-stone-300 bg-white px-3 py-2 text-sm text-on-surface" type="date" name="start_date" value="<?= esc($start_date ?? '') ?>"></label>
                    <label class="grid gap-1 text-xs font-semibold text-on-surface-variant">Sampai tanggal<input class="rounded-xl border border-stone-300 bg-white px-3 py-2 text-sm text-on-surface" type="date" name="end_date" value="<?= esc($end_date ?? '') ?>"></label>
                    <button class="rounded-full bg-primary px-4 py-2 text-sm font-semibold text-white" type="submit">Terapkan tanggal</button>
                    <a class="rounded-full border border-stone-300 bg-white px-4 py-2 text-sm font-semibold text-on-surface-variant" href="<?= base_url('/admin/transaksi') . '?' . http_build_query(['status' => $status_filter]) ?>">Reset tanggal</a>
                </form>
                <!-- Filter Status -->
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-sm font-medium text-on-surface-variant">Filter:</span>
                    <form method="get" class="flex gap-1">
                        <a href="<?= base_url('/admin/transaksi') . '?' . http_build_query($dateQuery + ['status' => 'all']) ?>" class="px-3 py-1 rounded-full <?= $status_filter === 'all' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700' ?> text-sm">Semua</a>
                        <a href="<?= base_url('/admin/transaksi') . '?' . http_build_query($dateQuery + ['status' => 'Pending']) ?>" class="px-3 py-1 rounded-full <?= $status_filter === 'Pending' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700' ?> text-sm">Pending</a>
                        <a href="<?= base_url('/admin/transaksi') . '?' . http_build_query($dateQuery + ['status' => 'Diproses']) ?>" class="px-3 py-1 rounded-full <?= $status_filter === 'Diproses' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700' ?> text-sm">Diproses</a>
                        <a href="<?= base_url('/admin/transaksi') . '?' . http_build_query($dateQuery + ['status' => 'Selesai']) ?>" class="px-3 py-1 rounded-full <?= $status_filter === 'Selesai' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700' ?> text-sm">Selesai</a>
                        <a href="<?= base_url('/admin/transaksi') . '?' . http_build_query($dateQuery + ['status' => 'Dibatalkan']) ?>" class="px-3 py-1 rounded-full <?= $status_filter === 'Dibatalkan' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700' ?> text-sm">Dibatalkan</a>
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
                                            <a href="<?= base_url('admin/transaksi/' . $transaksi['id_transaksi']) ?>" class="text-primary hover:underline">
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
                                            <a href="<?= base_url('admin/transaksi/' . $transaksi['id_transaksi']) ?>" class="text-primary hover:text-primary-container">Detail</a>
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
