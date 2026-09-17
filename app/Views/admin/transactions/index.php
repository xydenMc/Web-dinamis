<?php
$transactions = $transactions ?? [];

function getStatusBadge($status) {
    $statuses = [
        'pending' => ['label' => 'Pending', 'class' => 'warning'],
        'processing' => ['label' => 'Processing', 'class' => 'info'],
        'shipped' => ['label' => 'Dikirim', 'class' => 'primary'],
        'completed' => ['label' => 'Selesai', 'class' => 'success'],
        'cancelled' => ['label' => 'Dibatalkan', 'class' => 'danger']
    ];
    return $statuses[$status] ?? ['label' => ucfirst($status), 'class' => 'secondary'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi - Admin</title>

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
                    <li class="nav-item"><a class="nav-link active" href="<?= base_url('/admin/transaksi') ?>">Transaksi</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/admin/laporan') ?>">Laporan</a></li>
                </ul>
            </nav>

            <main class="col-md-9 col-lg-10 ms-auto">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="fw-bold mb-0">Daftar Transaksi</h1>
                    </div>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= esc($error) ?></div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-body">
                            <?php if (count($transactions) > 0): ?>
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>Invoice</th>
                                            <th>Pelanggan</th>
                                            <th>Total</th>
                                            <th>Metode</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($transactions as $transaction):
                                            $trxId = $transaction->id ?? $transaction['id'];
                                            $invNumber = $transaction->invoice_number ?? $transaction['invoice_number'];
                                            $nama = $transaction->nama_penerima ?? $transaction['nama_penerima'];
                                            $total = $transaction->total ?? 0;
                                            $bayar = $transaction->metode_bayar ?? 'cod';
                                            $status = $transaction->status ?? 'pending';
                                            $tanggal = $transaction->created_at ?? date('Y-m-d H:i:s');
                                            $statusInfo = getStatusBadge($status);
                                        ?>
                                            <tr>
                                                <td><code><?= esc($invNumber) ?></code></td>
                                                <td><?= esc($nama) ?></td>
                                                <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
                                                <td><?= esc(ucfirst($bayar)) ?></td>
                                                <td>
                                                    <span class="badge bg-<?= $statusInfo['class'] ?>"><?= $statusInfo['label'] ?></span>
                                                </td>
                                                <td><?= date('d M Y', strtotime($tanggal)) ?></td>
                                                <td>
                                                    <a href="<?= base_url('/admin/transaksi/' . $trxId) ?>" class="btn btn-sm btn-outline-primary">
                                                        <span class="material-symbols-outlined">visibility</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <i class="material-symbols-outlined text-muted" style="font-size: 48px;">receipt_long</i>
                                    <p class="mt-2 text-muted">Belum ada transaksi</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>