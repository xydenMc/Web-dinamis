-- =====================================================
-- Laporan Penjualan Queries
-- =====================================================

-- 1. Laporan Omzet Harian
-- ==========================================
SELECT
    DATE(created_at) as tanggal,
    COUNT(*) as jumlah_transaksi,
    SUM(subtotal) as total_subtotal,
    SUM(ongkos_kirim) as total_ongkos,
    SUM(total) as total_omzet
FROM transactions
WHERE status != 'cancelled'
GROUP BY DATE(created_at)
ORDER BY tanggal DESC;

-- 2. Laporan Omzet Bulanan
-- ==========================================
SELECT
    DATE_FORMAT(created_at, '%Y-%m') as bulan,
    DATE_FORMAT(created_at, '%M %Y') as nama_bulan,
    COUNT(*) as jumlah_transaksi,
    SUM(subtotal) as total_subtotal,
    SUM(ongkos_kirim) as total_ongkos,
    SUM(total) as total_omzet
FROM transactions
WHERE status != 'cancelled'
GROUP BY bulan
ORDER BY bulan DESC;

-- 3. Laporan Omzet dengan Filter Rentang Tanggal
-- ==========================================
SELECT
    DATE(created_at) as tanggal,
    COUNT(*) as jumlah_transaksi,
    SUM(subtotal) as total_subtotal,
    SUM(ongkos_kirim) as total_ongkos,
    SUM(total) as total_omzet
FROM transactions
WHERE status != 'cancelled'
    AND created_at BETWEEN 'START_DATE 00:00:00' AND 'END_DATE 23:59:59'
GROUP BY DATE(created_at)
ORDER BY tanggal ASC;