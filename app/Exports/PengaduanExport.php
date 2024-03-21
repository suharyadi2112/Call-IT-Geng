<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Pengaduan;

class PengaduanExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $pengaduan;

    public function __construct($pengaduan)
    {
        $this->pengaduan = $pengaduan;
    }

    public function collection()
    {
        return $this->pengaduan;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Pelapor',
            'Ruangan/Unit',
            'Tanggal Laporan',
            'Jam Laporan',
            'Tanggal Selesai',
            'Jam Selesai',
            'Durasi',
            'Status',
            'Keterangan',
            'Petugas',
            'Validator'
        ];
    }
    
}
