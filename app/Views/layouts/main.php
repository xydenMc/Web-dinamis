<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->extend('layouts/meta') ? $this->section('title') : 'Toko Online' ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Rounded" rel="material-icons">

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
    </style>
</head>
<body>
    <?= $this->renderSection('content') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>