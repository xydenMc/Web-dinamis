<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard POS Admin - Griya Pot Bunga') ?></title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
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
                        "tertiary-container": "#9e683c",
                        "background": "#fcf9f4",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#f6f3ee",
                        "surface-container-high": "#ebe8e3",
                        "on-surface": "#1c1c19",
                        "on-surface-variant": "#57423b"
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif']
                    }
                }
            }
        };
    </script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background-color: #fcf9f4;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* iOS 26 Liquid Glass Effect */
        .liquid-glass {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 8px 32px 0 rgba(42, 30, 23, 0.06), 0 2px 8px 0 rgba(42, 30, 23, 0.04);
        }

        .liquid-glass-pill {
            background: rgba(246, 243, 238, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }
    </style>
</head>

<body class="min-h-screen text-on-surface relative overflow-x-hidden selection:bg-primary/20 selection:text-primary">

    <!-- Ambient Glowing Background Bubbles -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-[10%] left-[10%] w-[500px] h-[500px] rounded-full bg-primary/10 blur-[140px]"></div>
        <div class="absolute top-[30%] -right-[5%] w-[450px] h-[450px] rounded-full bg-secondary-container/40 blur-[130px]"></div>
        <div class="absolute -bottom-[10%] left-[20%] w-[600px] h-[600px] rounded-full bg-tertiary-container/15 blur-[160px]"></div>
    </div>

    <!-- Navigation Header -->
    <header class="sticky top-4 inset-x-0 z-40 px-4 lg:px-8 max-w-[1280px] mx-auto">
        <div class="w-full h-20 liquid-glass rounded-full px-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white shadow-md">
                    <span class="material-symbols-outlined text-[22px]">point_of_sale</span>
                </div>
                <div>
                    <h1 class="text-base font-bold text-on-surface leading-tight">Dashboard POS Admin</h1>
                    <p class="text-xs text-on-surface-variant font-medium">Griya Pot Bunga • Sistem Kasir & Penjualan</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="<?= base_url('/') ?>" class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-full liquid-glass-pill text-xs font-semibold text-on-surface hover:bg-surface-container-high transition-all">
                    <span class="material-symbols-outlined text-[18px]">store</span>
                    <span>Lihat Toko</span>
                </a>
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-primary/10 text-primary font-semibold text-xs">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    <span>Admin Mode</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="relative z-10 max-w-[1280px] mx-auto px-4 lg:px-8 py-8 space-y-6">

        <!-- Top Stat Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- Stat 1: Total Pendapatan -->
            <div class="liquid-glass rounded-3xl p-5 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Total Pendapatan</span>
                    <div class="w-9 h-9 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">payments</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-primary mb-1">Rp 12.850.000</h3>
                    <p class="text-xs text-secondary font-medium flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">trending_up</span>
                        <span>+14.5% dari bulan lalu</span>
                    </p>
                </div>
            </div>

            <!-- Stat 2: Transaksi Selesai -->
            <div class="liquid-glass rounded-3xl p-5 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Transaksi POS</span>
                    <div class="w-9 h-9 rounded-2xl bg-secondary/10 text-secondary flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">receipt_long</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-on-surface mb-1">148 Transaksi</h3>
                    <p class="text-xs text-secondary font-medium flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">check_circle</span>
                        <span>24 transaksi hari ini</span>
                    </p>
                </div>
            </div>

            <!-- Stat 3: Produk Terjual -->
            <div class="liquid-glass rounded-3xl p-5 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Produk Terjual</span>
                    <div class="w-9 h-9 rounded-2xl bg-tertiary/10 text-tertiary flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">local_mall</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-on-surface mb-1">312 Pot</h3>
                    <p class="text-xs text-on-surface-variant font-medium flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">inventory_2</span>
                        <span>Terlaris: Pot Keramik</span>
                    </p>
                </div>
            </div>

            <!-- Stat 4: Stok Menipis -->
            <div class="liquid-glass rounded-3xl p-5 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Peringatan Stok</span>
                    <div class="w-9 h-9 rounded-2xl bg-amber-500/10 text-amber-700 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">warning</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-amber-800 mb-1">5 Produk</h3>
                    <p class="text-xs text-amber-700 font-medium">Stok kurang dari 3 unit</p>
                </div>
            </div>
        </div>

        <!-- Charts Section (Graph & Donut/Pie Chart) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Line Chart: Tren Penjualan Harian (2 Cols) -->
            <div class="lg:col-span-2 liquid-glass rounded-3xl p-6 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-lg font-bold text-on-surface">Grafik Penjualan POS</h2>
                        <p class="text-xs text-on-surface-variant">Ringkasan pendapatan 7 hari terakhir</p>
                    </div>
                    <span class="px-3 py-1 rounded-full liquid-glass-pill text-xs font-semibold text-on-surface-variant">Minggu Ini</span>
                </div>
                <div class="w-full relative h-[280px]">
                    <canvas id="salesLineChart"></canvas>
                </div>
            </div>

            <!-- Pie Chart: Distribusi Kategori Produk (1 Col) -->
            <div class="liquid-glass rounded-3xl p-6 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-lg font-bold text-on-surface">Kategori Terlaris</h2>
                        <p class="text-xs text-on-surface-variant">Persentase penjualan per bahan</p>
                    </div>
                </div>
                <div class="w-full relative h-[240px] flex items-center justify-center">
                    <canvas id="categoryPieChart"></canvas>
                </div>
            </div>
        </div>

        <!-- POS Recent Transactions Table Placeholder -->
        <div class="liquid-glass rounded-3xl p-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-5">
                <div>
                    <h2 class="text-lg font-bold text-on-surface">Transaksi Terakhir Kasir (POS)</h2>
                    <p class="text-xs text-on-surface-variant">Aktivitas pembelian langsung di toko</p>
                </div>
                <button class="px-4 py-2 rounded-full bg-primary text-white font-semibold text-xs shadow-md hover:bg-primary-container transition-all flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">add_shopping_cart</span>
                    <span>Buka Kasir Baru</span>
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-on-surface">
                    <thead>
                        <tr class="border-b border-surface-container-high text-xs font-semibold text-on-surface-variant uppercase">
                            <th class="py-3 px-4">ID Transaksi</th>
                            <th class="py-3 px-4">Waktu</th>
                            <th class="py-3 px-4">Item Dipilih</th>
                            <th class="py-3 px-4">Metode Bayar</th>
                            <th class="py-3 px-4">Total</th>
                            <th class="py-3 px-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container-high/60 font-medium text-xs">
                        <tr class="hover:bg-white/40 transition-colors">
                            <td class="py-3.5 px-4 font-bold text-primary">#POS-8821</td>
                            <td class="py-3.5 px-4 text-on-surface-variant">11:20 WIB</td>
                            <td class="py-3.5 px-4">2x Pot Keramik Minimalis</td>
                            <td class="py-3.5 px-4">QRIS (GoPay/BCA)</td>
                            <td class="py-3.5 px-4 font-bold">Rp 170.000</td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-800 font-semibold">Lunas</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-white/40 transition-colors">
                            <td class="py-3.5 px-4 font-bold text-primary">#POS-8820</td>
                            <td class="py-3.5 px-4 text-on-surface-variant">10:45 WIB</td>
                            <td class="py-3.5 px-4">1x Terrarium Kaca Bulat</td>
                            <td class="py-3.5 px-4">Tunai / Cash</td>
                            <td class="py-3.5 px-4 font-bold">Rp 65.000</td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-800 font-semibold">Lunas</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-white/40 transition-colors">
                            <td class="py-3.5 px-4 font-bold text-primary">#POS-8819</td>
                            <td class="py-3.5 px-4 text-on-surface-variant">09:15 WIB</td>
                            <td class="py-3.5 px-4">3x Set Pot Bunga Kayu</td>
                            <td class="py-3.5 px-4">Debit Card</td>
                            <td class="py-3.5 px-4 font-bold">Rp 585.000</td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-800 font-semibold">Lunas</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Chart Configuration Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Palette Warna Griya Pot Bunga
            const colorPrimary = '#9f3c16';
            const colorSecondary = '#45664e';
            const colorTertiary = '#825026';
            const colorContainer = '#c4e9cb';
            const colorGold = '#fbb985';

            // 1. Line Chart: Tren Penjualan Harian
            const ctxLine = document.getElementById('salesLineChart').getContext('2d');
            
            // Linear Gradient untuk fill chart
            const gradientLine = ctxLine.createLinearGradient(0, 0, 0, 250);
            gradientLine.addColorStop(0, 'rgba(159, 60, 22, 0.35)');
            gradientLine.addColorStop(1, 'rgba(159, 60, 22, 0.0)');

            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: [1200000, 1500000, 1100000, 1800000, 2300000, 3100000, 2800000],
                        borderColor: colorPrimary,
                        borderWidth: 3,
                        backgroundColor: gradientLine,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: colorPrimary,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Plus Jakarta Sans', size: 11 } }
                        },
                        y: {
                            grid: { color: 'rgba(0, 0, 0, 0.04)' },
                            ticks: {
                                font: { family: 'Plus Jakarta Sans', size: 10 },
                                callback: function (value) {
                                    return 'Rp ' + (value / 1000) + 'k';
                                }
                            }
                        }
                    }
                }
            });

            // 2. Pie / Donut Chart: Kategori Terlaris
            const ctxPie = document.getElementById('categoryPieChart').getContext('2d');
            new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: ['Keramik', 'Terakota', 'Kayu', 'Beton'],
                    datasets: [{
                        data: [45, 25, 20, 10],
                        backgroundColor: [
                            colorPrimary,
                            colorSecondary,
                            colorTertiary,
                            colorGold
                        ],
                        borderWidth: 4,
                        borderColor: '#ffffff',
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' },
                                boxWidth: 12,
                                padding: 15
                            }
                        }
                    },
                    cutout: '68%'
                }
            });
        });
    </script>
</body>

</html>