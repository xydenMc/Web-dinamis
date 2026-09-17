<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Berhasil - Toko Online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Rounded" rel="stylesheet">

    <style>
        :root { --primary: #9f3c16; --success: #198754; }
        body { background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%); font-family: 'Plus Jakarta Sans', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .success-card { border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="success-card text-center p-4">
                    <div class="mb-4">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                             style="width: 100px; height: 100px;">
                            <i class="material-symbols-outlined text-success" style="font-size: 60px;">check_circle</i>
                        </div>
                    </div>

                    <h1 class="fw-bold mb-3">Transaksi Berhasil!</h1>
                    <p class="text-muted mb-4">Terima kasih atas pesanan Anda. Pesanan Anda akan kami proses sesegera mungkin.</p>

                    <?php if (isset($transaction)): ?>
                    <div class="alert alert-light border" style="border-radius: 12px;">
                        <h6 class="mb-2"><strong>Nomor Invoice:</strong></h6>
                        <code class="h5 mb-0"><?= esc($transaction['invoice_number'] ?? 'INV-' . date('YmdHis')) ?></code>

                        <div class="row mt-3 text-center">
                            <div class="col-4">
                                <small class="text-muted">Total</small>
                                <h6 class="mb-0">Rp <?= number_format($transaction['total'] ?? 0, 0, ',', '.') ?></h6>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Metode</small>
                                <h6 class="mb-0"><?= esc(ucfirst($transaction['metode_bayar'] ?? 'COD')) ?></h6>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Status</small>
                                <h6 class="mb-0">Pending</h6>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <a href="<?= base_url('/katalog') ?>" class="btn btn-primary px-4 py-2">
                            <span class="material-symbols-outlined">home</span>
                            <span class="ms-2">Lanjut Belanja</span>
                        </a>

                        <a href="<?= base_url('/admin/transactions') ?>" class="btn btn-outline-secondary px-4 py-2">
                            <span class="material-symbols-outlined">receipt</span>
                            <span class="ms-2">Lihat Invoice</span>
                        </a>
                    </div>

                    <div class="mt-4">
                        <small class="text-muted">
                            Mohon simpan nomor invoice untuk referensi lebih lanjut.<br>
                            Anda akan menerima email konfirmasi pesanan di <?php if (isset($transaction)): ?> <?= esc($transaction['email'] ?? 'email pendaftaran') ?><?php endif; ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>