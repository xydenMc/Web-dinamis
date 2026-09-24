<?php

namespace App\Controllers\Admin;

use App\Libraries\SimplePdf;

class Report extends BaseController
{
    public function index()
    {
        $filters = $this->filters();
        $transactions = $this->transactions($filters);
        $data = [
            'title' => 'Laporan Pesanan - Admin',
            'startDate' => $filters['start_date'],
            'endDate' => $filters['end_date'],
            'transactions' => $transactions,
            'totalRevenue' => array_sum(array_map(static fn(array $row): float => $row['status'] === 'Dibatalkan' ? 0 : (float) $row['total_harga'], $transactions)),
            'totalTransactions' => count($transactions),
        ];

        return view('admin/reports/index', $data);
    }

    public function exportCsv()
    {
        $filters = $this->filters();
        $transactions = $this->transactions($filters);
        $rows = [['Nomor Pesanan', 'Tanggal', 'Pelanggan', 'Jumlah Item', 'Total', 'Metode Pembayaran', 'Status']];
        foreach ($transactions as $transaction) {
            $rows[] = [
                $transaction['nomor_transaksi'], $transaction['tanggal'], $transaction['nama_pelanggan'] ?? '',
                $transaction['total_item'], $transaction['total_harga'], $transaction['metode_pembayaran'], $transaction['status'],
            ];
        }

        $output = fopen('php://temp', 'r+');
        foreach ($rows as $row) {
            fputcsv($output, $row);
        }
        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return $this->response
            ->setHeader('Content-Type', 'text/csv; charset=UTF-8')
            ->setHeader('Content-Disposition', 'attachment; filename="laporan-pesanan-' . $filters['start_date'] . '-sampai-' . $filters['end_date'] . '.csv"')
            ->setBody("\xEF\xBB\xBF" . $csv);
    }

    public function exportPdf()
    {
        $filters = $this->filters();
        $transactions = $this->transactions($filters);
        $lines = [
            'GRIYA POT BUNGA',
            'LAPORAN PESANAN',
            'Periode: ' . date('d-m-Y', strtotime($filters['start_date'])) . ' sampai ' . date('d-m-Y', strtotime($filters['end_date'])),
            str_repeat('-', 85),
            'No. | Tanggal | Pelanggan | Status | Total',
            str_repeat('-', 85),
        ];
        $revenue = 0;
        foreach ($transactions as $transaction) {
            $lines[] = $transaction['nomor_transaksi'] . ' | ' . date('d-m-Y', strtotime($transaction['tanggal'])) . ' | ' . ($transaction['nama_pelanggan'] ?? '-') . ' | ' . $transaction['status'] . ' | Rp ' . number_format((float) $transaction['total_harga'], 0, ',', '.');
            if ($transaction['status'] !== 'Dibatalkan') {
                $revenue += (float) $transaction['total_harga'];
            }
        }
        $lines[] = str_repeat('-', 85);
        $lines[] = 'Jumlah pesanan: ' . count($transactions);
        $lines[] = 'Pendapatan (tidak termasuk pesanan dibatalkan): Rp ' . number_format($revenue, 0, ',', '.');

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="laporan-pesanan-' . $filters['start_date'] . '-sampai-' . $filters['end_date'] . '.pdf"')
            ->setBody(SimplePdf::render($lines));
    }

    private function filters(): array
    {
        $start = (string) ($this->request->getGet('start_date') ?? date('Y-m-01'));
        $end = (string) ($this->request->getGet('end_date') ?? date('Y-m-d'));
        $validDate = static function (string $date): bool {
            if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $date, $matches)) {
                return false;
            }
            return checkdate((int) $matches[2], (int) $matches[3], (int) $matches[1]);
        };
        if (!$validDate($start)) {
            $start = date('Y-m-01');
        }
        if (!$validDate($end)) {
            $end = date('Y-m-d');
        }
        if ($start > $end) {
            [$start, $end] = [$end, $start];
        }
        return ['start_date' => $start, 'end_date' => $end];
    }

    private function transactions(array $filters): array
    {
        return $this->db->table('transaksi t')
            ->select('t.*, u.nama as nama_pelanggan')
            ->join('users u', 'u.id = t.id_pelanggan', 'left')
            ->where('t.tanggal >=', $filters['start_date'] . ' 00:00:00')
            ->where('t.tanggal <=', $filters['end_date'] . ' 23:59:59')
            ->orderBy('t.tanggal', 'DESC')
            ->get()->getResultArray();
    }
}
