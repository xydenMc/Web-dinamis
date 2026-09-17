<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Toko Online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Rounded" rel="stylesheet">

    <style>
        :root { --primary: #9f3c16; }
        body { background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%); font-family: 'Plus Jakarta Sans', sans-serif; min-height: 100vh; display: flex; align-items: center; }
        .login-card { border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="login-card">
                    <div class="card-header bg-success text-white text-center py-4">
                        <h4 class="mb-0 fw-bold">Selamat Datang</h4>
                        <small class="opacity-75">Silakan login untuk melanjutkan</small>
                    </div>
                    <div class="card-body p-4">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger py-2" role="alert">
                                <?= esc($error) ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('/auth/login/process') ?>" method="POST" id="loginForm">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">email</span></span>
                                    <input type="email" class="form-control" id="email" name="email"
                                           placeholder="nama@email.com" required autocomplete="email">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">lock</span></span>
                                    <input type="password" class="form-control" id="password" name="password"
                                           placeholder="Masukkan password" required autocomplete="current-password">
                                </div>
                            </div>

                            <div class="row justify-content-between align-items-center mb-4">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember" value="1">
                                    <label class="form-check-label" for="remember">
                                        Ingat saya
                                    </label>
                                </div>
                                <a href="<?= base_url('/auth/forgot-password') ?>" class="small text-decoration-none">Lupa password?</a>
                            </div>

                            <button type="submit" class="btn btn-success w-100 py-2">
                                <span class="material-symbols-outlined">login</span>
                                <span class="ms-2">Masuk Sekarang</span>
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="text-muted small">
                                Tidak punya akun? <a href="<?= base_url('/register') ?>" class="text-decoration-none text-success fw-medium">Daftar sekarang</a>
                            </p>
                            <p class="text-muted small mb-0">Atau login dengan</p>
                            <div class="d-flex justify-content-center gap-3 mt-2">
                                <button class="btn btn-outline-danger" onclick="loginWithGoogle()">
                                    <span class="material-symbols-outlined">google</span>
                                </button>
                                <button class="btn btn-outline-primary" onclick="loginWithFacebook()">
                                    <span class="material-symbols-outlined">facebook</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function loginWithGoogle() {
        alert('Fitur Google Login akan segera tersedia');
    }

    function loginWithFacebook() {
        alert('Fitur Facebook Login akan segera tersedia');
    }

    document.getElementById('loginForm')?.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Memproses...';
            submitBtn.disabled = true;
        }
    });
    </script>
</body>
</html>