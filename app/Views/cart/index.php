<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Toko Online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Rounded" rel="stylesheet">

    <style>
        :root { --primary: #9f3c16; }
        body { background-color: #f5f5f5; font-family: 'Plus Jakarta Sans', sans-serif; }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-none d-md-block bg-dark sidebar">
                <div class="p-3 mb-4"><h4 class="text-white fw-bold">Admin Panel</h4></div>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/') ?>">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?= base_url('/keranjang') ?>">Keranjang</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/checkout') ?>">Checkout</a></li>
                </ul>
            </nav>

            <main class="col-md-9 col-lg-10 ms-auto">
                <div class="p-4">
                    <h1 class="fw-bold mb-4">Keranjang Belanja</h1>

                    <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= esc($error) ?>
                    </div>
                    <?php endif; ?>

                    <?php if (isset($success)): ?>
                    <div class="alert alert-success" role="alert">
                        <?= esc($success) ?>
                    </div>
                    <?php endif; ?>

                    <?php if (isset($cart) && count($cart) > 0): ?>
                    <div class="card">
                        <div class="card-body">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart as $item): ?>
                                    <tr data-item-id="<?= esc($item['id']) ?>">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?= $item['image'] ? base_url('uploads/products/' . $item['image']) : base_url('assets/images/placeholder.png') ?>"
                                                     alt="<?= esc($item['nama']) ?>" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                                <span class="ms-3 fw-medium"><?= esc($item['nama']) ?></span>
                                            </div>
                                        </td>
                                        <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                                        <td>
                                            <input type="number" class="form-control qty-input" value="<?= esc($item['qty']) ?>"
                                                   min="1" max="<?= esc($item['stok']) ?>"
                                                   data-id="<?= esc($item['id']) ?>">
                                        </td>
                                        <td class="fw-medium">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                        <td>
                                            <button class="btn btn-danger btn-sm" onclick="removeItem(<?= esc($item['id']) ?>)">
                                                <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="fw-bold mb-3">Kode Penggunaan</h5>
                                    <form action="<?= base_url('/keranjang/apply-coupon') ?>" method="POST">
                                        <?= csrf_field() ?>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="coupon_code" placeholder="Masukkan kode promo">
                                            <button class="btn btn-primary" type="submit">Terapkan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="fw-bold mb-3">Ringkasan Pembayaran</h5>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal : </span>
                                        <strong>Rp <?= number_format($subtotal ?? 0, 0, ',', '.') ?></strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Ongkos kirim : </span>
                                        <strong>Rp <?= number_format($ongkos_kirim ?? 0, 0, ',', '.') ?></strong>
                                    </div>
                                    <?php if (isset($diskon) && $diskon > 0): ?>
                                    <div class="d-flex justify-content-between mb-2 text-success">
                                        <span>Diskon : </span>
                                        <strong>-Rp <?= number_format($diskon, 0, ',', '.') ?></strong>
                                    </div>
                                    <?php endif; ?>
                                    <hr>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="h5">Total : </span>
                                        <span class="h5 text-primary">Rp <?= number_format($total ?? 0, 0, ',', '.') ?></span>
                                    </div>
                                    <a href="<?= base_url('/checkout') ?>" class="btn btn-primary w-100 py-2">
                                        <span class="material-symbols-outlined">shopping_cart_checkout</span>
                                        <span class="ms-2">Lanjut ke Checkout</span>
                                    </a>
                                    <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary w-100 mt-2 py-2">
                                        <span class="material-symbols-outlined">arrow_back</span>
                                        <span class="ms-2">Lanjut Belanja</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function updateQuantity(tr, input) {
        const itemId = input.dataset.id;
        const qty = input.value;

        fetch('<?= base_url('/api/cart/update') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: itemId,
                qty: qty,
                _csrf_token: '<?= csrf_hash() ?>'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                showToast(data.message || 'Gagal memperbarui keranjang', 'danger');
            }
        });
    }

    function removeItem(itemId) {
        if (confirm('Yakin ingin menghapus item ini dari keranjang?')) {
            fetch('<?= base_url('/api/cart/remove') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: itemId,
                    _csrf_token: '<?= csrf_hash() ?>'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Item berhasil dihapus', 'success');
                    location.reload();
                } else {
                    showToast(data.message || 'Gagal menghapus item', 'danger');
                }
            });
        }
    }

    function showToast(message, type) {
        const toast = document.createElement('div');
        toast.className = 'alert alert-' + type + ' alert-dismissible fade show position-fixed top-0 end-0 m-3';
        toast.style.zIndex = '1050';
        toast.setAttribute('role', 'alert');
        toast.innerHTML = message + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('fade');
            setTimeout(() => toast.remove(), 1500);
        }, 3000);
    }
    </script>
</body>
</html>