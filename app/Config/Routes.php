<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ============================================================================
// AUTHENTICATION ROUTES
// ============================================================================

// Public auth routes
$routes->get('/login', 'Auth::index');
$routes->post('/login/process', 'Auth::process');
$routes->get('/register', 'Auth::register');
$routes->post('/register/process', 'Auth::registerProcess');
$routes->get('/logout', 'Auth::logout');
$routes->get('/login-redirect', 'Auth::showLoginModal');

// ============================================================================
// PUBLIC ROUTES (Bisa diakses tanpa login)
// ============================================================================

// Storefront built in TokoController. Both / and /katalog use this UI.
$routes->get('/', 'Toko::index');
$routes->get('/katalog', 'Toko::index');
$routes->get('/kategori', 'Toko::category');
$routes->get('/kategori/(:segment)', 'Toko::category/$1');
$routes->get('/search', 'Toko::search');
$routes->get('/produk/(:num)', 'Toko::detail/$1');
$routes->post('/tambah', 'Toko::tambah', ['filter' => 'role:admin']);

// ============================================================================
// CART ROUTES (LOGIN REQUIRED)
// ============================================================================

// Session cart used by the storefront. The page and JSON API deliberately use
// separate URLs so `/cart` always renders HTML for users.
$routes->get('/cart', 'Toko::cart');
$routes->get('/api/cart', 'Toko::getCart');
$routes->post('/cart/add', 'Toko::addToCart');
$routes->post('/cart/update', 'Toko::updateCart');
$routes->post('/cart/remove', 'Toko::removeFromCart');
$routes->post('/cart/clear', 'Toko::clearCart');

// ============================================================================
// CHECKOUT ROUTES (LOGIN REQUIRED)
// ============================================================================

// Checkout performs its own login check before showing or processing the form.
$routes->get('/checkout', 'Toko::checkout');
$routes->post('/checkout/process', 'Toko::processCheckout');
$routes->get('/pesanan/sukses', 'Toko::orderSuccess');
$routes->get('/pesanan/struk/pdf', 'Toko::downloadReceiptPdf');

// ============================================================================
// ADMIN ROUTES
// ============================================================================

// Admin login route
$routes->get('/admin/login', 'Admin\Auth::showLogin');
$routes->post('/admin/login/process', 'Admin\Auth::login');
$routes->get('/admin/logout', 'Admin\Auth::logout');

// Admin dashboard - require admin role
$routes->get('/dashboard', 'Admin\Dashboard::index', ['filter' => 'role:admin']);
$routes->get('/admin/kelola-produk', 'Admin\StoreProducts::index', ['filter' => 'role:admin']);
$routes->post('/admin/kelola-produk/tambah', 'Toko::tambah', ['filter' => 'role:admin']);
$routes->post('/admin/kelola-produk/edit/(:num)', 'Admin\StoreProducts::update/$1', ['filter' => 'role:admin']);
$routes->post('/admin/kelola-produk/hapus/(:num)', 'Admin\StoreProducts::delete/$1', ['filter' => 'role:admin']);

// Admin transactions
// Checkout storefront writes to the legacy `transaksi` / `detail_transaksi`
// tables, so the admin page must use the matching controller and schema.
$routes->get('/admin/transaksi', 'AdminTransaksi::index', ['filter' => 'role:admin']);
$routes->get('/admin/transaksi/(:num)', 'AdminTransaksi::detail/$1', ['filter' => 'role:admin']);
$routes->post('/admin/transaksi/update-status/(:num)', 'AdminTransaksi::updateStatus/$1', ['filter' => 'role:admin']);

// Backward-compatible URLs used by older transaction views.
$routes->get('/transaksi', 'AdminTransaksi::index', ['filter' => 'role:admin']);
$routes->get('/transaksi/(:num)', 'AdminTransaksi::detail/$1', ['filter' => 'role:admin']);
$routes->post('/transaksi/update-status/(:num)', 'AdminTransaksi::updateStatus/$1', ['filter' => 'role:admin']);

// Admin reports
$routes->get('/admin/laporan', 'Admin\Report::index', ['filter' => 'role:admin']);
$routes->get('/admin/laporan/struk/(:num)', 'Admin\Report::receipt/$1', ['filter' => 'role:admin']);
$routes->get('/admin/laporan/export', 'Admin\Report::exportCsv', ['filter' => 'role:admin']);
$routes->get('/admin/laporan/export-pdf', 'Admin\Report::exportPdf', ['filter' => 'role:admin']);

// Admin CRUD - Products
$routes->post('/admin/produk', 'Admin\Product::create', ['filter' => 'role:admin']);
$routes->get('/admin/produk', 'Admin\Product::index', ['filter' => 'role:admin']);
$routes->get('/admin/produk/create', 'Admin\Product::createPage', ['filter' => 'role:admin']);
$routes->get('/admin/produk/(:num)', 'Admin\Product::edit/$1', ['filter' => 'role:admin']);
$routes->put('/admin/produk/(:num)', 'Admin\Product::update/$1', ['filter' => 'role:admin']);
$routes->delete('/admin/produk/(:num)', 'Admin\Product::delete/$1', ['filter' => 'role:admin']);

// Admin CRUD - Categories
$routes->post('/admin/kategori', 'Admin\Category::create', ['filter' => 'role:admin']);
$routes->get('/admin/kategori', 'Admin\Category::index', ['filter' => 'role:admin']);
$routes->get('/admin/kategori/create', 'Admin\Category::createPage', ['filter' => 'role:admin']);
$routes->get('/admin/kategori/(:num)', 'Admin\Category::edit/$1', ['filter' => 'role:admin']);
$routes->put('/admin/kategori/(:num)', 'Admin\Category::update/$1', ['filter' => 'role:admin']);
$routes->delete('/admin/kategori/(:num)', 'Admin\Category::delete/$1', ['filter' => 'role:admin']);

// Admin CRUD - Videos
$routes->post('/admin/video', 'Admin\Video::create', ['filter' => 'role:admin']);
$routes->get('/admin/video', 'Admin\Video::index', ['filter' => 'role:admin']);
$routes->get('/admin/video/create', 'Admin\Video::createPage', ['filter' => 'role:admin']);
$routes->get('/admin/video/(:num)', 'Admin\Video::edit/$1', ['filter' => 'role:admin']);
$routes->put('/admin/video/(:num)', 'Admin\Video::update/$1', ['filter' => 'role:admin']);
$routes->delete('/admin/video/(:num)', 'Admin\Video::delete/$1', ['filter' => 'role:admin']);

// ============================================================================
// PUBLIC API
// ============================================================================

$routes->get('/api/produk', 'Toko::apiProduk');
$routes->get('/api/produk/(:num)', 'Toko::apiProdukById/$1');
$routes->get('/api/kategori', 'Toko::apiKategori');
$routes->get('/api/search', 'Toko::apiSearch');
