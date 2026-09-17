<?php
$transaction = $transaction ?? null;
$items = $items ?? [];

function getStatusBadge($status) {
    $statuses = [
        'pending' => 'warning',
        'processing' => 'info',
        'shipped' => 'primary',
        'completed' => 'success',
        'cancelled' => 'danger'
    ];
    return $statuses[$status] ?? 'secondary';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi - Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Rounded" rel="stylesheet">

    <style>
        :root { --primary: #9f3c16; }
        body { background-color: #f5f5f5; font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar { min-height: 100vh; background-color: #212529; }
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
                </ul>
            </nav>

            <main class="col-md-9 col-lg-10 ms-auto">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="fw-bold mb-0">Detail Transaksi</h1>
                        <a href="<?= base_url('/admin/transaksi') ?>" class="btn btn-outline-secondary">
                            <span class="material-symbols-outlined">arrow_back</span>
                        </a>
                    </div>

                    <?php if (!$transaction): ?>
                        <div class="alert alert-warning">Transaksi tidak ditemukan</div>
                    <?php else: ?>
                        <?php $invNo = $transaction->invoice_number ?? $transaction['invoice_number'] ?? '-'; ?>
                        <?php $penerima = $transaction->nama_penerima ?? $transaction['nama_penerima'] ?? '-'; ?>
                        <?php $telepon = $transaction->telepon ?? $transaction['telepon'] ?? '-'; ?>
                        <?php $email = $transaction->email ?? $transaction['email'] ?? '-'; ?>
                        <?php $alamat = $transaction->alamat_lengkap ?? $transaction['alamat_lengkap'] ?? '-'; ?>
                        <?php $kota = $transaction->kota ?? $transaction['kota'] ?? '-'; ?>
                        <?php $provinsi = $transaction->provinsi ?? $transaction['provinsi'] ?? '-'; ?>
                        <?php $kodePos = $transaction->kode_pos ?? $transaction['kode_pos'] ?? '-'; ?>
                        <?php $catatan = $transaction->catatan ?? $transaction['catatan'] ?? ''; ?>
                        <?php $status = $transaction->status ?? $transaction['status'] ?? 'pending'; ?>
                        <?php $metode = $transaction->metode_bayar ?? $transaction['metode_bayar'] ?? 'cod'; ?>
                        <?php $subtotal = $transaction->subtotal ?? $transaction['subtotal'] ?? 0; ?>
                        <?php $ongkos = $transaction->ongkos_kirim ?? $transaction['ongkos_kirim'] ?? 0; ?>
                        <?php $total = $transaction->total ?? $transaction['total'] ?? 0; ?>
                        <?php $trxId = $transaction->id ?? $transaction['id'] ?? 0; ?>
                        <?php $createdAt = $transaction->created_at ?? $transaction['created_at'] ?? date('Y-m-d H:i:s'); ?>
                        <?php $statusClass = getStatusBadge($status); ?>

                        <div class="row g-4">
                            <div class="col-lg-7">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Informasi Transaksi</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Invoice:</strong></p>
                                                <code class="text-muted"><?= esc($invNo) ?></code>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Status:</strong></p>
                                                <span class="badge bg-<?= $statusClass ?>"><?= ucfirst($status) ?></span>
                                            </div>
                                        </div>

                                        <hr>

                                        <h6 class="mb-3">Pengirim</h6>
                                        <p class="mb-2">
                                            <strong><?= esc($penerima) ?></strong><br>
                                            <?= esc($telepon) ?><br>
                                            <?= esc($email) ?>
                                        </p>

                                        <h6 class="mb-3">Alamat Pengiriman</h6>
                                        <p class="mb-2">
                                            <?= esc($alamat) ?><br>
                                            <?= esc($kota) ?>, <?= esc($provinsi) ?>
                                            <br>
                                            <?= esc($kodePos) ?>
                                        </p>

                                        <?php if ($catatan): ?>
                                            <h6 class="mb-3">Catatan Pesanan</h6>
                                            <p class="mb-0 text-muted"><?= esc($catatan) ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">Metode Pembayaran</h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Ongkos Kirim:</strong> Rp <?= number_format($ongkos, 0, ',', '.') ?></p>
                                        <p><strong>Metode:</strong> <?= esc(ucfirst($metode)) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">Ringkasan Pesanan</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php if (count($items) > 0): ?>
                                            <div class="mb-3">
                                                <h6 class="mb-2">Item Pesanan</h6>
                                                <?php foreach ($items as $item):
                                                    $itemNama = $item->nama_produk ?? $item['nama_produk'] ?? '-';
                                                    $itemQty = $item->qty ?? $item['qty'] ?? 1;
                                                    $itemTotal = $item->subtotal ?? $item['subtotal'] ?? 0;
                                                ?>
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span><?= esc($itemNama) ?> × <?= esc($itemQty) ?></span>
                                                        <span>Rp <?= number_format($itemTotal, 0, ',', '.') ?></span>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>

                                        <hr>

                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Subtotal:</span>
                                            <strong>Rp <?= number_format($subtotal, 0, ',', '.') ?></strong>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Ongkos Kirim:</span>
                                            <strong>Rp <?= number_format($ongkos, 0, ',', '.') ?></strong>
                                        </div>

                                        <hr>

                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="h5">Total Bayar</span>
                                            <span class="h5 text-primary">Rp <?= number_format($total, 0, ',', '.') ?></span>
                                        </div>

                                        <?php if ($status != 'completed'): ?>
                                            <form action="<?= base_url('/admin/transaksi/' . $trxId . '/update-status') ?>" method="POST">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="status" value="processing">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <span class="material-symbols-outlined">check_circle</span>
                                                    <span class="ms-1">Proses Transaksi</span>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>