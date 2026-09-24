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
<body class="flex min-h-screen items-center justify-center bg-stone-50 px-4 font-[Plus_Jakarta_Sans] text-stone-800">
    <main class="w-full max-w-lg rounded-3xl bg-white p-8 text-center shadow-sm md:p-12">
        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-green-100 text-green-600"><span class="material-symbols-outlined text-5xl">check_circle</span></div>
        <h1 class="mt-6 text-3xl font-bold">Pesanan berhasil dibuat</h1>
        <p class="mt-3 text-stone-500">Terima kasih. Pesanan Anda sedang menunggu konfirmasi admin.</p>
        <div class="mt-7 rounded-2xl bg-stone-50 p-5">
            <p class="text-sm text-stone-500">Nomor pesanan</p>
        <p class="mt-1 break-all text-xl font-bold text-[#9f3c16]"><?= esc($orderNumber) ?></p>
        </div>
        <?php if (!empty($items)): ?>
            <div class="mt-4 rounded-2xl border border-stone-100 p-5 text-left">
                <h2 class="font-bold">Rincian pesanan</h2>
                <?php foreach ($items as $item): ?>
                    <div class="mt-3 flex justify-between gap-4 text-sm"><span><?= esc($item['nama_produk'] ?? 'Produk') ?> × <?= esc($item['jumlah']) ?></span><span>Rp <?= number_format((float) $item['subtotal'], 0, ',', '.') ?></span></div>
                <?php endforeach; ?>
                <div class="mt-4 flex justify-between border-t border-stone-200 pt-3 font-bold"><span>Total</span><span>Rp <?= number_format((float) $transaction['total_harga'], 0, ',', '.') ?></span></div>
            </div>
        <?php endif; ?>
        <p class="mt-5 text-sm text-stone-500">Simpan nomor pesanan ini untuk keperluan konfirmasi.</p>
        <a href="<?= base_url('/pesanan/struk/pdf') ?>" class="mt-7 inline-flex items-center gap-2 rounded-full border border-[#9f3c16] px-6 py-3 font-bold text-[#9f3c16] hover:bg-orange-50">
            Download PDF <span class="material-symbols-outlined">download</span>
        </a>
        <a href="<?= base_url('katalog') ?>" class="mt-3 inline-flex items-center gap-2 rounded-full bg-[#9f3c16] px-6 py-3 font-bold text-white hover:bg-[#7e2f10]">
            Kembali ke katalog <span class="material-symbols-outlined">storefront</span>
        </a>
    </main>
</body>
</html>
