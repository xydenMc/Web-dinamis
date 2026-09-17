<!-- Product Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="detailModalLabel">Detail Produk</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalBodyContent" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
function showProductDetail(productId) {
    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    modal.show();

    fetch('<?= base_url('/api/product/') ?>' + productId, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(function(data) {
        let html = '';

        if (data.success) {
            const product = data.product;
            html += '<div class="row">';
            html += '<div class="col-md-5">';
            html += '<div class="text-center mb-3">';
            html += '<img src="' + (product.image ? '<?= base_url('uploads/products/') ?>' + product.image : '<?= base_url('assets/images/placeholder.png') ?>') + '" ' +
                    'class="img-fluid rounded border" style="max-height: 300px; object-fit: cover;">';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-md-7">';
            html += '<h5 class="fw-bold mb-2">' + (product.nama || 'Produk tidak tersedia') + '</h5>';
            html += '<p class="text-muted mb-2">SKU: #' + (product.id || '000') + '</p>';

            if (product.harga && parseFloat(product.harga) > 0) {
                html += '<p class="h5 text-primary mb-3">Rp ' + parseFloat(product.harga).toLocaleString('id-ID') + '</p>';
            }

            if (product.stok !== undefined) {
                const stockClass = parseInt(product.stok) > 0 ? 'text-success' : 'text-danger';
                const stockText = parseInt(product.stok) > 0 ? 'Stok tersedia: ' + product.stok + ' pcs' : 'Stok habis';
                html += '<p class="text-muted small mb-2"><span class="' + stockClass + '">' + stockText + '</span></p>';
            }

            if (product.deskripsi) {
                html += '<p class="mb-3">' + product.deskripsi + '</p>';
            }

            html += '<div class="d-flex align-items-center gap-2 mb-3">';
            html += '<label class="form-label mb-0">Qty:</label>';
            html += '<input type="number" id="modalQty" class="form-control" value="1" min="1" ' +
                    (product.stok ? 'max="' + product.stok + '"' : '') + ' style="width: 80px;">';
            html += '</div>';

            html += '<div class="d-flex gap-2">';
            html += '<button class="btn btn-primary flex-grow-1" onclick="addToCartFromModal(' + product.id + ')" ' +
                    (product.stok && parseInt(product.stok) > 0 ? '' : 'disabled') + '>';
            html += '<span class="material-symbols-outlined">shopping_cart</span> Tambah ke Keranjang';
            html += '</button>';
            html += '<button class="btn btn-outline-success flex-grow-1" onclick="buyNow(' + product.id + ')" ' +
                    (product.stok && parseInt(product.stok) > 0 ? '' : 'disabled') + '>';
            html += '<span class="material-symbols-outlined">shopping_cart_checkout</span> Beli';
            html += '</button>';
            html += '</div>';
            html += '</div></div>';
        } else {
            html += '<div class="text-center py-4">';
            html += '<i class="material-symbols-outlined text-muted" style="font-size: 48px;">error</i>';
            html += '<p class="mt-2 text-muted">' + (data.message || 'Produk tidak ditemukan') + '</p>';
            html += '</div>';
        }

        document.getElementById('modalBodyContent').innerHTML = html;
    })
    .catch(function(error) {
        console.error('Error:', error);
        document.getElementById('modalBodyContent').innerHTML =
            '<div class="text-center py-4"><p class="text-danger">Gagal memuat detail produk</p></div>';
    });
}

function addToCartFromModal(productId) {
    const qty = document.getElementById('modalQty').value;

    fetch('<?= base_url('/api/cart/add') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            product_id: productId,
            qty: parseInt(qty) || 1,
            _csrf_token: '<?= csrf_hash() ?>'
        })
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        if (data.success) {
            showToast('Produk ditambahkan ke keranjang', 'success');
            // Update cart count
            const cartBadge = document.querySelector('.cart-count');
            if (cartBadge) {
                const count = parseInt(cartBadge.textContent) + (parseInt(qty) || 1);
                cartBadge.textContent = count;
                cartBadge.classList.remove('d-none');
            }
        } else {
            showToast(data.message || 'Gagal menambahkan ke keranjang', 'danger');
        }
    })
    .catch(function(error) {
        console.error('Error:', error);
        showToast('Terjadi kesalahan. Silakan coba lagi.', 'danger');
    });
}

function buyNow(productId) {
    window.location.href = '<?= base_url('/checkout') ?>';
}

function showToast(message, type) {
    // Remove existing toast
    const existingToast = document.querySelector('.toast-show');
    if (existingToast) existingToast.remove();

    const toast = document.createElement('div');
    toast.className = 'toast align-items-center text-white border-0 position-fixed bottom-0 end-0 m-3 ' +
                      (type === 'success' ? 'bg-success' : 'bg-danger') + ' toast-show';
    toast.style.zIndex = '1055';
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    toast.innerHTML = '<div class="d-flex">';
    toast.innerHTML += '<div class="toast-body">' + message + '</div>';
    toast.innerHTML += '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>';
    toast.innerHTML += '</div>';

    document.body.appendChild(toast);

    const bsToast = new bootstrap.Toast(toast, { delay: 3000 });
    bsToast.show();
}
</script>