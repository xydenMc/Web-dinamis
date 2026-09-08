-- Database: web_dinamis_griya_pot_bunga
-- CodeIgniter 4 Compatible SQL Schema
-- Users will be seeded via UserSeeder

CREATE DATABASE IF NOT EXISTS web_dinamis_griya_pot_bunga;
USE web_dinamis_griya_pot_bunga;

-- Table structure for table users
CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE,
  password TEXT NOT NULL,
  role ENUM('admin', 'customer') DEFAULT 'customer' NOT NULL,
  created_at DATETIME NULL DEFAULT NULL,
  updated_at DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table structure for table produk
CREATE TABLE IF NOT EXISTS produk (
  id_produk INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nama_produk VARCHAR(255) NOT NULL,
  deskripsi TEXT,
  kategori VARCHAR(100) DEFAULT 'umum',
  harga INT UNSIGNED NOT NULL DEFAULT 0,
  stok INT UNSIGNED NOT NULL DEFAULT 0,
  status VARCHAR(50) DEFAULT 'aktif',
  gambar TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id_produk)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample data for produk
INSERT INTO produk (nama_produk, deskripsi, kategori, harga, stok, status, gambar) VALUES
('Pot Bunga Keramik Minimalis', 'Pot bunga keramik dengan desain minimalis modern cocok untuk tanaman hias indoor', 'Keramik', 85000, 25, 'aktif', 'https://example.com/pot-minimalis.jpg'),
('Set Pot Bunga Kayu Ekstra', 'Set 3 pot bunga kayu dengan ukuran berbeda, natural finish', 'Kayu', 195000, 12, 'aktif', 'https://example.com/pot-kayu-set.jpg'),
('Pot Bunga Gantung Beton', 'Pot gantung beton dengan tekstur kasar dan desain industrial', 'Beton', 120000, 18, 'aktif', 'https://example.com/pot-beton.jpg'),
('Terrarium Kaca Bulat', 'Terrarium kaca bulat dengan alas kayu, perfect untuk succulent kecil', 'Terrarium', 65000, 30, 'aktif', 'https://example.com/terrarium.jpg'),
('Pot Bunga Keramik Motif Tradisional', 'Pot keramik dengan motif tradisional Jawa, warna coklat tanah', 'Keramik', 150000, 8, 'aktif', 'https://example.com/pot-tradisional.jpg'),
('Set Pot Bunga Keramik Putih', 'Set 4 pot keramik putih glossy dengan ukuran berbeda', 'Keramik', 240000, 20, 'aktif', 'https://example.com/pot-putih-set.jpg'),
('Pot Bunga Beton Custom', 'Pot beton custom sesuai permintaan ukuran dan warna', 'Beton', 175000, 15, 'aktif', 'https://example.com/pot-beton-custom.jpg'),
('Rak Tanaman Kayu Minimalis', 'Rak tanaman kayu dengan 3 tingkat, desain clean', 'Kayu', 290000, 5, 'aktif', 'https://example.com/rak-tanaman.jpg'),
('Pot Bunga Keramik Geometris', 'Pot keramik dengan bentuk geometris unik dan warna earthy', 'Keramik', 95000, 22, 'aktif', 'https://example.com/pot-geometris.jpg'),
('Terrarium Gantung Kecil', 'Terrarium gantung kaca kecil dengan tali rotan', 'Terrarium', 45000, 35, 'aktif', 'https://example.com/terrarium-gantung.jpg');