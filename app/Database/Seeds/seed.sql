-- =====================================================
-- Seed Data for E-Commerce Application
-- Generated: 2024
-- =====================================================

-- Insert admin user (password: admin123, hashed)
INSERT INTO users (id, nama, email, password_hash, telepon, role, created_at) VALUES
(1, 'Admin Toko', 'admin@toko.test', '$2y$10$abcdefghijklmnopqrstuvwx', '081234567890', 'admin', NOW()),
(2, 'Customer Demo', 'customer@toko.test', '$2y$10$abcdefghijklmnopqrstuvwx', '082345678901', 'customer', NOW());

-- Insert categories
INSERT INTO categories (id, nama, slug, deskripsi, is_active, created_at) VALUES
(1, 'Keramik', 'keramik', 'Pot bunga dan gerabah berbahan keramik dengan berbagai ukuran dan motif', 1, NOW()),
(2, 'Kayu', 'kayu', 'Pot dan gerabah kayu alami dengan finish natural yang ramah lingkungan', 1, NOW()),
(3, 'Beton', 'beton', 'Pot bahan beton dengan tekstur industrial dan desain minimalis', 1, NOW()),
(4, 'Terakota', 'terakota', 'Vas dan pot terakota tradisional dengan finishing bakar', 1, NOW());

-- Insert products (using category_id)
INSERT INTO products (category_id, nama, slug, deskripsi, harga, stok, berat, image, is_active, created_at) VALUES
-- Keramik products (1)
(1, 'Pot Bunga Keramik Minimalis', 'pot-bunga-keramik-minimalis', 'Pot bunga keramik dengan desain minimalis modern cocok untuk tanaman hias indoor dan meja kerja.', 85000, 14, 500, 'products/pot-keramik-minimalis.jpg', 1, NOW()),
(1, 'Vas Terakota Klasik Artisan', 'vas-terakota-klasik-artisan', 'Vas tanah liat merah bakar tradisional dengan finishing matte halus.', 95000, 4, 750, 'products/vas-terakota.jpg', 1, NOW()),
(1, 'Pot Relief Flora Etnik', 'pot-relief-flora-etnik', 'Ukiran tangan bermotif daun pakis elegan.', 140000, 19, 600, 'products/pot-relief.jpg', 1, NOW()),
(1, 'Pot Bunga Putih Elegan', 'pot-bunga-putih-elegan', 'Pot bunga berwarna putih dengan pola abstrak yang elegan.', 110000, 12, 450, 'products/pot-putih.jpg', 1, NOW()),
-- Kayu products (2)
(2, 'Set Pot Bunga Kayu Ekstra', 'set-pot-bunga-kayu-ekstra', 'Set 3 pot bunga kayu dengan ukuran berbeda.', 125000, 8, 1200, 'products/set-kayu.jpg', 1, NOW()),
(2, 'Pot Gantung Kayu Cendrawasih', 'pot-gantung-kayu-cendrawasih', 'Pot gantung kayu dengan motifs cendrawasih.', 98000, 6, 800, 'products/pot-gantung-kayu.jpg', 1, NOW()),
-- Beton products (3)
(3, 'Pot Bunga Gantung Beton', 'pot-bunga-gantung-beton', 'Pot gantung beton dengan tekstur raw.', 100000, 3, 900, 'products/pot-gantung-beton.jpg', 1, NOW()),
(3, 'Pot Silinder Terrazzo Pastel', 'pot-silinder-terrazzo-pastel', 'Campuran pecahan marmer dengan warna pastel.', 115000, 7, 650, 'products/pot-terrazzo.jpg', 1, NOW()),
-- Terakota products (4)
(4, 'Vas Beruk Besar', 'vas-beruk-besar', 'Vas berukuran besar dengan bahan terakota merah.', 180000, 5, 1200, 'products/vas-beruk.jpg', 1, NOW()),
(4, 'Pot Mini Rustic', 'pot-mini-rustic', 'Pot mini dengan finish rustic yang unik.', 65000, 15, 300, 'products/pot-mini.jpg', 1, NOW());

-- Insert videos
INSERT INTO videos (judul, youtube_id, deskripsi, urutan, is_active, created_at) VALUES
('Proses Pembuatan Pot Keramik - Dapur Gerabah', 'VIDEO_ID_1', 'Temukan proses pembuatan pot keramik dari awal.', 1, 1, NOW()),
('Tips Perawatan Pot dan Gerabah', 'VIDEO_ID_2', 'Bagaimana cara merawat pot dan gerabah.', 2, 1, NOW()),
('Pengrajin Griya Pot Bunga - Kisah Motivasi', 'VIDEO_ID_3', 'Dengarkan kisah motivasi para pengrajin.', 3, 1, NOW());

-- =====================================================
-- Sales Report Queries
-- =====================================================

-- Daily sales report
-- SELECT DATE(created_at) as tanggal, SUM(total) as total_omzet, COUNT(*) as jumlah_transaksi
-- FROM transactions
-- WHERE status != 'cancelled'
-- AND created_at >= '2024-01-01'
-- GROUP BY DATE(created_at)
-- ORDER BY tanggal ASC;

-- Monthly sales report
-- SELECT DATE_FORMAT(created_at, '%Y-%m') as bulan, SUM(total) as total_omzet, COUNT(*) as jumlah_transaksi
-- FROM transactions
-- WHERE status != 'cancelled'
-- GROUP BY DATE_FORMAT(created_at, '%Y-%m')
-- ORDER BY bulan ASC;

-- Sales by status
-- SELECT status, COUNT(*) as jumlah, SUM(total) as total_omzet
-- FROM transactions
-- WHERE created_at >= '2024-01-01'
-- GROUP BY status;

-- Top selling products
-- SELECT p.nama, SUM(ti.qty) as terjual, SUM(ti.subtotal) as pendapatan
-- FROM products p
-- JOIN transaction_items ti ON p.id = ti.product_id
-- JOIN transactions t ON ti.transaction_id = t.id
-- WHERE t.status IN ('completed', 'shipped', 'processing')
-- GROUP BY p.id, p.nama
-- ORDER BY terjual DESC
-- LIMIT 10;