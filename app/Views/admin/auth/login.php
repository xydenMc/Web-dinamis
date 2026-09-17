<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Toko Online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Rounded" rel="stylesheet">

    <style>
        :root { --primary: #9f3c16; }
        body { background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%); font-family: 'Plus Jakarta Sans', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="login-card">
                    <div class="card-header bg-dark text-white text-center py-4">
                        <h4 class="mb-0 fw-bold">Admin Login</h4>
                    </div>
                    <div class="card-body p-4">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger py-2"><?= esc($error) ?></div>
                        <?php endif; ?>

                        <form action="<?= base_url('/admin/login/process') ?>" method="POST" id="loginForm">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">email</span></span>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="nama@email.com" required autocomplete="email">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><span class="material-symbols-outlined">lock</span></span>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required autocomplete="current-password">
                                </div>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1">
                                <label class="form-check-label" for="remember">Ingat saya</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <span class="material-symbols-outlined">login</span>
                                <span class="ms-2">Masuk</span>
                            </button>
                        </form>

                        <div class="text-center mt-3">
                            <a href="<?= base_url('/') ?>" class="text-decoration-none text-muted">
                                <span class="material-symbols-outlined">arrow_back</span>
                                <span class="ms-1">Kembali ke Website</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
