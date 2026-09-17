<?php $revenueData = $revenueData ?? []; $paymentStats = $paymentStats ?? []; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Rounded" rel="stylesheet">

    <style>
        :root { --primary: #9f3c16; }
        body { background-color: #f5f5f5; font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar { min-height: 100vh; background-color: #212529; }
        .sidebar .nav-link { color: #adb5bd; padding: 0.75rem 1rem; }
        .sidebar .nav-link:hover { color: white; background-color: #343a40; }
        .sidebar .nav-link.active { color: white; background-color: var(--primary); }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-none d-md-block bg-dark sidebar">
                <div class="p-3 mb-4"><h4 class="text-white fw-bold">Admin Panel</h4></div>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?= base_url('/admin/laporan') ?>">Laporan</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/admin/transaksi') ?>">Transaksi</a></li>
                </ul>
            </nav>

            <main class="col-md-9 col-lg-10 ms-auto">
                <div class="p-4">
                    <h1 class="fw-bold mb-4">Laporan</h1>

                    <div class="row g-4 mb-4">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="material-symbols-outlined text-primary" style="font-size: 36px;">calendar_today</i>
                                    <h6 class="mt-2 text-muted">Tanggal Awal</h6>
                                    <p class="mb-0 fw-bold"><?= esc($startDate ?? date('d M Y')) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="material-symbols-outlined text-primary" style="font-size: 36px;">calendar_today</i>
                                    <h6 class="mt-2 text-muted">Tanggal Akhir</h6>
                                    <p class="mb-0 fw-bold"><?= esc($endDate ?? date('d M Y')) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="material-symbols-outlined text-success" style="font-size: 36px;">attach_money</i>
                                    <h6 class="mt-2 text-muted">Total Pendapatan</h6>
                                    <p class="mb-0 fw-bold">Rp <?= number_format($totalRevenue ?? 0, 0, ',', '.') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="material-symbols-outlined text-info" style="font-size: 36px;">receipt_long</i>
                                    <h6 class="mt-2 text-muted">Total Transaksi</h6>
                                    <p class="mb-0 fw-bold"><?= esc($totalTransactions ?? 0) ?> transaksi</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Grafik Pendapatan</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="revenueChart" height="200"></canvas>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Transaksi Berdasarkan Metode</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Metode Pembayaran</th>
                                        <th>Jumlah</th>
                                        <th>Persentase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($paymentStats as $method): ?>
                                        <tr>
                                            <td><?= esc(ucfirst($method['method'])) ?></td>
                                            <td>Rp <?= number_format($method['total'], 0, ',', '.') ?></td>
                                            <td><?= esc($method['percentage']) ?>%</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var revenueData = <?= json_encode($revenueData ?? []) ?>;

        var ctx = document.getElementById('revenueChart').getContext('2d');
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
    </script>
</body>
</html>