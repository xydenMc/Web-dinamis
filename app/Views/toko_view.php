<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= esc($title ?? 'Griya Pot Bunga - Katalog Pot dan Gerabah') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />
    <style>
        @layer base {
            @tailwind base;
        }

        @layer components {
            @tailwind components;
        }

        @layer utilities {
            @tailwind utilities;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "secondary-container": "#c4e9cb",
                        "on-secondary-fixed": "#01210f",
                        "surface-variant": "#e5e2dd",
                        "on-primary-fixed-variant": "#822801",
                        "on-primary-container": "#fffbff",
                        "outline-variant": "#dec0b7",
                        "on-primary": "#ffffff",
                        "secondary-fixed-dim": "#abcfb2",
                        "surface-bright": "#fcf9f4",
                        "background": "#fcf9f4",
                        "tertiary-fixed": "#ffdcc3",
                        "secondary": "#45664e",
                        "surface-container-low": "#f6f3ee",
                        "on-primary-fixed": "#390c00",
                        "surface-container-lowest": "#ffffff",
                        "on-secondary": "#ffffff",
                        "on-tertiary": "#ffffff",
                        "tertiary": "#825026",
                        "secondary-fixed": "#c7ecce",
                        "on-secondary-fixed-variant": "#2e4e37",
                        "on-error-container": "#93000a",
                        "surface": "#fcf9f4",
                        "on-secondary-container": "#496a52",
                        "error": "#ba1a1a",
                        "on-tertiary-container": "#fffbff",
                        "tertiary-fixed-dim": "#fbb985",
                        "primary": "#9f3c16",
                        "primary-fixed": "#ffdbcf",
                        "primary-fixed-dim": "#ffb59c",
                        "inverse-on-surface": "#f3f0eb",
                        "inverse-surface": "#31302d",
                        "surface-container": "#f0ede9",
                        "error-container": "#ffdad6",
                        "primary-container": "#bf542c",
                        "on-background": "#1c1c19",
                        "on-surface-variant": "#57423b",
                        "surface-container-highest": "#e5e2dd",
                        "on-tertiary-fixed-variant": "#693c13",
                        "tertiary-container": "#9e683c",
                        "on-surface": "#1c1c19",
                        "inverse-primary": "#ffb59c",
                        "surface-dim": "#dcdad5",
                        "on-error": "#ffffff",
                        "on-tertiary-fixed": "#2f1500",
                        "outline": "#8a726a",
                        "surface-container-high": "#ebe8e3",
                        "surface-tint": "#a23e18"
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px"
                    },
                    spacing: {
                        "gutter-desktop": "2rem",
                        "space-xl": "2rem",
                        "space-2xl": "3rem",
                        "space-lg": "1.5rem",
                        "space-2xs": "0.25rem",
                        "space-md": "1rem",
                        "space-3xl": "4rem",
                        "gutter-mobile": "1rem",
                        "space-sm": "0.75rem",
                        "container-max": "1280px",
                        "space-xs": "0.5rem"
                    },
                    fontFamily: {
                        "label-md": ["Plus Jakarta Sans"],
                        "title-md": ["Plus Jakarta Sans"],
                        "display-lg": ["Plus Jakarta Sans"],
                        "body-md": ["Plus Jakarta Sans"],
                        "headline-xl": ["Plus Jakarta Sans"],
                        "title-lg": ["Plus Jakarta Sans"],
                        "body-lg": ["Plus Jakarta Sans"],
                        "display-lg-mobile": ["Plus Jakarta Sans"],
                        "headline-md": ["Plus Jakarta Sans"],
                        "label-sm": ["Plus Jakarta Sans"],
                        "headline-lg": ["Plus Jakarta Sans"]
                    },
                    fontSize: {
                        "label-md": ["13px", {
                            lineHeight: "18px",
                            letterSpacing: "0.01em",
                            fontWeight: "500"
                        }],
                        "title-md": ["16px", {
                            lineHeight: "22px",
                            fontWeight: "600"
                        }],
                        "display-lg": ["48px", {
                            lineHeight: "56px",
                            letterSpacing: "-0.02em",
                            fontWeight: "700"
                        }],
                        "body-md": ["14px", {
                            lineHeight: "22px",
                            fontWeight: "400"
                        }],
                        "headline-xl": ["36px", {
                            lineHeight: "44px",
                            letterSpacing: "-0.02em",
                            fontWeight: "600"
                        }],
                        "title-lg": ["18px", {
                            lineHeight: "24px",
                            fontWeight: "600"
                        }],
                        "body-lg": ["16px", {
                            lineHeight: "26px",
                            fontWeight: "400"
                        }],
                        "display-lg-mobile": ["32px", {
                            lineHeight: "40px",
                            letterSpacing: "-0.015em",
                            fontWeight: "700"
                        }],
                        "headline-md": ["22px", {
                            lineHeight: "30px",
                            letterSpacing: "-0.01em",
                            fontWeight: "600"
                        }],
                        "label-sm": ["11px", {
                            lineHeight: "16px",
                            letterSpacing: "0.04em",
                            fontWeight: "600"
                        }],
                        "headline-lg": ["28px", {
                            lineHeight: "36px",
                            letterSpacing: "-0.015em",
                            fontWeight: "600"
                        }]
                    }
                }
            }
        };
    </script>
    <style>
        @layer base {

            html,
            body {
                margin: 0;
                padding: 0;
            }

            body {
                overscroll-behavior: none;
            }

            main>:first-child {
                margin-top: 0 !important;
            }

            main>:last-child {
                margin-bottom: 0 !important;
            }

            ::-webkit-scrollbar {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-background font-body-md text-on-surface min-h-screen relative selection:bg-primary-fixed selection:text-on-primary-fixed">
    <!-- Flashdata Notification -->
    <?php if (session()->getFlashdata('success')): ?>
        <div id="flash-notification" class="fixed top-20 right-4 z-50 flex items-center gap-3 px-6 py-3 rounded-lg bg-green-500 text-white shadow-lg animate-slideDown">
            <span class="material-symbols-outlined text-[18px]">check_circle</span>
            <span class="font-semibold"><?= esc(session()->getFlashdata('success')) ?></span>
            <button onclick="document.getElementById('flash-notification').remove()" class="ml-2 text-white hover:text-green-200">
                <span class="material-symbols-outlined text-[16px]">close</span>
            </button>
        </div>
        <style>
            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div id="flash-notification-error" class="fixed top-20 right-4 z-50 flex items-center gap-3 px-6 py-3 rounded-lg bg-red-500 text-white shadow-lg animate-slideDown">
            <span class="material-symbols-outlined text-[18px]">error_circle</span>
            <span class="font-semibold"><?= esc(session()->getFlashdata('error')) ?></span>
            <button onclick="document.getElementById('flash-notification-error').remove()" class="ml-2 text-white hover:text-red-200">
                <span class="material-symbols-outlined text-[16px]">close</span>
            </button>
        </div>
    <?php endif; ?>

    <header class="fixed top-0 inset-x-0 z-50">
        <div class="w-full max-w-[1280px] h-20 bg-surface-container-lowest/65 backdrop-blur-2xl rounded-full shadow-[0_16px_36px_-8px_rgba(42,30,23,0.08),0_4px_16px_-2px_rgba(42,30,23,0.04)] mx-auto px-gutter-mobile lg:px-gutter-desktop flex items-center justify-between transition-all">
            <div class="flex items-center gap-space-sm">
                <img alt="Griya Pot Bunga Logo" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDpwvO9iQZ9lDuh8yr22477P8XcdNBR4_m47lhkSeptg4KRN1mKNgHUC_C-Bz_34DomPfduGCmd0dBQDdBwb6HwRI634h8GcBl0MOAjtwlq3cPBfwREhRDd-GQ5FEATZmEjJpkd-bGJX4j_R9lpdrVgHqRAECM9rEQ_3rztgRbmHcnjL3cwdaRkP6Hbuq_l8m0_jQSJiMii3Cg5FUnvJNIht8zg3HAffzEkU_1738FKJw5_qWc3_DHqLQ" />
                <div class="flex flex-col">
                    <span class="font-title-md text-title-md text-on-surface tracking-tight leading-none">Griya Pot Bunga</span>
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Toko Pot &amp; Gerabah Pilihan</span>
                </div>
            </div>

            <!-- Dashboard Button (Hanya tampil jika role === 'admin') -->
            <nav class="hidden lg:flex items-center gap-space-xs bg-surface-container-low/70 p-space-2xs rounded-full backdrop-blur-md">
                <?php if (isset($user) && $user && isset($role) && $role === 'admin'): ?>
                    <a class="px-space-md py-space-xs text-on-surface-variant font-label-md text-label-md hover:text-on-surface transition-colors rounded-full" data-path="dashboard" href="<?= base_url('dashboard') ?>">Dashboard</a>
                <?php endif; ?>
            </nav>

            <div class="flex items-center gap-space-sm">
                <!-- Tambah Produk Button (Hanya tampil jika role === 'admin') -->
                <?php if (isset($user) && $user && isset($role) && $role === 'admin'): ?>
                    <a class="hidden sm:inline-flex items-center gap-space-2xs bg-primary text-on-primary font-label-md text-label-md px-space-md py-space-xs rounded-full shadow-[0_6px_16px_-2px_rgba(159,60,22,0.35)] hover:bg-primary-container hover:text-on-primary-container transition-all" data-path="tambah-produk" href="#" onclick="openAddModal(); return false;">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        <span>Tambah Produk</span>
                    </a>
                <?php endif; ?>

                <!-- Logout & User Profile Icon (Tampil untuk semua role yang sudah login) -->
                <?php if (isset($user) && $user): ?>
                    <a href="javascript:void(0)" onclick="performLogout()" class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-red-50 text-red-700 hover:bg-red-100 font-label-md text-label-md transition-all shadow-sm" title="Logout">
                        <span class="material-symbols-outlined text-[16px]">logout</span>
                        <span class="font-label-sm text-label-sm">Logout</span>
                    </a>
                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center shadow-sm">
                        <span class="material-symbols-outlined text-on-primary text-[18px]">person</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="relative z-10 w-full pt-20 bg-transparent min-h-[calc(100vh-280px)]">
        <div class="flex flex-col w-full">
            <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
                <div class="absolute -top-[20%] left-[15%] w-[600px] h-[600px] rounded-full bg-tertiary-fixed/30 blur-[130px]"></div>
                <div class="absolute top-[40%] -right-[10%] w-[500px] h-[500px] rounded-full bg-secondary-fixed/40 blur-[140px]"></div>
                <div class="absolute -bottom-[15%] left-[25%] w-[700px] h-[700px] rounded-full bg-primary-fixed/20 blur-[160px]"></div>
            </div>

            <div class="relative w-full max-w-[1280px] mx-auto px-gutter-mobile lg:px-gutter-desktop">
                <section class="pt-8 pb-12 flex flex-col items-center text-center relative z-10">
                    <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-surface-container-lowest/65 backdrop-blur-xl shadow-[0_8px_20px_-4px_rgba(42,30,23,0.06)] mb-6 transition-transform hover:scale-105 duration-300">
                        <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                        <span class="font-label-md text-label-md text-on-surface-variant font-medium tracking-wide">
                            Kualitas Premium • Handmade • Eco-Friendly
                        </span>
                    </div>

                    <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight max-w-3xl mb-4">
                        Katalog Pot Bunga <span class="text-primary font-normal">&amp;</span> Gerabah
                    </h1>

                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto mb-10 leading-relaxed">
                        Temukan koleksi pot bunga berkualitas untuk rumah dan taman Anda. Setiap produk dibuat dengan cinta dan dedikasi oleh pengrajin lokal terbaik.
                    </p>

                    <div class="w-full max-w-4xl bg-surface-container-lowest/70 backdrop-blur-2xl rounded-3xl p-3 sm:p-4 shadow-[0_20px_40px_-10px_rgba(42,30,23,0.08),0_4px_16px_-2px_rgba(42,30,23,0.03)] flex flex-col gap-4">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-2">
                            <div class="relative w-full sm:w-96 flex items-center">
                                <span class="material-symbols-outlined text-outline text-[20px] absolute left-4 pointer-events-none">search</span>
                                <input class="w-full pl-11 pr-4 py-2.5 rounded-full bg-surface-container-low/70 focus:bg-surface-container-lowest text-on-surface font-body-md text-body-md placeholder:text-outline focus:outline-none transition-all shadow-inner" id="potSearchInput" placeholder="Cari jenis pot, material, atau ukuran..." type="text" />
                            </div>
                            <div class="flex items-center justify-between w-full sm:w-auto gap-4">
                                <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-surface-container-high/60 text-on-surface-variant font-label-md text-label-md">
                                    <span class="material-symbols-outlined text-tertiary text-[18px]">inventory_2</span>
                                    <span>Total: <strong class="text-on-surface font-semibold" id="productCount"><?= count($produks ?? []) ?></strong> produk aktif</span>
                                </div>
                                <div class="relative inline-block">
                                    <button class="flex items-center gap-1.5 px-4 py-2 rounded-full bg-surface-container-low/80 hover:bg-surface-container-high text-on-surface font-label-md text-label-md transition-colors shadow-sm" id="sortToggle">
                                        <span class="material-symbols-outlined text-[18px] text-primary">sort</span>
                                        <span id="currentSortLabel">Terbaru</span>
                                        <span class="material-symbols-outlined text-[16px]">expand_more</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-start sm:justify-center gap-2 overflow-x-auto pb-1 pt-1 scrollbar-none px-2" id="filterContainer">
                            <button class="filter-btn active-filter px-5 py-1.5 rounded-full font-label-md text-label-md transition-all duration-200 bg-primary text-on-primary shadow-sm" data-filter="all">
                                Semua
                            </button>
                            <button class="filter-btn px-5 py-1.5 rounded-full font-label-md text-label-md transition-all duration-200 bg-surface-container-low/80 hover:bg-surface-container-high text-on-surface-variant" data-filter="keramik">
                                Keramik
                            </button>
                            <button class="filter-btn px-5 py-1.5 rounded-full font-label-md text-label-md transition-all duration-200 bg-surface-container-low/80 hover:bg-surface-container-high text-on-surface-variant" data-filter="kayu">
                                Kayu
                            </button>
                            <button class="filter-btn px-5 py-1.5 rounded-full font-label-md text-label-md transition-all duration-200 bg-surface-container-low/80 hover:bg-surface-container-high text-on-surface-variant" data-filter="beton">
                                Beton
                            </button>
                            <button class="filter-btn px-5 py-1.5 rounded-full font-label-md text-label-md transition-all duration-200 bg-surface-container-low/80 hover:bg-surface-container-high text-on-surface-variant" data-filter="terakota">
                                Terakota
                            </button>
                        </div>
                    </div>
                </section>

                <!-- Catalog Product Grid -->
                <section class="w-full py-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="productGrid">
                        <?php if (!empty($produks)): ?>
                            <?php foreach ($produks as $produk):
                                $gambar = $produk['gambar'] ?? '';
                                $nama = $produk['nama_produk'] ?? '';
                                $kategori = $produk['kategori'] ?? 'Umum';
                                $harga = $produk['harga'] ?? 0;
                                $stok = $produk['stok'] ?? 0;
                                $deskripsi = $produk['deskripsi'] ?? '';
                                $status = $produk['status'] ?? 'aktif';
                                $id_produk = $produk['id_produk'] ?? $produk['id'] ?? '';
                            ?>
                                <!-- Product Card -->
                                <article class="product-item group relative flex flex-col justify-between rounded-3xl bg-surface-container-lowest/65 backdrop-blur-2xl p-4 transition-all duration-300 hover:-translate-y-1.5 shadow-[0_12px_32px_-4px_rgba(42,30,23,0.06),0_4px_12px_-2px_rgba(42,30,23,0.03)] hover:shadow-[0_24px_48px_-8px_rgba(159,60,22,0.12)]" data-category="<?= strtolower($kategori) ?>" data-name="<?= esc($nama) ?>">
                                    <div>
                                        <!-- Img Showcase Inset Well -->
                                        <div class="relative w-full aspect-square rounded-2xl overflow-hidden bg-surface-container-low/60 mb-4 group-hover:scale-[1.01] transition-transform duration-500">
                                            <?php if (!empty($gambar)): ?>
                                                <img class="w-full h-full object-cover" src="<?= esc($gambar) ?>" alt="<?= esc($nama) ?>" onerror="this.onerror=null; this.src='https://via.placeholder.com/400x400/f0ede9/8a726a?text=Griya+Pot';" />
                                            <?php else: ?>
                                                <div class="w-full h-full flex items-center justify-center text-brown-700 bg-gradient-to-br from-surface-container-low/60 to-surface-container-high/40">
                                                    <span class="text-4xl">🪴</span>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Category Badge -->
                                            <div class="absolute top-3 left-3 flex items-center gap-2">
                                                <span class="px-3 py-1 rounded-full bg-secondary-container/80 backdrop-blur-md text-on-secondary-container font-label-sm text-label-sm font-semibold tracking-wider uppercase shadow-sm">
                                                    <?= esc(strtolower($kategori)) ?>
                                                </span>
                                            </div>

                                            <!-- Admin Buttons -->
                                            <?php if (isset($user) && $user && isset($role) && $role === 'admin'): ?>
                                                <!-- Tombol Edit di Pojok Kiri Samping Badge / Kanan Atas -->
                                                <button onclick='openEditModal(<?= json_encode($produk, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' class="absolute top-3 right-12 w-8 h-8 rounded-full bg-surface-container-lowest/90 backdrop-blur-md flex items-center justify-center text-on-surface-variant hover:text-primary transition-all shadow-sm z-10" title="Edit Produk">
                                                    <span class="material-symbols-outlined text-[16px]">edit</span>
                                                </button>
                                                <!-- Tombol Hapus -->
                                                <form action="/hapus-produk/<?= esc($id_produk) ?>" method="post" class="absolute top-3 right-3 z-10" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="w-8 h-8 rounded-full bg-red-500 hover:bg-red-600 text-white flex items-center justify-center transition-all shadow-sm" title="Hapus Produk">
                                                        <span class="material-symbols-outlined text-[16px]">delete</span>
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <!-- Favorite Button untuk Non-Admin -->
                                                <button aria-label="Favoritkan" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-surface-container-lowest/80 backdrop-blur-md flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors shadow-sm">
                                                    <span class="material-symbols-outlined text-[18px]">favorite</span>
                                                </button>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Title & Rating -->
                                        <div class="flex items-center justify-between gap-2 mb-2">
                                            <h2 class="font-title-lg text-title-lg text-on-surface font-semibold tracking-tight group-hover:text-primary transition-colors">
                                                <?= esc($nama) ?>
                                            </h2>
                                            <?php if (!empty($stok) && $stok > 0): ?>
                                                <div class="flex items-center gap-1 bg-surface-container/60 px-2 py-0.5 rounded-full">
                                                    <span class="material-symbols-outlined text-tertiary-container text-[16px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                                    <span class="font-label-md text-label-md text-on-surface font-semibold">4.9</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Description -->
                                        <p class="font-body-md text-body-md text-on-surface-variant line-clamp-2 mb-4 leading-relaxed">
                                            <?= esc($deskripsi) ?>
                                        </p>
                                    </div>

                                    <!-- Price and Action -->
                                    <div class="pt-3 flex items-center justify-between">
                                        <div class="flex flex-col">
                                            <span class="font-label-sm text-label-sm text-outline uppercase font-semibold">Harga</span>
                                            <span class="font-headline-md text-headline-md text-primary font-bold tracking-tight">Rp <?= number_format($harga, 0, ',', '.') ?></span>
                                        </div>
                                        <button onclick='openDetailModal(<?= json_encode($produk, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-full bg-primary text-on-primary font-label-md text-label-md shadow-[0_6px_16px_-2px_rgba(159,60,22,0.35)] hover:bg-primary-container transition-all">
                                            <span class="material-symbols-outlined text-[18px]">shopping_bag</span>
                                            <span>Pesan</span>
                                        </button>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-span-full text-center py-16">
                                <div class="text-6xl mb-4">🏺</div>
                                <h3 class="text-2xl font-bold text-on-surface mb-2">Belum Ada Produk</h3>
                                <p class="text-on-surface-variant mb-6">Tambahkan produk pertama Anda untuk memulai katalog</p>
                                <?php if (isset($user) && $user && isset($role) && $role === 'admin'): ?>
                                    <button onclick="openAddModal()" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-full bg-primary text-on-primary font-label-md text-label-md shadow-[0_6px_16px_-2px_rgba(159,60,22,0.35)] hover:bg-primary-container transition-all">
                                        <span class="material-symbols-outlined text-[18px]">add</span>
                                        <span>Tambah Produk Pertama</span>
                                    </button>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <div class="py-10 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <span class="font-body-md text-body-md text-on-surface-variant">Menampilkan</span>
                        <span class="font-title-md text-title-md text-on-surface">1 – <?= count($produks ?? []) ?></span>
                        <span class="font-body-md text-body-md text-on-surface-variant">dari 10 koleksi kurasi</span>
                    </div>

                    <nav aria-label="Navigasi Halaman" class="inline-flex items-center gap-1 bg-surface-container-lowest/70 backdrop-blur-xl p-1.5 rounded-full shadow-[0_12px_28px_-6px_rgba(42,30,23,0.06)]">
                        <button aria-label="Sebelumnya" class="w-9 h-9 rounded-full flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition-colors disabled:opacity-40 disabled:cursor-not-allowed" disabled="">
                            <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                        </button>
                        <button class="w-9 h-9 rounded-full bg-primary text-on-primary font-label-md text-label-md font-semibold shadow-sm">
                            1
                        </button>
                        <button class="w-9 h-9 rounded-full hover:bg-surface-container-high text-on-surface-variant font-label-md text-label-md font-medium flex items-center justify-center transition-colors">
                            2
                        </button>
                        <button aria-label="Berikutnya" class="w-9 h-9 rounded-full flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition-colors">
                            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                        </button>
                    </nav>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Tambah/Edit Produk -->
    <div id="formModal" class="hidden fixed inset-0 z-50 flex items-center justify-center modal-overlay p-4">
        <div class="modal-content w-full max-w-xl max-h-[90vh] overflow-y-auto rounded-3xl bg-surface-container-lowest shadow-2xl border border-surface-container-high">
            <div class="flex items-center justify-between px-6 py-4 border-b border-surface-container-high bg-surface-container-low/50">
                <h3 id="formModalTitle" class="text-xl font-bold text-on-surface">Tambah Produk</h3>
                <button onclick="closeModal('formModal')" class="w-8 h-8 rounded-full hover:bg-surface-container-high flex items-center justify-center text-on-surface-variant transition-colors">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <form id="produkForm" method="post" action="/tambah" enctype="multipart/form-data" class="p-6 space-y-4">
                <input type="hidden" id="formMode" name="mode" value="tambah">
                <?= csrf_field() ?>

                <div>
                    <label for="nama_produk" class="font-label-md text-label-md font-semibold text-on-surface block mb-1">Nama Produk <span class="text-red-600">*</span></label>
                    <input type="text" id="nama_produk" name="nama_produk" class="w-full px-4 py-2.5 rounded-xl bg-surface-container-lowest border border-outline/30 text-on-surface placeholder:text-outline focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm" placeholder="Contoh: Pot Keramik Minimalis" required minlength="3" maxlength="255">
                </div>

                <div>
                    <label for="kategori" class="font-label-md text-label-md font-semibold text-on-surface block mb-1">Kategori</label>
                    <select id="kategori" name="kategori" class="w-full px-4 py-2.5 rounded-xl bg-surface-container-lowest border border-outline/30 text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm">
                        <option value="Keramik">Keramik</option>
                        <option value="Kayu">Kayu</option>
                        <option value="Beton">Beton</option>
                        <option value="Terakota">Terakota</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="harga" class="font-label-md text-label-md font-semibold text-on-surface block mb-1">Harga (Rp) <span class="text-red-600">*</span></label>
                        <input type="number" id="harga" name="harga" class="w-full px-4 py-2.5 rounded-xl bg-surface-container-lowest border border-outline/30 text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm" placeholder="85000" required min="0" step="1">
                    </div>

                    <div>
                        <label for="stok" class="font-label-md text-label-md font-semibold text-on-surface block mb-1">Stok <span class="text-red-600">*</span></label>
                        <input type="number" id="stok" name="stok" class="w-full px-4 py-2.5 rounded-xl bg-surface-container-lowest border border-outline/30 text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm" placeholder="10" required min="0" step="1">
                    </div>
                </div>

                <div>
                    <label for="gambar" class="font-label-md text-label-md font-semibold text-on-surface block mb-1">URL Gambar</label>
                    <input type="url" id="gambar" name="gambar" class="w-full px-4 py-2.5 rounded-xl bg-surface-container-lowest border border-outline/30 text-on-surface placeholder:text-outline focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm" placeholder="https://example.com/gambar.jpg">
                </div>

                <div>
                    <label for="deskripsi" class="font-label-md text-label-md font-semibold text-on-surface block mb-1">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="w-full px-4 py-2.5 rounded-xl bg-surface-container-lowest border border-outline/30 text-on-surface placeholder:text-outline focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm" rows="3" placeholder="Tuliskan deskripsi ringkas produk..." maxlength="1000"></textarea>
                </div>

                <div>
                    <label for="status" class="font-label-md text-label-md font-semibold text-on-surface block mb-1">Status</label>
                    <select id="status" name="status" class="w-full px-4 py-2.5 rounded-xl bg-surface-container-lowest border border-outline/30 text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm">
                        <option value="aktif">Aktif</option>
                        <option value="non-aktif">Non-aktif</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-surface-container-high">
                    <button type="button" onclick="closeModal('formModal')" class="px-5 py-2 rounded-full border border-outline/30 text-on-surface-variant hover:bg-surface-container-high transition-all text-sm font-medium">
                        Batal
                    </button>
                    <button type="submit" class="inline-flex items-center gap-1.5 px-6 py-2 rounded-full bg-primary text-on-primary font-medium text-sm shadow-[0_6px_16px_-2px_rgba(159,60,22,0.35)] hover:bg-primary-container transition-all">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        <span>Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Detail Produk -->
    <div id="detailModal" class="hidden fixed inset-0 z-50 flex items-center justify-center modal-overlay p-4">
        <div class="modal-content w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-3xl bg-surface-container-lowest shadow-2xl border border-surface-container-high">
            <div class="flex items-center justify-between p-6 border-b border-surface-container-high">
                <h3 class="text-2xl font-bold text-on-surface">Detail Produk</h3>
                <button onclick="closeModal('detailModal')" class="text-on-surface-variant hover:text-on-surface transition-colors">
                    <span class="material-symbols-outlined text-[28px]">close</span>
                </button>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="rounded-2xl overflow-hidden bg-surface-container-low/70 flex items-center justify-center min-h-[300px]">
                        <div id="detailImageContainer" class="w-full aspect-square overflow-hidden rounded-2xl flex items-center justify-center">
                            <!-- Image / Fallback Placeholder akan di-render dinamis oleh JavaScript -->
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h2 id="detailNama" class="font-title-lg text-title-lg text-on-surface font-semibold tracking-tight mb-2"></h2>
                                <span id="detailKategori" class="px-3 py-1 rounded-full text-xs font-semibold bg-secondary-container text-on-secondary-container"></span>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h4 class="font-label-md text-label-md text-on-surface-variant mb-2 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">description</span>
                                Deskripsi
                            </h4>
                            <p id="detailDeskripsi" class="font-body-md text-body-md text-on-surface-variant leading-relaxed"></p>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-6">
                            <div class="bg-primary-container/20 p-4 rounded-2xl">
                                <div class="font-label-sm text-label-sm text-on-surface-variant mb-1 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px]">attach_money</span>
                                    Harga
                                </div>
                                <div id="detailHarga" class="font-headline-md text-headline-md text-primary font-bold"></div>
                            </div>
                            <div class="bg-primary-container/20 p-4 rounded-2xl">
                                <div class="font-label-sm text-label-sm text-on-surface-variant mb-1 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px]">inventory_2</span>
                                    Stok
                                </div>
                                <div id="detailStok" class="font-headline-md text-headline-md text-on-surface font-bold"></div>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="font-label-sm text-label-sm text-on-surface-variant">Status</span>
                                <span id="detailStatus"></span>
                            </div>

                            <button onclick="alert('Fitur pesan akan segera hadir!')" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-full bg-primary text-on-primary font-label-md text-label-md font-semibold shadow-[0_6px_16px_-2px_rgba(159,60,22,0.35)] hover:bg-primary-container hover:shadow-lg transition-all">
                                <span class="material-symbols-outlined text-[20px]">shopping_cart</span>
                                <span>Pesan Sekarang</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="relative z-10 w-full mt-space-3xl bg-surface-container-low/70 backdrop-blur-xl">
        <div class="max-w-[1280px] mx-auto px-gutter-mobile lg:px-gutter-desktop py-space-2xl flex flex-col md:flex-row items-center justify-between gap-space-lg">
            <div class="flex flex-col items-center md:items-start gap-space-2xs">
                <div class="flex items-center gap-space-xs">
                    <span class="font-title-md text-title-md text-on-surface">Griya Pot Bunga</span>
                    <span class="px-space-xs py-0.5 rounded-full bg-secondary-container text-on-secondary-container font-label-sm text-label-sm">Keramik Alami</span>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant text-center md:text-left">
                    © <?= date('Y') ?> Griya Pot Bunga. Kurasi gerabah tanah liat dan pot botanikal artisanal.
                </p>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-space-xs">
                <div class="inline-flex items-center gap-1.5 px-space-sm py-space-xs rounded-full bg-surface-container-high/60 text-on-surface-variant font-label-sm text-label-sm">
                    <span class="material-symbols-outlined text-secondary text-[16px]">eco</span>
                    <span>100% Organik</span>
                </div>
                <div class="inline-flex items-center gap-1.5 px-space-sm py-space-xs rounded-full bg-surface-container-high/60 text-on-surface-variant font-label-sm text-label-sm">
                    <span class="material-symbols-outlined text-tertiary text-[16px]">palette</span>
                    <span>Handcrafted</span>
                </div>
                <div class="inline-flex items-center gap-1.5 px-space-sm py-space-xs rounded-full bg-surface-container-high/60 text-on-surface-variant font-label-sm text-label-sm">
                    <span class="material-symbols-outlined text-primary text-[16px]">local_shipping</span>
                    <span>Kemasan Aman</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        (function() {
            const searchInput = document.getElementById('potSearchInput');
            const filterButtons = document.querySelectorAll('.filter-btn');
            const productItems = document.querySelectorAll('.product-item');
            const productCountEl = document.getElementById('productCount');
            let currentFilter = 'all';

            function updateCatalog() {
                const query = (searchInput.value || '').toLowerCase().trim();
                let visibleCount = 0;

                productItems.forEach(item => {
                    const category = item.getAttribute('data-category');
                    const name = (item.getAttribute('data-name') || '').toLowerCase();

                    const matchesCategory = (currentFilter === 'all' || category === currentFilter);
                    const matchesSearch = !query || name.includes(query);

                    if (matchesCategory && matchesSearch) {
                        item.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        item.classList.add('hidden');
                    }
                });

                if (productCountEl) {
                    productCountEl.textContent = visibleCount;
                }
            }

            filterButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    filterButtons.forEach(b => {
                        b.classList.remove('bg-primary', 'text-on-primary', 'shadow-sm');
                        b.classList.add('bg-surface-container-low/80', 'text-on-surface-variant');
                    });
                    btn.classList.remove('bg-surface-container-low/80', 'text-on-surface-variant');
                    btn.classList.add('bg-primary', 'text-on-primary', 'shadow-sm');
                    currentFilter = btn.getAttribute('data-filter');
                    updateCatalog();
                });
            });

            if (searchInput) {
                searchInput.addEventListener('input', updateCatalog);
            }
        })();

        function openAddModal() {
            document.getElementById('formMode').value = 'tambah';
            document.getElementById('formModalTitle').textContent = 'Tambah Produk';
            document.getElementById('produkForm').action = '/tambah';
            document.getElementById('produkForm').reset();
            document.getElementById('formModal').classList.remove('hidden');
        }

        function openEditModal(produk) {
            document.getElementById('formMode').value = 'edit';
            document.getElementById('formModalTitle').textContent = 'Edit Produk';
            document.getElementById('produkForm').action = '/edit-produk/' + (produk.id_produk || produk.id);

            document.getElementById('nama_produk').value = produk.nama_produk || '';
            document.getElementById('kategori').value = produk.kategori || 'Keramik';
            document.getElementById('harga').value = produk.harga || 0;
            document.getElementById('stok').value = produk.stok || 0;
            document.getElementById('gambar').value = produk.gambar || '';
            document.getElementById('deskripsi').value = produk.deskripsi || '';
            document.getElementById('status').value = produk.status || 'aktif';

            document.getElementById('formModal').classList.remove('hidden');
        }

        function openDetailModal(produk) {
            try {
                if (!produk || typeof produk !== 'object') {
                    throw new Error('Data produk tidak valid');
                }

                const nama = produk.nama_produk || 'Nama Produk';
                const kategori = produk.kategori || 'Umum';
                const deskripsi = produk.deskripsi || 'Tidak ada deskripsi tersedia.';
                const harga = Number(produk.harga) || 0;
                const stok = Number(produk.stok) || 0;
                const status = produk.status || 'non-aktif';

                const namaEl = document.getElementById('detailNama');
                const kategoriEl = document.getElementById('detailKategori');
                const deskripsiEl = document.getElementById('detailDeskripsi');
                const hargaEl = document.getElementById('detailHarga');
                const stokEl = document.getElementById('detailStok');
                const statusEl = document.getElementById('detailStatus');
                const modal = document.getElementById('detailModal');

                if (!modal) {
                    throw new Error('Element #detailModal tidak ditemukan');
                }

                if (namaEl) namaEl.textContent = nama;
                if (kategoriEl) kategoriEl.textContent = kategori;
                if (deskripsiEl) deskripsiEl.textContent = deskripsi;
                if (hargaEl) hargaEl.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(harga);
                if (stokEl) stokEl.textContent = stok + ' unit';

                if (statusEl) {
                    statusEl.innerHTML = status === 'aktif' ?
                        '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-primary-container text-on-primary-container">Aktif</span>' :
                        '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-surface-container-high/60 text-on-surface-variant">Non-aktif</span>';
                }

                // Handling render Gambar / Placeholder tanpa Teks Font Meluap
                const container = document.getElementById('detailImageContainer');
                if (container) {
                    container.innerHTML = ''; // Kosongkan isi kontainer agar tidak menumpuk

                    let imageUrl = String(produk.gambar || '').trim();

                    if (imageUrl) {
                        let finalSrc = imageUrl;
                        if (!imageUrl.startsWith('http://') && !imageUrl.startsWith('https://')) {
                            finalSrc = '<?= base_url() ?>/' + imageUrl.replace(/^\/+/, '');
                        }

                        // Buat elemen gambar secara dinamis
                        const img = document.createElement('img');
                        img.id = 'detailImage';
                        img.src = finalSrc;
                        img.alt = nama;
                        img.className = 'w-full h-full object-cover transition-transform duration-300 hover:scale-105';

                        // Jika URL gambar error/rusak, ganti isi kontainer dengan fallback
                        img.onerror = function() {
                            container.innerHTML = `
                <div class="w-full h-full flex flex-col items-center justify-center text-on-surface-variant/50 bg-surface-container-high/40 p-6 text-center select-none">
                    <span class="text-5xl mb-2">🪴</span>
                    <span class="text-xs font-medium text-outline">Gambar tidak tersedia</span>
                </div>`;
                        };

                        container.appendChild(img);
                    } else {
                        // Tampilan jika produk tidak memiliki URL gambar sama sekali
                        container.innerHTML = `
            <div class="w-full h-full flex flex-col items-center justify-center text-on-surface-variant/50 bg-surface-container-high/40 p-6 text-center select-none">
                <span class="text-5xl mb-2">🪴</span>
                <span class="text-xs font-medium text-outline">Gambar tidak tersedia</span>
            </div>`;
                    }
                }

                modal.classList.remove('hidden');

            } catch (error) {
                console.error('Error opening detail modal:', error);
                alert('Terjadi kesalahan saat menampilkan detail produk.\n\n' + error.message);
            }
        }

        function performLogout() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                window.location.href = '/logout';
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.modal-overlay').forEach(function(modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.classList.add('hidden');
                    }
                });
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.modal-overlay').forEach(function(modal) {
                        modal.classList.add('hidden');
                    });
                }
            });
        });

        setTimeout(function() {
            const notif = document.getElementById('flash-notification');
            if (notif) {
                notif.style.opacity = '0';
                notif.style.transform = 'translateY(-20px)';
                notif.style.transition = 'all 0.4s ease';
                setTimeout(function() {
                    notif.remove();
                }, 400);
            }
        }, 4000);

        setTimeout(function() {
            const notif = document.getElementById('flash-notification-error');
            if (notif) {
                notif.style.opacity = '0';
                notif.style.transform = 'translateY(-20px)';
                notif.style.transition = 'all 0.4s ease';
                setTimeout(function() {
                    notif.remove();
                }, 400);
            }
        }, 4000);
    </script>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .aspect-square {
            aspect-ratio: 1/1;
        }

        .aspect-video {
            aspect-ratio: 16/9;
        }

        .scrollbar-none {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(58, 42, 32, 0.7);
            backdrop-filter: blur(8px);
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .modal-overlay:not(.hidden) {
            display: flex;
        }

        .modal-overlay.hidden {
            display: none !important;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
    </style>
</body>

</html>