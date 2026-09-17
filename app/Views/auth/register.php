<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Toko Online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Rounded" rel="stylesheet">

    <style>
        :root { --primary: #9f3c16; }
        body { background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%); font-family: 'Plus Jakarta Sans', sans-serif; min-height: 100vh; display: flex; align-items: center; }
        .register-card { border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="register-card">
                    <div class="card-header bg-success text-white text-center py-4">
                        <h4 class="mb-0 fw-bold">Buat Akun Baru</h4>
                        <small class="opacity-75">Daftar dan mulai belanja sekarang</small>
                    </div>
                    <div class="card-body p-4">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger py-2" role="alert">
                                <?= esc($error) ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('/auth/register/process') ?>" method="POST" id="registerForm">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">person</span></span>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                           placeholder="Nama Anda lengkap" required autocomplete="name">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">email</span></span>
                                    <input type="email" class="form-control" id="email" name="email"
                                           placeholder="nama@email.com" required autocomplete="email">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">lock</span></span>
                                    <input type="password" class="form-control" id="password" name="password"
                                           placeholder="Minimally 8 karakter" required minlength="8" autocomplete="new-password">
                                </div>
                                <small class="text-muted mt-1 d-block">Minimal 8 karakter</small>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirm" class="form-label">Konfirmasi Password *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">lock_clock</span></span>
                                    <input type="password" class="form-control" id="password_confirm" name="password_confirm"
                                           placeholder="Ulangi password" required minlength="8" autocomplete="new-password">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="telepon" class="form-label">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">phone</span></span>
                                    <input type="tel" class="form-control" id="telepon" name="telepon"
                                           placeholder="08xxxxxxxxxx" autocomplete="tel">
                                </div>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    Saya menyetujui <a href="#" class="text-decoration-none">Syarat &amp; Ketentuan</a>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-success w-100 py-2 mb-3">
                                <span class="material-symbols-outlined">person_add</span>
                                <span class="ms-2">Daftar Sekarang</span>
                            </button>
                        </form>

                        <div class="text-center">
                            <p class="text-muted small">Sudah punya akun? <a href="<?= base_url('/login') ?>" class="text-decoration-none text-success fw-medium">Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('registerForm')?.addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirm').value;

        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Password tidak cocok!');
            return false;
        }

        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Mendaftar...';
            submitBtn.disabled = true;
        }
    });
    </script>
</body>
</html>