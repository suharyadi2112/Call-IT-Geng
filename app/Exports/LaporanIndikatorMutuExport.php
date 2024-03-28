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

class LaporanIndikatorMutuExport implements WithHeadings, ShouldAutoSize, WithCustomStartCell, WithStyles, WithDrawings
{
    public function headings(): array
    {
        return [
            ['JUDUL INDIKATOR MUTU', '', '', 'N/D', 'TARGET', 'CAPAIAN']
        ];
    }

    public function startCell(): string
    {
        return 'A10';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A2:F4')->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        $sheet->getColumnDimension('B')->setAutoSize(true);
        

        // Mengatur tinggi kolom B2
        $sheet->getRowDimension('2')->setRowHeight(27); // Sesuaikan tinggi kolom B2 sesuai kebutuhan
        $sheet->getRowDimension('3')->setRowHeight(27); // Sesuaikan tinggi kolom B2 sesuai kebutuhan
        $sheet->getRowDimension('4')->setRowHeight(27); // Sesuaikan tinggi kolom B2 sesuai kebutuhan

        // Mengatur ukuran font pada sel B2
        $sheet->getStyle('B2:B4')->getFont()->setSize(16); // Sesuaikan ukuran font sesuai kebutuhan

        $sheet->getStyle('A:F')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('A10:C10');
        $sheet->mergeCells('B2:F2');
        $sheet->setCellValue('B2', 'RSUD RAJA AHMAD TABIB');
        $sheet->getStyle('B2')->getFont()->setBold(true);

        $sheet->mergeCells('B3:F3');
        $sheet->setCellValue('B3', 'PENINGKATAN MUTU DAN KESELAMATAN PASIEN');
        $sheet->getStyle('B3')->getFont()->setBold(true);

        $sheet->mergeCells('B4:F4');
        $sheet->setCellValue('B4', 'PENINGKATAN MUTU DAN KESELAMATAN PASIEN');
        $sheet->getStyle('B4')->getFont()->setBold(true);

        $sheet->mergeCells('A6:C6');
        $sheet->setCellValue('A6', 'INSTALASI INFORMASI TEKNOLOGI');
        $sheet->getStyle('A6')->getFont()->setBold(true);

        $sheet->mergeCells('A7:C7');
        $sheet->setCellValue('A7', 'BULAN : ');
        $sheet->getStyle('A7')->getFont()->setBold(true);
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setPath(public_path('/assets/img/kepri.png'));
        $drawing->setHeight(78);
        $drawing->setCoordinates('B2');

        return [$drawing];
    }
}
