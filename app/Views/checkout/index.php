<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Toko Online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Rounded" rel="stylesheet">

    <style>
        :root { --primary: #9f3c16; }
        body { background-color: #f5f5f5; font-family: 'Plus Jakarta Sans', sans-serif; }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); }
        .step-indicator { --bs-badge: #dee2e6; }
        .step-indicator .badge { --bs-badge-bg: var(--bs-badge); }
    </style>
</head>
<body>
    <div class="container py-4">
        <h1 class="fw-bold mb-4">Checkout</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?= esc($error) ?>
            </div>
        <?php endif; ?>

        <?php if (!isset($cart) || count($cart) == 0): ?>
            <div class="text-center py-5">
                <i class="material-symbols-outlined text-muted" style="font-size: 64px;">shopping_cart</i>
                <h5 class="mt-3 text-muted">Keranjang Anda kosong</h5>
                <a href="<?= base_url('/katalog') ?>" class="btn btn-primary mt-3">
                    <span class="material-symbols-outlined">arrow_back</span>
                    <span class="ms-2">Lanjut Belanja</span>
                </a>
            </div>
        <?php else: ?>
            <form action="<?= base_url('/checkout/process') ?>" method="POST" id="checkoutForm">
                <?= csrf_field() ?>

                <div class="row g-4">
                    <div class="col-lg-7">
                        <!-- Shipping Address -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><span class="material-symbols-outlined">location_on</span> Alamat Pengiriman</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="nama_penerima" class="form-label">Nama Penerima *</label>
                                    <input type="text" class="form-control" id="nama_penerima" name="nama_penerima"
                                           value="<?= esc($user->nama ?? '') ?>" required>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="telepon" class="form-label">No. Telepon *</label>
                                        <input type="tel" class="form-control" id="telepon" name="telepon"
                                               value="<?= esc($user->telepon ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                               value="<?= esc($user->email ?? '') ?>" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="alamat_lengkap" class="form-label">Alamat Lengkap *</label>
                                    <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap"
                                              rows="3" required><?= esc($user->alamat ?? '') ?></textarea>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="kota" class="form-label">Kota</label>
                                        <input type="text" class="form-control" id="kota" name="kota"
                                               value="<?= esc($user->kota ?? '') ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="provinsi" class="form-label">Provinsi</label>
                                        <input type="text" class="form-control" id="provinsi" name="provinsi"
                                               value="<?= esc($user->provinsi ?? '') ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="kode_pos" class="form-label">Kode Pos</label>
                                        <input type="text" class="form-control" id="kode_pos" name="kode_pos"
                                               value="<?= esc($user->kode_pos ?? '') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><span class="material-symbols-outlined">payment</span> Metode Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="metode_bayar" id="transfer" value="transfer" checked>
                                    <label class="form-check-label" for="transfer">
                                        <strong>Transfer Bank</strong>
                                        <br><small>ATM / Internet Banking / E-Wallet</small>
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="metode_bayar" id="cod" value="cod">
                                    <label class="form-check-label" for="cod">
                                        <strong>COD (Bayar di Tempat)</strong>
                                        <br><small>Bayar langsung saat diterima</small>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="metode_bayar" id="qris" value="qris">
                                    <label class="form-check-label" for="qris">
                                        <strong>QRIS</strong>
                                        <br><small>Scan QR Code untuk pembayaran</small>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Order Notes -->
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><span class="material-symbols-outlined">description</span> Catatan Pesanan</h5>
                            </div>
                            <div class="card-body">
                                <textarea class="form-control" name="catatan" id="catatan" rows="2"
                                          placeholder="Masukkan catatan khusus untuk pesanan (opsional)"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><span class="material-symbols-outlined">receipt_long</span> Ringkasan Pesanan</h5>
                            </div>
                            <div class="card-body">
                                <?php if (isset($cart) && count($cart) > 0): ?>
                                    <?php foreach ($cart as $item): ?>
                                    <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                                        <div class="d-flex align-items-start">
                                            <img src="<?= $item['image'] ? base_url('uploads/products/' . $item['image']) : base_url('assets/images/placeholder.png') ?>"
                                                 alt="<?= esc($item['nama']) ?>" class="img-fluid rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                            <div class="ms-3">
                                                <p class="fw-medium mb-1"><?= esc($item['nama']) ?></p>
                                                <p class="text-muted small mb-0">Qty: <?= esc($item['qty']) ?></p>
                                            </div>
                                        </div>
                                        <p class="mb-0 fw-medium">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></p>
                                    </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                                <hr>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal</span>
                                    <strong>Rp <?= number_format($subtotal ?? 0, 0, ',', '.') ?></strong>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Ongkos Kirim</span>
                                    <strong>Rp <?= number_format($ongkos_kirim ?? 0, 0, ',', '.') ?></strong>
                                </div>

                                <?php if (isset($voucher) && $voucher['potongan'] > 0): ?>
                                <div class="d-flex justify-content-between mb-2 text-success">
                                    <span>Voucher (<?= esc($voucher['kode']) ?>)</span>
                                    <strong>-Rp <?= number_format($voucher['potongan'], 0, ',', '.') ?></strong>
                                </div>
                                <?php endif; ?>

                                <hr>

                                <div class="d-flex justify-content-between mb-4">
                                    <span class="h5">Total Bayar</span>
                                    <span class="h5 text-primary">Rp <?= number_format($total ?? 0, 0, ',', '.') ?></span>
                                </div>

                                <button type="submit" class="btn btn-success w-100 py-3 mb-3">
                                    <span class="material-symbols-outlined">payment</span>
                                    <span class="ms-2">Bayar Sekarang</span>
                                </button>

                                <a href="<?= base_url('/keranjang') ?>" class="btn btn-outline-secondary w-100">
                                    <span class="material-symbols-outlined">arrow_back</span>
                                    <span class="ms-2">Kembali ke Keranjang</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.getElementById('checkoutForm')?.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Memproses...';
            submitBtn.disabled = true;
        }
    });
    </script>
</body>
</html>