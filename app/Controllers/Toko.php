<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\KategoriModel;
use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;

class Toko extends BaseController
{
    protected $produkModel;
    protected $kategoriModel;
    protected $transaksiModel;
    protected $detailTransaksiModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        $this->kategoriModel = new KategoriModel();
        $this->transaksiModel = new TransaksiModel();
        $this->detailTransaksiModel = new DetailTransaksiModel();
    }

    // ==========================================
    // KATALOG / BERANDA - Public Route
    // ==========================================
    public function index()
    {
        $data['user'] = session()->get('logged_in') ? session()->get('username') : null;
        $data['role'] = session()->get('role');
        $data['title'] = 'Griya Pot Bunga - Toko Pot dan Tanaman Hias';

        // Ambil kategori untuk filter
        $data['kategoris'] = $this->kategoriModel->getKategoriAktif();

        // Ambil produk terbaru/aktif
        $data['produks'] = $this->produkModel->getProdukAktif();

        return view('toko_view', $data);
    }

    // ==========================================
    // API ENDPOINTS
    // ==========================================
    public function apiProduk()
    {
        $search = $this->request->getGet('search') ?? '';
        $kategori = $this->request->getGet('kategori') ?? '';

        $builder = $this->produkModel->builder();

        if (!empty($search)) {
            $builder->like('nama_produk', $search)
                    ->orLike('deskripsi', $search);
        }

        if (!empty($kategori)) {
            $builder->where('kategori', $kategori);
        }

        $produks = $builder->where('status', 'aktif')
                          ->orderBy('created_at', 'DESC')
                          ->findAll();

        return $this->response->setJSON($produks);
    }

    public function apiProdukById($id = null)
    {
        if ($id === null) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ID tidak diberikan']);
        }

        $produk = $this->produkModel->find($id);

        if ($produk) {
            $produk['gambar_url'] = $this->getImageUrl($produk['gambar']);
            return $this->response->setJSON($produk);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Produk tidak ditemukan']);
    }

    public function apiKategori()
    {
        $kategoris = $this->kategoriModel->getKategoriAktif();
        return $this->response->setJSON($kategoris);
    }

    public function apiSearch()
    {
        $query = $this->request->getGet('q') ?? '';

        if (empty($query)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Query tidak diberikan']);
        }

        $builder = $this->produkModel->builder();
        $builder->like('nama_produk', $query)
                ->orLike('deskripsi', $query)
                ->orLike('kategori', $query)
                ->where('status', 'aktif')
                ->orderBy('created_at', 'DESC');

        $results = $builder->findAll(20);

        return $this->response->setJSON($results);
    }

    // ==========================================
    // GET IMAGE URL HELPER
    // ==========================================
    public function getImageUrl($gambar)
    {
        if (empty($gambar)) {
            return 'https://via.placeholder.com/400x400/f5f5f5/cccccc?text=Produk';
        }

        if (filter_var($gambar, FILTER_VALIDATE_URL)) {
            return $gambar;
        }

        // If relative path, prepend base URL
        return base_url('uploads/' . $gambar);
    }

    // ==========================================
    // CRUD PRODUK - Admin Routes
    // ==========================================
    public function tambah()
    {
        if ($this->request->getMethod() === 'POST') {
            $validation = $this->validate([
                'nama_produk' => [
                    'rules'  => 'required|min_length[3]|max_length[255]',
                    'errors' => [
                        'required' => 'Nama produk wajib diisi.',
                        'min_length' => 'Nama produk minimal 3 karakter.',
                        'max_length' => 'Nama produk maksimal 255 karakter.'
                    ]
                ],
                'harga' => [
                    'rules'  => 'required|numeric|greater_than_equal_to[0]',
                    'errors' => [
                        'required' => 'Harga wajib diisi.',
                        'numeric' => 'Harga harus berupa angka.',
                        'greater_than_equal_to' => 'Harga tidak boleh negatif.'
                    ]
                ],
                'stok' => [
                    'rules'  => 'required|numeric|greater_than_equal_to[0]',
                    'errors' => [
                        'required' => 'Stok wajib diisi.',
                        'numeric' => 'Stok harus berupa angka.',
                        'greater_than_equal_to' => 'Stok tidak boleh negatif.'
                    ]
                ]
            ]);

            if ($validation) {
                $data = [
                    'nama_produk' => $this->request->getPost('nama_produk'),
                    'deskripsi'   => $this->request->getPost('deskripsi'),
                    'kategori'    => $this->request->getPost('kategori'),
                    'harga'       => (int) $this->request->getPost('harga'),
                    'stok'        => (int) $this->request->getPost('stok'),
                    'status'      => $this->request->getPost('status') ?? 'aktif',
                    'gambar'      => $this->request->getPost('gambar')
                ];

                $this->produkModel->insert($data);

                return $this->redirectWithFlash('/katalog', 'success', 'Produk berhasil ditambahkan.');
            } else {
                return redirect()->to('/katalog')->with('errors', $this->validator->getErrors());
            }
        }

        return redirect()->to('/katalog');
    }

    public function hapus($id = null)
    {
        if ($id === null) {
            return redirect()->to('/katalog');
        }

        $produk = $this->produkModel->find($id);

        if ($produk) {
            $this->produkModel->delete($id);
            return $this->redirectWithFlash('/katalog', 'success', 'Produk berhasil dihapus.');
        }

        return $this->redirectWithFlash('/katalog', 'error', 'Produk tidak ditemukan.');
    }

    public function edit($id = null)
    {
        if ($id === null) {
            return redirect()->to('/katalog');
        }

        $produk = $this->produkModel->find($id);

        if ($produk) {
            if ($this->request->getMethod() === 'POST') {
                $validation = $this->validate([
                    'nama_produk' => [
                        'rules'  => 'required|min_length[3]|max_length[255]',
                        'errors' => [
                            'required' => 'Nama produk wajib diisi.',
                            'min_length' => 'Nama produk minimal 3 karakter.',
                            'max_length' => 'Nama produk maksimal 255 karakter.'
                        ]
                    ],
                    'harga' => [
                        'rules'  => 'required|numeric|greater_than_equal_to[0]',
                        'errors' => [
                            'required' => 'Harga wajib diisi.',
                            'numeric' => 'Harga harus berupa angka.',
                            'greater_than_equal_to' => 'Harga tidak boleh negatif.'
                        ]
                    ],
                    'stok' => [
                        'rules'  => 'required|numeric|greater_than_equal_to[0]',
                        'errors' => [
                            'required' => 'Stok wajib diisi.',
                            'numeric' => 'Stok harus berupa angka.',
                            'greater_than_equal_to' => 'Stok tidak boleh negatif.'
                        ]
                    ]
                ]);

                if ($validation) {
                    $data = [
                        'nama_produk' => $this->request->getPost('nama_produk'),
                        'deskripsi'   => $this->request->getPost('deskripsi'),
                        'kategori'    => $this->request->getPost('kategori'),
                        'harga'       => (int) $this->request->getPost('harga'),
                        'stok'        => (int) $this->request->getPost('stok'),
                        'status'      => $this->request->getPost('status') ?? 'aktif',
                        'gambar'      => $this->request->getPost('gambar')
                    ];

                    $this->produkModel->update($id, $data);

                    return $this->redirectWithFlash('/katalog', 'success', 'Produk berhasil diperbarui.');
                } else {
                    return redirect()->to('/katalog')->with('errors', $this->validator->getErrors());
                }
            }

            $data['produk'] = $produk;
            $data['title'] = 'Edit Produk - Griya Pot Bunga';
            return view('toko_view', $data);
        }

        return $this->redirectWithFlash('/katalog', 'error', 'Produk tidak ditemukan.');
    }

    // ==========================================
    // KERANJANG BELANJA - Session based
    // ==========================================
    public function addToCart()
    {
        if ($this->request->getMethod() !== 'POST') {
            return $this->redirectWithFlash('/katalog', 'error', 'Metode permintaan tidak valid.');
        }

        $productId = $this->request->getPost('id_produk');
        $quantity = (int) ($this->request->getPost('quantity') ?? 1);

        if (!$productId) {
            return $this->redirectWithFlash('/katalog', 'error', 'Produk tidak dipilih.');
        }

        if ($quantity <= 0) {
            return $this->redirectWithFlash('/katalog', 'error', 'Jumlah produk harus lebih dari 0.');
        }

        $produk = $this->produkModel->find($productId);

        if (!$produk || $produk['status'] !== 'aktif') {
            return $this->redirectWithFlash('/katalog', 'error', 'Produk tidak tersedia.');
        }

        // Ambil atau buat keranjang di session
        $cart = session()->get('cart') ?? [];

        // Hitung quantity total yang akan dimasukkan ke keranjang
        $newQuantity = $quantity;
        if (isset($cart[$productId])) {
            $newQuantity = $cart[$productId]['quantity'] + $quantity;
        }

        // Cek stok - quantity baru tidak boleh melebihi stok produk
        if ($newQuantity > $produk['stok']) {
            return $this->redirectWithFlash('/katalog', 'error', 'Stok tidak mencukupi. Stok tersedia: ' . $produk['stok']);
        }

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $newQuantity;
            $cart[$productId]['subtotal'] = $cart[$productId]['harga'] * $newQuantity;
        } else {
            $cart[$productId] = [
                'id_produk' => $productId,
                'nama_produk' => $produk['nama_produk'],
                'harga' => $produk['harga'],
                'stok' => $produk['stok'],
                'gambar' => $produk['gambar'],
                'quantity' => $quantity,
                'subtotal' => $produk['harga'] * $quantity
            ];
        }

        session()->set('cart', $cart);

        return $this->redirectWithFlash('/cart', 'success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function getCart()
    {
        $cart = session()->get('cart') ?? [];
        $cartCount = array_sum(array_column($cart, 'quantity'));
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['subtotal'];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'cart' => $cart,
            'cart_count' => $cartCount,
            'subtotal' => $subtotal
        ]);
    }

    /**
     * Halaman keranjang untuk storefront berbasis session.
     */
    public function cart()
    {
        $cart = session()->get('cart') ?? [];
        $subtotal = array_sum(array_column($cart, 'subtotal'));

        return view('cart_view', [
            'title' => 'Keranjang Belanja - Griya Pot Bunga',
            'cart' => $cart,
            'subtotal' => $subtotal,
            'totalItem' => array_sum(array_column($cart, 'quantity')),
        ]);
    }

    public function updateCart()
    {
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request method']);
        }

        // Dukung input JSON dari JavaScript
        $input = $this->request->getJSON(true) ?? $this->request->getPost();
        $productId = $input['id_produk'] ?? null;
        $quantityPost = $input['quantity'] ?? null;

        if (!$productId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ID produk tidak diberikan']);
        }

        // Validasi quantity - harus berupa angka positif
        if ($quantityPost === null || !is_numeric($quantityPost)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Quantity tidak valid']);
        }
        $quantity = (int) $quantityPost;

        $cart = session()->get('cart') ?? [];

        if (!isset($cart[$productId])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Produk tidak ada di keranjang']);
        }

        // Produk yang dicari untuk cek stok terkini
        $produk = $this->produkModel->find($productId);

        if (!$produk) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Produk tidak ditemukan']);
        }

        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            // Cek stok - quantity tidak boleh melebihi stok produk yang aktual
            if ($quantity > $produk['stok']) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $produk['stok']]);
            }
            $cart[$productId]['quantity'] = $quantity;
            $cart[$productId]['subtotal'] = $produk['harga'] * $quantity;
        }

        session()->set('cart', $cart);

        $cartCount = array_sum(array_column($cart, 'quantity'));
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['subtotal'];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Keranjang berhasil diperbarui',
            'cart' => $cart,
            'cart_count' => $cartCount,
            'subtotal' => $subtotal
        ]);
    }

    public function removeFromCart()
    {
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request method']);
        }

        // Dukung input JSON dari JavaScript
        $input = $this->request->getJSON(true) ?? $this->request->getPost();
        $productId = $input['id_produk'] ?? null;

        if (!$productId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ID produk tidak diberikan']);
        }

        $cart = session()->get('cart') ?? [];

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->set('cart', $cart);
        }

        $cartCount = array_sum(array_column($cart, 'quantity'));
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['subtotal'];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Produk berhasil dihapus dari keranjang',
            'cart' => $cart,
            'cart_count' => $cartCount,
            'subtotal' => $subtotal
        ]);
    }

    public function clearCart()
    {
        session()->set('cart', []);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Keranjang berhasil dikosongkan',
            'cart' => [],
            'cart_count' => 0,
            'subtotal' => 0
        ]);
    }

    // ==========================================
    // DETAIL PROduk - Public Route
    // ==========================================
    public function detail($id = null)
    {
        if ($id === null) {
            return redirect()->to('/katalog');
        }

        $produk = $this->produkModel->find($id);

        if (!$produk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan');
        }

        $data['produk'] = $produk;
        $data['user'] = session()->get('logged_in') ? session()->get('username') : null;
        $data['role'] = session()->get('role');
        $data['title'] = $produk['nama_produk'] . ' - Griya Pot Bunga';

        return view('detail_produk_view', $data);
    }

    // ==========================================
    // CHECKOUT - Protected Route
    // ==========================================
    public function checkout()
    {
        if (!session()->get('logged_in')) {
            return $this->redirectWithFlash('/login', 'error', 'Anda harus login untuk checkout.');
        }

        $cart = session()->get('cart') ?? [];

        if (empty($cart)) {
            return $this->redirectWithFlash('/katalog', 'error', 'Keranjang belanja kosong.');
        }

        $data['cart'] = $cart;
        $data['user'] = session()->get('username');
        $data['role'] = session()->get('role');
        $data['title'] = 'Checkout - Griya Pot Bunga';

        // Hitung subtotal dan total
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['subtotal'];
        }

        $data['subtotal'] = $subtotal;
        $data['total_item'] = array_sum(array_column($cart, 'quantity'));

        return view('checkout_view', $data);
    }

    public function processCheckout()
    {
        if (!session()->get('logged_in')) {
            return $this->redirectWithFlash('/login', 'error', 'Anda harus login untuk checkout.');
        }

        if ($this->request->getMethod() !== 'POST') {
            return redirect()->to('/checkout');
        }

        $validation = $this->validate([
            'nomor_telepon' => [
                'rules'  => 'required|min_length[10]|max_length[20]',
                'errors' => [
                    'required' => 'Nomor telepon wajib diisi.',
                    'min_length' => 'Nomor telepon minimal 10 karakter.',
                    'max_length' => 'Nomor telepon maksimal 20 karakter.'
                ]
            ],
            'alamat_kirim' => [
                'rules'  => 'required|min_length[10]|max_length[500]',
                'errors' => [
                    'required' => 'Alamat kirim wajib diisi.',
                    'min_length' => 'Alamat kirim minimal 10 karakter.',
                    'max_length' => 'Alamat kirim maksimal 500 karakter.'
                ]
            ],
            'metode_pembayaran' => [
                'rules'  => 'required|in_list[Transfer Bank,COD (Bayar di Tempat),QRIS (GoPay/OVO/DANA)]',
                'errors' => [
                    'required' => 'Metode pembayaran wajib dipilih.',
                    'in_list' => 'Metode pembayaran tidak valid.'
                ]
            ]
        ]);

        if (!$validation) {
            return redirect()->to('/checkout')->with('errors', $this->validator->getErrors());
        }

        $cart = session()->get('cart') ?? [];

        if (empty($cart)) {
            return $this->redirectWithFlash('/katalog', 'error', 'Keranjang belanja kosong.');
        }

        // Generate nomor transaksi unik
        $nomorTransaksi = 'TRX-' . date('YmdHis') . '-' . rand(100, 999);

        // Hitung total
        $totalHarga = 0;
        $totalItem = 0;
        foreach ($cart as $item) {
            $totalHarga += $item['subtotal'];
            $totalItem += $item['quantity'];
        }

        // Simpan transaksi
        $transaksiData = [
            'nomor_transaksi' => $nomorTransaksi,
            'id_pelanggan' => session()->get('id'),
            'tanggal' => date('Y-m-d H:i:s'),
            'total_harga' => $totalHarga,
            'total_item' => $totalItem,
            'status' => 'Pending',
            'metode_pembayaran' => $this->request->getPost('metode_pembayaran'),
            'catatan' => $this->request->getPost('catatan') ?? '',
            'alamat_kirim' => $this->request->getPost('alamat_kirim'),
            'nomor_telepon' => $this->request->getPost('nomor_telepon')
        ];

        // Validasi ulang stok dari database agar stok yang berubah setelah
        // produk masuk keranjang tidak menghasilkan pesanan yang tidak valid.
        $currentProducts = [];
        foreach ($cart as $item) {
            $product = $this->produkModel->find($item['id_produk']);
            if (!$product || $product['status'] !== 'aktif' || (int) $product['stok'] < (int) $item['quantity']) {
                return $this->redirectWithFlash('/cart', 'error', 'Salah satu produk sudah tidak tersedia atau stoknya tidak mencukupi.');
            }
            $currentProducts[$item['id_produk']] = $product;
        }

        // Header transaksi, detail, dan pengurangan stok harus tersimpan
        // bersama-sama. Jika salah satunya gagal, semuanya dibatalkan.
        $db = db_connect();
        $db->transBegin();

        try {
            $transaksiId = $this->transaksiModel->insert($transaksiData);
            if (!$transaksiId) {
                throw new \RuntimeException('Header transaksi tidak dapat disimpan.');
            }

            foreach ($cart as $item) {
                $detailData = [
                    'id_transaksi' => $transaksiId,
                    'id_produk' => $item['id_produk'],
                    'jumlah' => $item['quantity'],
                    'harga_satuan' => $item['harga'],
                    'subtotal' => $item['subtotal'],
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                if (!$this->detailTransaksiModel->insert($detailData)) {
                    throw new \RuntimeException('Detail transaksi tidak dapat disimpan.');
                }

                $product = $currentProducts[$item['id_produk']];
                if (!$this->produkModel->update($item['id_produk'], [
                    'stok' => (int) $product['stok'] - (int) $item['quantity'],
                ])) {
                    throw new \RuntimeException('Stok produk tidak dapat diperbarui.');
                }
            }

            $db->transCommit();
        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', 'Checkout gagal: {message}', ['message' => $e->getMessage()]);
            return $this->redirectWithFlash('/checkout', 'error', 'Transaksi gagal diproses. Silakan coba lagi.');
        }

        // Kosongkan keranjang
        session()->set('cart', []);

        session()->setTempdata('last_order_number', $nomorTransaksi, 300);

        return $this->redirectWithFlash('/pesanan/sukses', 'success', 'Pesanan berhasil dibuat.');
    }

    /**
     * Temporary confirmation page shown immediately after a successful order.
     */
    public function orderSuccess()
    {
        $orderNumber = session()->getTempdata('last_order_number');

        if (!is_string($orderNumber) || $orderNumber === '') {
            return $this->redirectWithFlash('/katalog', 'error', 'Data pesanan tidak ditemukan.');
        }

        return view('order_success_view', [
            'title' => 'Pesanan Berhasil - Griya Pot Bunga',
            'orderNumber' => $orderNumber,
        ]);
    }

    // ==========================================
    // API CATEGORY - Public Route
    // ==========================================
    public function category($slug = null)
    {
        $data['user'] = session()->get('logged_in') ? session()->get('username') : null;
        $data['role'] = session()->get('role');
        $data['title'] = 'Kategori - Griya Pot Bunga';

        if ($slug) {
            // Cari produk berdasarkan kategori
            $data['produks'] = $this->produkModel->where('kategori', $slug)
                                                 ->where('status', 'aktif')
                                                 ->orderBy('created_at', 'DESC')
                                                 ->findAll();
            $data['kategori_aktif'] = $slug;

            // Cari nama kategori
            $kategori = $this->kategoriModel->where('nama_kategori', $slug)->first();
            $data['nama_kategori'] = $kategori ? $kategori['nama_kategori'] : $slug;
        } else {
            $data['produks'] = [];
            $data['kategori_aktif'] = null;
            $data['nama_kategori'] = '';
        }

        // Ambil semua kategori untuk filter
        $data['kategoris'] = $this->kategoriModel->getKategoriAktif();

        return view('toko_view', $data);
    }

    // ==========================================
    // SEARCH PRODUK - Public Route
    // ==========================================
    public function search()
    {
        $query = $this->request->getGet('q') ?? '';

        $data['user'] = session()->get('logged_in') ? session()->get('username') : null;
        $data['role'] = session()->get('role');
        $data['title'] = 'Hasil Pencarian - Griya Pot Bunga';

        if (!empty($query)) {
            $data['produks'] = $this->produkModel->builder()
                ->like('nama_produk', $query)
                ->orLike('deskripsi', $query)
                ->orLike('kategori', $query)
                ->where('status', 'aktif')
                ->orderBy('created_at', 'DESC')
                ->findAll();
            $data['search_query'] = $query;
        } else {
            $data['produks'] = [];
            $data['search_query'] = '';
        }

        // Ambil semua kategori untuk filter
        $data['kategoris'] = $this->kategoriModel->getKategoriAktif();

        return view('toko_view', $data);
    }
}
