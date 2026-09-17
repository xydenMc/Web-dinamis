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
        <p class="mt-5 text-sm text-stone-500">Simpan nomor pesanan ini untuk keperluan konfirmasi.</p>
        <a href="<?= base_url('katalog') ?>" class="mt-7 inline-flex items-center gap-2 rounded-full bg-[#9f3c16] px-6 py-3 font-bold text-white hover:bg-[#7e2f10]">
            Kembali ke katalog <span class="material-symbols-outlined">storefront</span>
        </a>
    </main>
</body>
</html>
