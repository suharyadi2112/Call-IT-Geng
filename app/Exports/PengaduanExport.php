<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;



class PengaduanExport implements FromCollection, WithHeadings, ShouldAutoSize, WithCustomStartCell, WithStyles, WithDrawings
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
            'Laporan Kerusakan',
            'Status',
            'Keterangan',
            'Petugas',
            'Validator'
        ];
    }

    public function startCell(): string
    {
        return 'A13';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A4:M4')->applyFromArray([
            'borders' => [
                'bottom' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        $sheet->setCellValue('K5', 'No. Form PMKP :');
        $sheet->getStyle('A:M')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('A6:M6');

        $sheet->setCellValue('A6', 'FORMULIR  ANGKA ANGKA KERUSAKAN JARINGAN');
        $sheet->getStyle('A6')->getFont()->setBold(true);

        $sheet->mergeCells('A7:M7');

        $sheet->setCellValue('A7', 'INDIKATOR MANAJEMEN RESIKO');

        $sheet->setCellValue('A9', 'RUANG       :');
        $sheet->getStyle('A9')->getFont()->setBold(true);

        $sheet->setCellValue('B9', 'INSTALASI IT');
        $sheet->getStyle('B9')->getFont()->setBold(true);

        $sheet->setCellValue('A10', 'PERIODE    :');
        $sheet->getStyle('A10')->getFont()->setBold(true);

        $sheet->setCellValue('J10', 'LEMBAR KE    :');
        $sheet->getStyle('J10')->getFont()->setBold(true);



        $sheet->getStyle('A7')->getFont()->setBold(true);

        // Menambahkan border pada seluruh kolom dari A13 ke bawah hingga M13
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A13:M' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);
        return [
            // Style the first row as bold text and center align
            13 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
            ]
        ];

        // Menambahkan border pada seluruh kolom dari A13 hingga M13 ke bawah

    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setPath(public_path('/assets/img/header.png'));
        $drawing->setHeight(78);
        $drawing->setCoordinates('B1');

        return [$drawing];
    }
}
