<?php

namespace App\Exports;

use App\Models\Pesanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting; // <--- TAMBAHAN 1
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;     // <--- TAMBAHAN 2
use Carbon\Carbon;

class LaporanKeuanganNiLaundry implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithColumnFormatting
{
    protected $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function collection()
    {
        $query = Pesanan::with(['pelanggan', 'layanan']);

        if ($this->filter == 'bulanan') {
            $query->whereYear('tanggal_pesan', Carbon::now()->year);
        } elseif ($this->filter == 'tahunan') {
            $query->whereYear('tanggal_pesan', '>=', Carbon::now()->subYears(5)->year);
        } else {
            $query->whereDate('tanggal_pesan', '>=', Carbon::now()->subDays(7));
        }

        return $query->orderBy('tanggal_pesan', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal Pesan',
            'Nama Pelanggan',
            'No HP',        
            'Layanan',
            'Berat',
            'Total Tagihan',
            'Sudah Dibayar',
            'Status Laundry',
            'Status Bayar',
        ];
    }

    public function map($pesanan): array
    {
        // --- LOGIKA BERSIHKAN NOMOR HP ---
        $no_hp = $pesanan->pelanggan->no_hp ?? '';
        
        // 1. Hapus semua karakter selain angka (spasi, +, - hilang)
        $no_hp = preg_replace('/[^0-9]/', '', $no_hp);

        // 2. Jika diawali '08', ganti jadi '628'
        if (substr($no_hp, 0, 1) === '0') {
            $no_hp = '62' . substr($no_hp, 1);
        }

        // Status Bayar
        $statusBayar = 'BELUM LUNAS';
        if ($pesanan->status_pesanan == 'Dibatalkan') {
            $statusBayar = 'DIBATALKAN';
        } elseif ($pesanan->jumlah_bayar >= $pesanan->total_harga && $pesanan->total_harga > 0) {
            $statusBayar = 'LUNAS';
        }

        return [
            '#' . $pesanan->id_pesanan,
            Carbon::parse($pesanan->tanggal_pesan)->format('d/m/Y H:i'),
            $pesanan->pelanggan->nama ?? 'Terhapus',
            
            $no_hp, 

            $pesanan->layanan->nama_layanan ?? '-',
            $pesanan->berat . ' ' . ($pesanan->layanan->jenis == 'Kiloan' ? 'Kg' : 'Pcs'),
            
            $pesanan->total_harga,  
            $pesanan->jumlah_bayar,                

            $pesanan->status_pesanan,
            $statusBayar,
        ];
    }

    /**
    * FORMAT KOLOM AGAR TAMPIL BENAR DI EXCEL
    */
    public function columnFormats(): array
    {
        return [
            'D' => '0', 
            'G' => '#,##0', 
            'H' => '#,##0', 
            'I' => '#,##0', 
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}