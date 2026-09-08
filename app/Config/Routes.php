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

// Protected admin/CRUD routes - require login AND admin role
$routes->group('', ['filter' => 'checkSession:admin'], function ($routes) {
    $routes->post('/tambah-produk', 'Toko::tambah');
    $routes->post('/edit-produk/(:num)', 'Toko::edit/$1');
    $routes->post('/hapus-produk/(:num)', 'Toko::hapus/$1');
});

// Admin dashboard (hanya untuk admin)
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'checkSession:admin']);

// Public API
$routes->get('/api/produk', 'Toko::apiProduk');
$routes->get('/api/produk/(:num)', 'Toko::apiProdukById/$1');