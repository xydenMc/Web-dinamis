<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public auth routes
$routes->get('/login', 'Login::index');
$routes->post('/login/process', 'Login::process');
$routes->get('/register', 'Register::index');
$routes->post('/register/process', 'Register::process');
$routes->get('/logout', 'Login::logout');

// Default route - redirect based on login status handled by controller
$routes->get('/', 'Login::index');

// Protected routes - require login
$routes->get('/katalog', 'Toko::index', ['filter' => 'checkSession']);

// Category routes
$routes->get('/kategori/(:segment)', 'Toko::category/$1', ['filter' => 'checkSession']);
$routes->get('/search', 'Toko::search', ['filter' => 'checkSession']);

// Cart routes - protected
$routes->post('/cart/add', 'Toko::addToCart', ['filter' => 'checkSession']);
$routes->post('/api/cart/add', 'Toko::addToCart', ['filter' => 'checkSession']);
$routes->get('/cart', 'Toko::getCart', ['filter' => 'checkSession']);
$routes->post('/cart/update', 'Toko::updateCart', ['filter' => 'checkSession']);
$routes->post('/cart/remove', 'Toko::removeFromCart', ['filter' => 'checkSession']);
$routes->post('/cart/clear', 'Toko::clearCart', ['filter' => 'checkSession']);

// Checkout routes - protected
$routes->get('/checkout', 'Toko::checkout', ['filter' => 'checkSession']);
$routes->post('/checkout/process', 'Toko::processCheckout', ['filter' => 'checkSession']);

// Product detail - protected
$routes->get('/produk/(:num)', 'Toko::detail/$1', ['filter' => 'checkSession']);

// Admin dashboard (hanya untuk admin)
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'checkSession:admin']);

// Reports - admin
$routes->get('/laporan', 'AdminLaporan::index', ['filter' => 'checkSession:admin']);

// Transaction management - admin
$routes->group('', ['filter' => 'checkSession:admin'], function ($routes) {
    $routes->get('/transaksi', 'AdminTransaksi::index');
    $routes->get('/transaksi/(:num)', 'AdminTransaksi::detail/$1');
    $routes->post('/transaksi/update-status/(:num)', 'AdminTransaksi::updateStatus/$1');
});

// Protected admin/CRUD routes - require login AND admin role
$routes->group('', ['filter' => 'checkSession:admin'], function ($routes) {
    // Produk CRUD
    $routes->post('/tambah-produk', 'Toko::tambah');
    $routes->post('/edit-produk/(:num)', 'Toko::edit/$1');
    $routes->post('/hapus-produk/(:num)', 'Toko::hapus/$1');

    // Category CRUD
    $routes->post('/tambah-kategori', 'AdminKategori::tambah');
    $routes->post('/edit-kategori/(:num)', 'AdminKategori::edit/$1');
    $routes->post('/hapus-kategori/(:num)', 'AdminKategori::hapus/$1');
});

// Public API
$routes->get('/api/produk', 'Toko::apiProduk');
$routes->get('/api/produk/(:num)', 'Toko::apiProdukById/$1');
$routes->get('/api/kategori', 'Toko::apiKategori');
$routes->get('/api/search', 'Toko::apiSearch');