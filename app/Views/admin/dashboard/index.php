<?php
function getStatusBadge($status) {
    $statusMap = [
        'pending' => 'warning',
        'processing' => 'info',
        'shipped' => 'primary',
        'completed' => 'success',
        'cancelled' => 'danger'
    ];
    return $statusMap[$status] ?? 'secondary';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Toko Online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Rounded" rel="stylesheet">

    <style>
        :root { --primary: #9f3c16; --secondary: #6c757d; --success: #198754; --danger: #dc3545; }
        body { background-color: #f5f5f5; font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar { min-height: 100vh; background-color: #212529; }
        .sidebar .nav-link { color: #adb5bd; padding: 0.75rem 1rem; }
        .sidebar .nav-link:hover { color: white; background-color: #343a40; }
        .sidebar .nav-link.active { color: white; background-color: var(--primary); }
        .stat-card { border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .card-header { background-color: #f8f9fa; border-bottom: 1px solid #e9ecef; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="sidebar col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="p-3 mb-4 text-center">
                        <h4 class="text-white fw-bold">Admin Panel</h4>
                        <small class="text-muted">Toko Online</small>
                    </div>
                    <ul class="nav flex-column mb-4">
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= base_url('/admin/dashboard') ?>">
                                <span class="material-symbols-outlined">dashboard</span>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/admin/produk') ?>">
                                <span class="material-symbols-outlined">inventory</span>
                                Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/admin/kategori') ?>">
                                <span class="material-symbols-outlined">category</span>
                                Kategori
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/admin/video') ?>">
                                <span class="material-symbols-outlined">video_library</span>
                                Video
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/admin/transaksi') ?>">
                                <span class="material-symbols-outlined">receipt</span>
                                Transaksi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/admin/laporan') ?>">
                                <span class="material-symbols-outlined">assessment</span>
                                Laporan
                            </a>
                        </li>
                    </ul>

                    <hr style="border-color: #343a40;">

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/') ?>" target="_blank">
                                <span class="material-symbols-outlined">open_in_new</span>
                                Lihat Website
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/admin/auth/logout') ?>">
                                <span class="material-symbols-outlined">logout</span>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 ms-md-auto py-4 px-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">Dashboard</h1>
                    <div class="text-end">
                        <small class="text-muted">Selamat datang, <strong><?= esc($user->nama ?? 'Admin') ?></strong></small>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-xl-3 col-md-6">
                        <div class="stat-card card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="material-symbols-outlined text-primary" style="font-size: 32px;">inventory</i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-muted small mb-1">Produk</h6>
                                        <h4 class="mb-0"><?= esc($stats['products'] ?? 0) ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="stat-card card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="material-symbols-outlined text-success" style="font-size: 32px;">category</i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-muted small mb-1">Kategori</h6>
                                        <h4 class="mb-0"><?= esc($stats['categories'] ?? 0) ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="stat-card card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="material-symbols-outlined text-info" style="font-size: 32px;">shopping_cart</i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-muted small mb-1">Keranjang</h6>
                                        <h4 class="mb-0"><?= esc($stats['cart_items'] ?? 0) ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="stat-card card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="material-symbols-outlined text-warning" style="font-size: 32px;">receipt</i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-muted small mb-1">Transaksi</h6>
                                        <h4 class="mb-0"><?= esc($stats['transactions'] ?? 0) ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue Chart -->
                <div class="row g-4 mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Pendapatan Bulanan</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="revenueChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="row g-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Pesanan Terbaru</h5>
                            </div>
                            <div class="card-body">
                                <?php $recentOrders = $recent_orders ?? []; if (count($recentOrders) > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Invoice</th>
                                                <th>Pelanggan</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recentOrders as $order): ?>
                                            <tr>
                                                <td><code><?= esc($order['invoice_number']) ?></code></td>
                                                <td><?= esc($order['nama_penerima']) ?></td>
                                                <td>Rp <?= number_format($order['total'], 0, ',', '.') ?></td>
                                                <td>
                                                    <span class="badge bg-<?= getStatusBadge($order['status']) ?>"><?= ucfirst($order['status']) ?></span>
                                                </td>
                                                <td><?= date('d M Y', strtotime($order['created_at'])) ?></td>
                                                <td>
                                                    <a href="<?= base_url('/admin/transaksi/' . $order['id']) ?>" class="btn btn-sm btn-outline-primary">
                                                        <span class="material-symbols-outlined">visibility</span>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php else: ?>
                                    <div class="text-center py-4">
                                        <i class="material-symbols-outlined text-muted" style="font-size: 48px;">receipt_long</i>
                                        <p class="mt-2 text-muted">Belum ada pesanan terbaru</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Revenue Chart
        const ctx = document.getElementById('revenueChart')?.getContext('2d');
        if (ctx) {
            const revenueData = <?= isset($revenue_data) ? json_encode($revenue_data) : '[]' ?>;
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: revenueData.map(function(d) { return d.month; }),
                    datasets: [{
                        label: 'Pendapatan',
                        data: revenueData.map(function(d) { return d.total; }),
                        borderColor: '#9f3c16',
                        backgroundColor: 'rgba(159, 60, 22, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>