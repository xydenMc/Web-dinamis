# TEMPORARY AUDIT MODE

## Cara Menggunakan

Untuk mengaktifkan mode audit/demo:

1. Buka file `.env`
2. Ubah nilai `AUDIT_MODE` menjadi `true`:
   ```
   AUDIT_MODE = true
   ```

## Fitur yang Diaktif

Dengan `AUDIT_MODE = true`:

- Semua halaman dapat diakses tanpa login
- Session otomatis dibuat dengan role `admin`
- Dashboard admin dapat diakses langsung
- CRUD produk dapat diuji
- Semua fitur toko aktif

## Akun Demo yang Tersedia

Untuk testing login normal:
- **Admin**: admin@gmail.com / admin123
- **Customer**: customer@gmail.com / customer123

## Cara Mematikan

Setelah audit selesai:

1. Buka file `.env`
2. Ubah nilai `AUDIT_MODE` kembali ke `false`:
   ```
   AUDIT_MODE = false
   ```

## Perubahan yang Dilakukan

### File yang Diubah:
- [x] `.env` - Menambahkan konfigurasi AUDIT_MODE
- [x] `app/Filters/CheckSession.php` - Bypass auth saat AUDIT_MODE=true
- [x] `app/Controllers/Login.php` - Redirect ke katalog bila AUDIT_MODE=true
- [x] `app/Controllers/Dashboard.php` - Akses admin gratis bila AUDIT_MODE=true
- [x] `app/Controllers/Toko.php` - Session audit mode dikonfigurasi

### Catatan Penting:
- Semua kode autentikasi tidak diubah/dihapus
- Database user tidak diubah
- Password tidak diubah
- Middleware/filter tidak dihapus
- Flow login normal tetap berfungsi

## Cara Kerja

1. Bila `AUDIT_MODE = true`, filter `CheckSession` melewati pengecekan login
2. Session sementara dibuat dengan role admin untuk testing semua fitur
3. Semua route yang dilindungi filter tetap berfungsi

---
**Penting**: Mode ini bersifat TEMPORARY dan harus dimatikan setelah audit selesai.