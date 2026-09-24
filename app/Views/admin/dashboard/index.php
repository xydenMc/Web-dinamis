<!DOCTYPE html>

<html lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?= esc($title ?? 'Dashboard Ikhtisar Studio') ?> | Griya Pot Bunga</title>
<!-- Google Fonts: Plus Jakarta Sans & Playfair Display -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&amp;family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&amp;display=swap" rel="stylesheet"/>
<!-- Tailwind CSS v3 with Plugins -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Tailwind Configuration for Terracotta & Glass Botanica theme -->
<script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            clay: {
              50: '#fdf8f5',
              100: '#faede6',
              200: '#f5d9cd',
              300: '#ecbca8',
              400: '#df9477',
              500: '#c85a32', /* Primary Terracotta */
              600: '#b94e27',
              700: '#9b3d1c',
              800: '#7c331a',
              900: '#662d18',
            },
            botanica: {
              sand: '#fcf9f4',
              surface: '#f7f2ea',
              dark: '#261e1a',
              muted: '#71655e',
              sage: '#5c735d',
              sageLight: '#eef3ee',
              amberLight: '#fcf6e8',
              amberBorder: '#f0dfbe',
              amberDark: '#936a16'
            }
          },
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
            serif: ['"Playfair Display"', 'Georgia', 'serif']
          },
          boxShadow: {
            'liquid': '0 8px 32px 0 rgba(197, 106, 73, 0.08), 0 2px 8px 0 rgba(0, 0, 0, 0.03)',
            'liquid-glow': '0 10px 25px -4px rgba(200, 90, 50, 0.35)',
            'subtle-glass': '0 4px 24px -1px rgba(50, 30, 20, 0.04)'
          },
          backdropBlur: {
            '2xl': '40px'
          }
        }
      }
    }
  </script>
<style data-purpose="custom-glass-effects">
    /* iOS 26 Liquid Glass Texture and Surface Refinements */
    .glass-surface {
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.82) 0%, rgba(255, 255, 255, 0.58) 100%);
      backdrop-filter: blur(28px) saturate(160%);
      -webkit-backdrop-filter: blur(28px) saturate(160%);
      border: 1px solid rgba(255, 255, 255, 0.85);
    }

    .glass-sidebar {
      background: linear-gradient(180deg, rgba(253, 250, 246, 0.88) 0%, rgba(247, 242, 235, 0.94) 100%);
      backdrop-filter: blur(32px);
      -webkit-backdrop-filter: blur(32px);
    }

    /* Ambient terracotta organic blur blob */
    .bg-blob-glow {
      position: fixed;
      pointer-events: none;
      border-radius: 9999px;
      filter: blur(90px);
      z-index: 0;
      opacity: 0.45;
    }
  </style>
</head>
<body class="bg-botanica-sand text-botanica-dark font-sans min-h-screen antialiased flex selection:bg-clay-200 selection:text-clay-900 relative overflow-x-hidden">
<!-- Ambient background glow spots -->
<div class="bg-blob-glow w-[520px] h-[520px] bg-clay-200/40 -top-32 -left-20"></div>
<div class="bg-blob-glow w-[640px] h-[640px] bg-amber-100/40 bottom-0 right-10"></div>
<!-- BEGIN: Sidebar -->
<aside class="w-72 fixed inset-y-0 left-0 z-30 glass-sidebar border-r border-stone-200/60 flex flex-col justify-between p-6 shadow-subtle-glass transition-all">
<div>
<!-- Brand Logo & Studio Identity -->
<div class="flex items-center gap-3.5 pb-7 mb-7 border-b border-stone-200/60" data-purpose="brand-header">
<div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-clay-500 to-clay-600 flex items-center justify-center text-white shadow-liquid-glow shadow-clay-500/25 ring-2 ring-white/80">
<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<path d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" stroke-linecap="round" stroke-linejoin="round"></path>
<path d="M6 18.5c1.5 2 4 2.5 6 2.5s4.5-.5 6-2.5l-1-7H7l-1 7z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</div>
<div>
<h1 class="font-serif font-bold text-lg text-botanica-dark tracking-tight leading-tight">Griya Pot Bunga</h1>
<p class="text-[10px] tracking-wider font-semibold uppercase text-clay-600 mt-0.5">STUDIO KASONGAN / PANEL ADMIN</p>
</div>
</div>
<!-- Navigation Menu Group 1: Studio Operations -->
<div class="space-y-6">
<div>
<p class="text-[11px] font-bold tracking-widest text-botanica-muted/70 uppercase px-3 mb-2.5">Menu Studio</p>
<nav class="space-y-1.5">
<!-- Active Item: Dashboard -->
<a class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-gradient-to-r from-clay-500 to-clay-600 text-white font-medium text-sm shadow-liquid-glow transition-all" href="<?= base_url('/dashboard') ?>">
<svg class="w-5 h-5 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<rect height="7" rx="1.5" width="7" x="3" y="3"></rect>
<rect height="7" rx="1.5" width="7" x="14" y="3"></rect>
<rect height="7" rx="1.5" width="7" x="14" y="14"></rect>
<rect height="7" rx="1.5" width="7" x="3" y="14"></rect>
</svg>
<span>Dashboard</span>
</a>
<!-- Menu: Pesanan Masuk -->
<a class="flex items-center justify-between px-4 py-3 rounded-2xl text-botanica-dark/80 hover:text-clay-600 hover:bg-stone-200/40 transition font-medium text-sm" href="<?= base_url('/admin/transaksi') ?>">
<div class="flex items-center gap-3">
<svg class="w-5 h-5 text-botanica-muted" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
<span>Pesanan Masuk</span>
</div>
<span class="text-xs bg-stone-200/70 text-botanica-dark font-medium px-2 py-0.5 rounded-full"><?= esc($stats['pending_orders']) ?></span>
</a>
<!-- Menu: Katalog Karya / Produk -->
<a class="flex items-center gap-3 px-4 py-3 rounded-2xl text-botanica-dark/80 hover:text-clay-600 hover:bg-stone-200/40 transition font-medium text-sm" href="<?= base_url('/admin/kelola-produk') ?>">
<svg class="w-5 h-5 text-botanica-muted" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
<span>Kelola Produk</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-2xl text-botanica-dark/80 hover:text-clay-600 hover:bg-stone-200/40 transition font-medium text-sm" href="<?= base_url('/admin/laporan') ?>"><span class="w-5 text-center">PDF</span><span>Laporan Pesanan</span></a>
</nav>
</div>
<!-- Navigation Menu Group 2: Public Access -->
<div>
<p class="text-[11px] font-bold tracking-widest text-botanica-muted/70 uppercase px-3 mb-2.5">Akses Toko</p>
<a class="flex items-center justify-between px-4 py-3 rounded-2xl text-botanica-dark/80 hover:text-clay-600 hover:bg-stone-200/40 transition font-medium text-sm group" href="<?= base_url('/') ?>" target="_blank">
<div class="flex items-center gap-3">
<svg class="w-5 h-5 text-botanica-muted group-hover:text-clay-600 transition" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
<span>Lihat Etalase</span>
</div>
<svg class="w-4 h-4 text-stone-400 group-hover:translate-x-0.5 transition" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</a>
</div>
</div>
</div>
<!-- Sidebar Bottom: Kiln Status & Logout -->
<div class="pt-4 border-t border-stone-200/60 space-y-3">
<!-- Logout Action -->
<a class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-stone-500 hover:text-red-700 hover:bg-red-50/60 transition text-sm font-medium" href="<?= base_url('/admin/logout') ?>">
<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
<span>Keluar Sesi Admin</span>
</a>
</div>
</aside>
<!-- END: Sidebar -->
<!-- BEGIN: Main Dashboard Content Area -->
<main class="ml-72 flex-1 min-h-screen px-8 py-8 lg:px-12 lg:py-10 z-10 max-w-7xl">
<!-- BEGIN: Topbar & Header -->
<header class="flex flex-col md:flex-row md:items-center justify-between gap-5 mb-8" data-purpose="top-navigation">
<div>
<nav class="flex items-center gap-2 text-xs text-botanica-muted font-medium mb-1.5">
<span>Griya Pot Bunga</span>
<span class="text-stone-300">/</span>
<span class="text-clay-600 font-semibold">Ikhtisar Toko</span>
</nav>
<div class="flex items-center gap-3">
<h2 class="font-serif text-3xl font-bold text-botanica-dark tracking-tight">Dashboard Ikhtisar Studio</h2>
<span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-100/70 text-emerald-800 border border-emerald-200/60">
<span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
            Data terkini
          </span>
</div>
</div>
<!-- Quick Actions and Profile -->
<div class="flex items-center gap-4">
<!-- New Artwork Button -->
<a href="<?= base_url('/admin/kelola-produk') ?>" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-gradient-to-r from-clay-500 to-clay-600 hover:from-clay-600 hover:to-clay-700 text-white font-medium text-sm shadow-liquid-glow transition transform active:scale-98">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewbox="0 0 24 24">
<path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
<span>Kelola Produk</span>
</a>
<!-- Admin Profile Pill -->
<div class="flex items-center gap-3 pl-3 pr-4 py-1.5 rounded-full glass-surface shadow-subtle-glass border border-white/80">
<div class="w-9 h-9 rounded-full bg-clay-100 border border-clay-200 flex items-center justify-center text-clay-700 font-semibold text-sm shadow-inner">
            <?= esc(strtoupper(substr($admin_name, 0, 1))) ?>
          </div>
<div class="text-left text-xs pr-1">
<p class="text-stone-400 text-[10px] leading-tight">Selamat datang,</p>
<p class="font-semibold text-botanica-dark"><?= esc($admin_name) ?></p>
</div>
</div>
</div>
</header>
<!-- END: Topbar & Header -->
<!-- BEGIN: Alert Sync Banner -->
<div class="mb-8 rounded-2xl p-4 bg-botanica-amberLight/90 border border-botanica-amberBorder text-botanica-dark shadow-sm flex items-center gap-3.5 backdrop-blur-md">
<div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0 border border-amber-200">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<circle cx="12" cy="12" r="10"></circle>
<line x1="12" x2="12" y1="16" y2="12"></line>
<line x1="12" x2="12.01" y1="8" y2="8"></line>
</svg>
</div>
<p class="text-xs sm:text-sm font-medium text-stone-700">
        Data dashboard diambil langsung dari transaksi dan katalog toko.
      </p>
</div>
<!-- END: Alert Sync Banner -->
<!-- BEGIN: 4 Metric KPI Cards -->
<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8" data-purpose="kpi-metrics-grid">
<!-- Metric 1: Total Koleksi Produk -->
<div class="glass-surface p-6 rounded-3xl shadow-liquid flex flex-col justify-between hover:translate-y-[-2px] transition duration-300">
<div class="flex items-start justify-between mb-4">
<div class="w-11 h-11 rounded-2xl bg-clay-50 border border-clay-100 flex items-center justify-center text-clay-600 shadow-sm">
<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<rect height="16" rx="2" width="18" x="3" y="4"></rect>
<path d="M7 8h10M7 12h10M7 16h4"></path>
</svg>
</div>
<span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/50">
            <?= esc($active_products) ?> aktif
          </span>
</div>
<div>
<p class="text-[11px] font-bold uppercase tracking-wider text-botanica-muted">Total Koleksi Produk</p>
<h3 class="text-3xl font-serif font-bold text-botanica-dark mt-1"><?= esc($stats['total_products']) ?></h3>
<p class="text-xs text-botanica-muted mt-1 font-medium">SKU dalam katalog</p>
</div>
</div>
<!-- Metric 2: Kategori Produk -->
<div class="glass-surface p-6 rounded-3xl shadow-liquid flex flex-col justify-between hover:translate-y-[-2px] transition duration-300">
<div class="flex items-start justify-between mb-4">
<div class="w-11 h-11 rounded-2xl bg-stone-100/70 border border-stone-200 flex items-center justify-center text-botanica-sage shadow-sm">
<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM9 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</div>
<span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-stone-100 text-stone-600">
            Standar
          </span>
</div>
<div>
<p class="text-[11px] font-bold uppercase tracking-wider text-botanica-muted">Kategori Produk</p>
<h3 class="text-3xl font-serif font-bold text-botanica-dark mt-1"><?= esc($stats['total_categories']) ?></h3>
<p class="text-xs text-botanica-muted mt-1 font-medium">Kelompok koleksi tersedia</p>
</div>
</div>
<!-- Metric 3: Pesanan Menunggu -->
<div class="glass-surface p-6 rounded-3xl shadow-liquid flex flex-col justify-between hover:translate-y-[-2px] transition duration-300">
<div class="flex items-start justify-between mb-4">
<div class="w-11 h-11 rounded-2xl bg-amber-50 border border-amber-200/60 flex items-center justify-center text-amber-700 shadow-sm">
<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</div>
<span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-stone-100 text-stone-600">
            <?= esc($stats['today_transactions']) ?> hari ini
          </span>
</div>
<div>
<p class="text-[11px] font-bold uppercase tracking-wider text-botanica-muted">Pesanan Menunggu</p>
<h3 class="text-3xl font-serif font-bold text-botanica-dark mt-1"><?= esc($stats['pending_orders']) ?></h3>
<p class="text-xs text-botanica-muted mt-1 font-medium">Perlu ditindaklanjuti</p>
</div>
</div>
<!-- Metric 4: Omzet Bulan Ini -->
<div class="glass-surface p-6 rounded-3xl shadow-liquid flex flex-col justify-between hover:translate-y-[-2px] transition duration-300">
<div class="flex items-start justify-between mb-4">
<div class="w-11 h-11 rounded-2xl bg-clay-500/10 border border-clay-200 flex items-center justify-center text-clay-600 shadow-sm">
<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</div>
<span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-clay-100 text-clay-700">
            Bulan ini
          </span>
</div>
<div>
<p class="text-[11px] font-bold uppercase tracking-wider text-botanica-muted">Omzet Bulan Ini</p>
<h3 class="text-2xl font-serif font-bold text-botanica-dark mt-1 leading-tight tracking-tight">Rp <?= number_format($stats['month_revenue'], 0, ',', '.') ?></h3>
<p class="text-xs text-stone-500 mt-1 font-medium">Hari ini: <span class="font-semibold text-botanica-dark">Rp <?= number_format($stats['today_revenue'], 0, ',', '.') ?></span></p>
</div>
</div>
</section>
<!-- END: 4 Metric KPI Cards -->
<!-- BEGIN: Analytics & Stock Section -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
<!-- Left Column: Revenue per Product Breakdown (Pie/Donut View) -->
<section class="lg:col-span-7 glass-surface p-7 rounded-3xl shadow-liquid border border-white/80" data-purpose="chart-container">
<!-- Card Header -->
<div class="flex items-center justify-between pb-6 border-b border-stone-200/50">
<div>
<h3 class="font-serif text-xl font-bold text-botanica-dark">Pendapatan per Produk</h3>
<p class="text-xs text-botanica-muted mt-0.5">Nilai penjualan produk 30 hari terakhir</p>
</div>
<span class="text-xs font-semibold px-3 py-1 rounded-full bg-stone-100 text-botanica-muted border border-stone-200">
            30 hari
          </span>
</div>
<div class="py-8 h-72 flex items-center justify-center">
<?php if (!empty($sales_chart_data)): ?><canvas id="salesPieChart" aria-label="Pendapatan per produk 30 hari terakhir"></canvas><?php else: ?><p class="text-sm text-botanica-muted">Belum ada penjualan pada periode ini.</p><?php endif; ?>
</div>
</section>
<!-- Right Column: Stock Warning & Collection Promo -->
<div class="lg:col-span-5 space-y-6">
<!-- Stock Attention Card -->
<section class="glass-surface p-7 rounded-3xl shadow-liquid border border-white/80" data-purpose="stock-warning">
<div class="flex items-center justify-between pb-4 border-b border-stone-200/50 mb-5">
<div>
<h3 class="font-serif text-xl font-bold text-botanica-dark">Stok Perlu Perhatian</h3>
<p class="text-xs text-botanica-muted mt-0.5">Produk dengan stok maksimal 5 unit</p>
</div>
<a class="text-xs font-semibold text-clay-600 hover:text-clay-700 underline underline-offset-4 transition" href="<?= base_url('/admin/kelola-produk') ?>">
              Kelola
            </a>
</div>
<?php if ($low_stock_products): foreach ($low_stock_products as $product): $stock = (int) $product['stok']; ?>
<div class="space-y-2 mb-5"><div class="flex items-center justify-between gap-3 text-sm"><span class="font-medium text-botanica-dark"><?= esc($product['nama_produk']) ?></span><span class="font-bold text-xs text-clay-600 bg-clay-50 px-2.5 py-1 rounded-full border border-clay-200"><?= $stock ?> unit</span></div><div class="w-full bg-stone-100 rounded-full h-2.5 overflow-hidden p-0.5"><div class="bg-gradient-to-r from-clay-500 to-clay-600 h-1.5 rounded-full shadow-sm" style="width:<?= max(8, min(100, $stock * 20)) ?>%"></div></div></div>
<?php endforeach; else: ?><p class="text-sm text-botanica-muted">Tidak ada produk aktif dengan stok 5 unit atau kurang.</p><?php endif; ?>
</section>
<!-- Promotion / Call to Action Card -->
<section class="rounded-3xl p-7 bg-gradient-to-br from-white/90 via-clay-50/60 to-clay-100/40 border border-clay-200/70 shadow-liquid relative overflow-hidden backdrop-blur-xl">
<!-- Subtle decorative flower outline watermark -->
<div class="absolute -right-6 -bottom-6 w-32 h-32 opacity-10 pointer-events-none text-clay-700">
<svg fill="currentColor" viewbox="0 0 100 100">
<circle cx="50" cy="50" r="30"></circle>
<circle cx="50" cy="15" r="15"></circle>
<circle cx="50" cy="85" r="15"></circle>
<circle cx="15" cy="50" r="15"></circle>
<circle cx="85" cy="50" r="15"></circle>
</svg>
</div>
<div class="relative z-10 space-y-3">
<div class="w-9 h-9 rounded-2xl bg-clay-500 text-white flex items-center justify-center shadow-liquid-glow shadow-clay-500/30">
<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</div>
<h4 class="font-serif text-lg font-bold text-botanica-dark">Kelola koleksi toko</h4>
<p class="text-xs text-botanica-muted leading-relaxed">
              Perbarui nama, harga, stok, dan status produk yang tampil di etalase publik.
            </p>
<div class="pt-2">
<a class="inline-flex items-center gap-2 text-xs font-bold text-clay-600 hover:text-clay-700 group transition" href="<?= base_url('/admin/kelola-produk') ?>">
<span>Buka Kelola Produk</span>
<span class="group-hover:translate-x-1 transition duration-200">&rarr;</span>
</a>
</div>
</div>
</section>
</div>
<!-- END: Right Column -->
</div>
<!-- END: Analytics & Stock Section -->
<section class="mt-8 glass-surface p-7 rounded-3xl shadow-liquid border border-white/80">
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5"><div><h3 class="font-serif text-xl font-bold text-botanica-dark">Pesanan Terbaru</h3><p class="text-xs text-botanica-muted mt-1">Data transaksi checkout terbaru.</p></div><a class="text-xs font-bold text-clay-600" href="<?= base_url('/admin/transaksi') ?>">Lihat semua pesanan &rarr;</a></div>
<div class="overflow-x-auto"><table class="w-full text-left text-sm"><thead><tr class="border-b border-stone-200 text-xs uppercase text-botanica-muted"><th class="py-3 pr-4">Nomor pesanan</th><th class="py-3 pr-4">Pelanggan</th><th class="py-3 pr-4">Tanggal</th><th class="py-3 pr-4">Status</th><th class="py-3 text-right">Total</th></tr></thead><tbody><?php foreach ($recent_orders as $order): ?><tr class="border-b border-stone-100"><td class="py-3 pr-4 font-semibold text-clay-700">#<?= esc($order['invoice_number']) ?></td><td class="py-3 pr-4"><?= esc($order['nama_penerima'] ?: 'Pelanggan') ?></td><td class="py-3 pr-4"><?= esc(date('d M Y', strtotime($order['created_at']))) ?></td><td class="py-3 pr-4"><?= esc($order['status']) ?></td><td class="py-3 text-right font-semibold">Rp <?= number_format((float) $order['total'], 0, ',', '.') ?></td></tr><?php endforeach; ?><?php if (!$recent_orders): ?><tr><td colspan="5" class="py-8 text-center text-botanica-muted">Belum ada pesanan.</td></tr><?php endif; ?></tbody></table></div>
</section>
<!-- BEGIN: Studio Footer Info -->
<footer class="mt-14 pt-6 border-t border-stone-200/60 flex flex-col sm:flex-row items-center justify-between text-xs text-botanica-muted gap-3"><p>© <?= date('Y') ?> Griya Pot Bunga.</p><span>Dashboard membaca data saat halaman dibuka.</span></footer>
<!-- END: Studio Footer Info -->
</main>
<!-- END: Main Dashboard Content Area -->
<script>
const salesPie = document.getElementById('salesPieChart');
if (salesPie) new Chart(salesPie, {
    type: 'pie',
    data: {
        labels: <?= json_encode(array_column($sales_chart_data, 'label'), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>,
        datasets: [{ data: <?= json_encode(array_column($sales_chart_data, 'value')) ?>, backgroundColor: ['#c85a32','#5c735d','#d8a74e','#6587a8','#9c74a8','#d77979','#7ca5a1','#b58b67'], borderColor: '#fcf9f4', borderWidth: 3 }]
    },
    options: { maintainAspectRatio: false, plugins: { legend: { position: 'right' }, tooltip: { callbacks: { label: item => item.label + ': Rp ' + Number(item.raw).toLocaleString('id-ID') } } } }
});
</script>
</body></html>
