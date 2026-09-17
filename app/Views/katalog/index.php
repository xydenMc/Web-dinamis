<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - Toko Online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Rounded" rel="stylesheet">

    <style>
        :root {
            --primary: #9f3c16;
            --secondary: #6c757d;
            --success: #198754;
        }
        body {
            background-color: #f5f5f5;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        .navbar {
            background-color: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .product-card:hover {
            transform: translateY(-2px);
            transition: transform 0.2s;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>">
                <span class="text-primary">TOKO</span> ONLINE
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= (isset($current_route) && $current_route == 'katalog/index') ? 'active' : '' ?>" href="<?= base_url('/katalog') ?>">
                            Beranda
                        </a>
                    </li>
                    <?php if (isset($kategoris) && count($kategoris) > 0): ?>
                        <?php foreach ($kategoris as $kategori): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= (($selectedCategory ?? '') === $kategori['slug']) ? 'active' : '' ?>"
                                   href="<?= base_url('kategori/' . $kategori['slug']) ?>">
                                    <?= esc($kategori['nama']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <div class="d-flex gap-2 align-items-center">
                    <a href="<?= base_url('/keranjang') ?>" class="btn btn-outline-primary">
                        <span class="material-symbols-outlined">shopping_cart</span>
                        <span class="ms-1">Keranjang</span>
                        <?php if (isset($cart_count) && $cart_count > 0): ?>
                            <span class="badge bg-primary rounded-pill"><?= $cart_count ?></span>
                        <?php endif; ?>
                    </a>
                    <?php if (isset($is_logged_in) && $is_logged_in): ?>
                        <a href="<?= base_url('/admin/dashboard') ?>" class="btn btn-outline-secondary">
                            <span class="material-symbols-outlined">admin_panel_settings</span>
                            <span class="ms-1">Admin</span>
                        </a>
                        <a href="<?= base_url('/auth/logout') ?>" class="btn btn-outline-danger">
                            <span class="material-symbols-outlined">logout</span>
                        </a>
                    <?php else: ?>
                        <a href="<?= base_url('/login') ?>" class="btn btn-outline-primary">
                            <span class="material-symbols-outlined">login</span>
                            <span class="ms-1">Masuk</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-primary text-white py-5 mb-4">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">Selamat Datang di Toko Online</h1>
            <p class="lead mb-4">Temukan produk berkualitas dengan harga terbaik</p>
            <form class="row g-3 justify-content-center" style="max-width: 600px;">
                <div class="col-12">
                    <input type="text" class="form-control" placeholder="Cari produk..." id="search-input"
                           value="<?= esc($searchQuery ?? '') ?>">
                </div>
                <div class="col-12 col-md-auto">
                    <button type="button" class="btn btn-success w-100 w-md-auto" onclick="searchProducts()">
                        <span class="material-symbols-outlined">search</span>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="mb-5">
        <div class="container">
            <h2 class="fw-bold mb-4"><?= esc($selectedCategoryName ?: 'Semua Produk') ?></h2>
            <div class="row g-4">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100 border-0 shadow-sm product-card" data-product-id="<?= esc($product['id']) ?>">
                                <div class="position-relative">
                                    <img src="<?= !empty($product['image']) ? base_url('uploads/products/' . $product['image']) : base_url('assets/images/placeholder.png') ?>"
                                         class="card-img-top" alt="<?= esc($product['nama']) ?>" style="height: 200px; object-fit: cover;">
                                    <?php if ($product['harga'] > 0): ?>
                                        <span class="position-absolute top-0 start-0 badge bg-primary m-2">
                                            Rp <?= number_format($product['harga'], 0, ',', '.') ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title mb-2"><?= esc($product['nama']) ?></h6>
                                    <p class="card-text text-muted small mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        <?= esc($product['deskripsi'] ?? '') ?>
                                    </p>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <button class="btn btn-outline-primary btn-sm" onclick="showDetailModal(<?= esc($product['id']) ?>)">
                                            <span class="material-symbols-outlined">visibility</span>
                                        </button>
                                        <button class="btn btn-outline-primary btn-sm" onclick="addToCart(<?= esc($product['id']) ?>)">
                                            <span class="material-symbols-outlined">shopping_cart</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <i class="material-symbols-outlined text-muted" style="font-size: 64px;">shopping_basket</i>
                        <h5 class="mt-3 text-muted">Tidak ada produk yang tersedia</h5>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Videos Section -->
    <?php if (!empty($videos)): ?>
    <section class="mb-5 bg-white">
        <div class="container">
            <h2 class="fw-bold mb-4">Video Produk</h2>
            <div class="row g-4">
                <?php foreach ($videos as $video): ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="position-relative">
                                <iframe src="<?= esc('https://www.youtube.com/embed/' . $video['youtube_id']) ?>"
                                        class="card-img-top"
                                        style="height: 200px; width: 100%;"
                                        allowfullscreen></iframe>
                                <span class="position-absolute top-0 start-0 badge bg-dark m-2"><?= esc($video['judul']) ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Pagination -->
    <?php if (($totalPages ?? 0) > 1): ?>
    <section class="mb-5">
        <div class="container">
            <nav aria-label="Pagination">
                <ul class="pagination justify-content-center">
                    <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= $paginationBaseUrl . '/' . ($currentPage - 1) ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                            <a class="page-link" href="<?= $paginationBaseUrl . '/' . $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= $paginationBaseUrl . '/' . ($currentPage + 1) ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </section>
    <?php endif; ?>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <h5 class="fw-bold mb-3">TOKO ONLINE</h5>
                    <p class="small">© 2024 Semua hak dilindungi. Melayani pembelian produk berkualitas dengan cepat dan ramah.</p>
                </div>
                <div class="col-12 col-md-6">
                    <div class="row">
                        <div class="col-6">
                            <h6 class="fw-bold">Layanan</h6>
                            <ul class="list-unstyled small">
                                <li><a href="#" class="text-decoration-none text-white">Pengiriman</a></li>
                                <li><a href="#" class="text-decoration-none text-white">Pendanaan</a></li>
                                <li><a href="#" class="text-decoration-none text-white">Ongkos Kirim</a></li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <h6 class="fw-bold">Tentang</h6>
                            <ul class="list-unstyled small">
                                <li><a href="#" class="text-decoration-none text-white">Tentang Kami</a></li>
                                <li><a href="#" class="text-decoration-none text-white">Syarat &amp; Ketentuan</a></li>
                                <li><a href="#" class="text-decoration-none text-white">Kebijakan Privasi</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function addToCart(productId) {
        fetch('<?= base_url('/api/cart/add') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                qty: 1,
                _csrf_token: '<?= csrf_hash() ?>'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Produk ditambahkan ke keranjang', 'success');
                location.reload();
            } else {
                showToast(data.message || 'Gagal menambahkan keranjang', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan', 'danger');
        });
    }

    function showDetailModal(productId) {
        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        document.getElementById('modalContent').innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>';
        modal.show();

        fetch('<?= base_url('/api/product/') ?>' + productId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let html = '<div class="row">';
                    html += '<div class="col-md-5"><img src="' + (data.product.image ? '<?= base_url('uploads/products/') ?>' + data.product.image : '<?= base_url('assets/images/placeholder.png') ?>') + '" class="img-fluid rounded"></div>';
                    html += '<div class="col-md-7"><h3>' + data.product.nama + '</h3>';
                    html += '<p class="text-muted">Rp ' + parseFloat(data.product.harga).toLocaleString('id-ID') + '</p>';
                    html += '<p>' + data.product.deskripsi + '</p>';
                    html += '<div class="d-flex gap-2 mt-3">';
                    html += '<input type="number" class="form-control w-25" id="qtyDetail" value="1" min="1" max="' + data.product.stok + '">';
                    html += '<button class="btn btn-primary" onclick="addToCartFromDetail(' + data.product.id + ')"><span class="material-symbols-outlined">shopping_cart</span></button>';
                    html += '</div></div></div>';
                    document.getElementById('modalContent').innerHTML = html;
                }
            })
            .catch(error => {
                document.getElementById('modalContent').innerHTML = '<p class="text-danger">Gagal memuat detail produk</p>';
            });
    }

    function addToCartFromDetail(productId) {
        const qty = document.getElementById('qtyDetail').value;
        fetch('<?= base_url('/api/cart/add') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                qty: parseInt(qty),
                _csrf_token: '<?= csrf_hash() ?>'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('detailModal'));
                modal.hide();
                showToast('Produk ditambahkan ke keranjang', 'success');
                location.reload();
            }
        });
    }

    function searchProducts() {
        const query = document.getElementById('search-input').value;
        if (query) {
            window.location.href = '<?= base_url('/katalog?search=') ?>' + encodeURIComponent(query);
        }
    }

    function showToast(message, type) {
        const toast = document.createElement('div');
        toast.className = 'alert alert-' + type + ' alert-dismissible fade show position-fixed top-0 end-0 m-3';
        toast.style.zIndex = '1050';
        toast.setAttribute('role', 'alert');
        toast.innerHTML = message + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        document.body.appendChild(toast);

        setTimeout(function() {
            toast.classList.add('fade');
            setTimeout(function() { toast.remove(); }, 1500);
        }, 3000);
    }
    </script>

    <!-- Product Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
