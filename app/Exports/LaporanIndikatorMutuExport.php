<?php

namespace App\Exports;

use Faker\Guesser\Name;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class LaporanIndikatorMutuExport implements FromCollection, WithHeadings,  WithCustomStartCell, WithStyles, WithDrawings
{
    protected $indikator;

    public function __construct($indikator)
    {
        $this->indikator = $indikator;
    }

    public function collection()
    {
        $data = [];

        foreach ($this->indikator as $indikator) {
            $data[] = [
                $indikator->nama_indikator,
                '', // Kolom kosong untuk 'N/D'
                '', // Kolom kosong untuk 'TARGET'
                '', // Kolom kosong untuk 'CAPAIAN'
                ''
            ];

            // Baris untuk 'n'
            $data[] = [
                'N', // Menambahkan 'N:' pada kolom A
                $indikator->n, // Menambahkan nilai $indikator->n pada kolom 'JUDUL INDIKATOR MUTU'
                '', // Kolom kosong untuk 'TARGET'
                '', // Kolom kosong untuk 'CAPAIAN'
                strval($indikator->target) . '%',
            ];

            // Baris untuk 'd'
            $data[] = [
                'D', // Kolom kosong untuk 'N/D'
                $indikator->d,
                '', // Mengonversi nilai target menjadi string
                '', // Kolom kosong untuk 'CAPAIAN'
                ''
            ];

            // Tambah baris kosong untuk memisahkan setiap indikator
            $data[] = [];
        }

        return collect($data);
    }

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
        $lastRow = $sheet->getHighestRow();

        // Mendapatkan data indikator dari konstruktor
        $indikatorData = $this->indikator;

        // Mengatur style untuk setiap baris
        $currentRow = 11; // Mulai dari baris ke-11

        foreach ($indikatorData as $indikator) {
            // Mendapatkan baris dimana nama indikator muncul
            $indikatorRow = $currentRow;

            // Mencari baris dimana nama indikator berikutnya muncul
            while ($currentRow <= $lastRow && $sheet->getCell('A' . $currentRow)->getValue() == $indikator->nama_indikator) {
                $currentRow++;
            }
            $nextIndikatorRow = $currentRow - 1;


            $sheet->mergeCells('B' . ($currentRow) . ':C' . ($currentRow));
            $sheet->mergeCells('B' . ($currentRow + 1) . ':C' . ($currentRow + 1));


            // Merge sel untuk setiap nama indikator
            $sheet->mergeCells('A' . $indikatorRow . ':F' . $nextIndikatorRow);

            // Mengatur style border untuk sel yang digabungkan
            $sheet->getStyle('A' . $indikatorRow . ':F' . $nextIndikatorRow)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
                // Mengatur alignment horizontal untuk kolom A menjadi kiri
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER
                ],
                // Mengatur font dan ukuran
                'font' => [
                    'name' => 'Arial',
                    'size' => 12,
                    'bold' => true
                ]
            ]);

            // Atur baris saat ini ke baris berikutnya
            $currentRow++;
        }



        $sheet->getStyle('A2:F4')->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THICK,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'font' => [
                'name' => 'Constantia'
            ]
        ]);


        $sheet->getStyle('A6:F7')->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THICK,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A10:F' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'font' => [
                'name' => 'Arial',
                'size' => 12
            ]
        ]);

        $sheet->getStyle('A10:F10')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        // Mengatur alignment horizontal untuk kolom A hingga F menjadi pusat
        $sheet->getStyle('A10:F10')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A10:F10')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // Mengatur alignment horizontal untuk baris A6 dan A7 menjadi kiri
        $sheet->getStyle('A6:A7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('A6:A7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle('B2:B4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B2:B4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getColumnDimension('B')->setWidth(80);
        $sheet->getColumnDimension('D')->setWidth(35);
        $sheet->getColumnDimension('E')->setWidth(35);
        $sheet->getColumnDimension('F')->setWidth(35);

        $sheet->getRowDimension('2')->setRowHeight(27); // Sesuaikan tinggi kolom B2 sesuai kebutuhan
        $sheet->getRowDimension('3')->setRowHeight(27); // Sesuaikan tinggi kolom B2 sesuai kebutuhan
        $sheet->getRowDimension('4')->setRowHeight(27); // Sesuaikan tinggi kolom B2 sesuai kebutuhan

        $sheet->getRowDimension('6')->setRowHeight(27); // Sesuaikan tinggi kolom B2 sesuai kebutuhan
        $sheet->getRowDimension('7')->setRowHeight(27); // Sesuaikan tinggi kolom B2 sesuai kebutuhan

        $sheet->getStyle('A6:A7')->getFont()->setSize(16); // Sesuaikan ukuran font sesuai kebutuhan
        // Mengatur ukuran font pada sel B2
        $sheet->getStyle('B2:B4')->getFont()->setSize(16); // Sesuaikan ukuran font sesuai kebutuhan


        $sheet->mergeCells('A10:C10');
        $sheet->mergeCells('B2:F2');
        $sheet->setCellValue('B2', 'RSUD RAJA AHMAD TABIB');
        $sheet->getStyle('B2')->getFont()->setBold(true);


        $sheet->mergeCells('B3:F3');
        $sheet->setCellValue('B3', 'PENINGKATAN MUTU DAN KESELAMATAN PASIEN');
        $sheet->getStyle('B3')->getFont()->setBold(true);

        $sheet->mergeCells('B4:F4');
        $sheet->setCellValue('B4', 'LAPORAN PENCAPAIAN INDIKATOR MUTU UNIT KERJA');
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
        $drawing->setHeight(105);
        $drawing->setCoordinates('B2');

        return [$drawing];
    }
}
