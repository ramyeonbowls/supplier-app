<?php

namespace App\Exports\Upload;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Sheet;

class UploadEncyrptDataExport implements WithCustomStartCell, WithHeadings, WithTitle, WithEvents
{
    protected array $with_data;

    public function __construct(array $with_data = [])
    {
        $this->with_data = $with_data;

        Sheet::macro('setOrientation', function (Sheet $sheet, $orientation) {
            $sheet->getDelegate()->getPageSetup()->setOrientation($orientation);
        });

        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });
    }

    /**
     * @return string
     */
    public function startCell(): string
    {
        return 'A1';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'DATA 01';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'FILENAME',
            'ISBN',
            'EISBN',
            'JUDUL',
            'PENULIS',
            'UKURAN BUKU',
            'TAHUN',
            'JILID',
            'EDISI',
            'HALAMAN',	
            'SINOPSIS',
            'HARGA JUAL',
            'HARGA PINJAM',
            'HARGA RETAIL',
            'KOTA',
            'UMUR',
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function(BeforeExport $event) {
                $event->writer->getProperties()->setTitle( 'Details' );
                $event->writer->getProperties()->setCreator( config('app.name') );
            },
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

                $event->sheet
                    ->styleCells('A1:P1', [
                        'font' => [
                            'bold' => true
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical'     => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'color' => ['argb' => 'ffb4c6e7']
                        ]
                    ]);

                $event->sheet->getColumnDimension('A')->setWidth(15);
                $event->sheet->getColumnDimension('B')->setWidth(15);
                $event->sheet->getColumnDimension('C')->setWidth(15);
                $event->sheet->getColumnDimension('D')->setWidth(15);
                $event->sheet->getColumnDimension('E')->setWidth(15);
                $event->sheet->getColumnDimension('F')->setWidth(15);
                $event->sheet->getColumnDimension('G')->setWidth(15);
                $event->sheet->getColumnDimension('H')->setWidth(15);
                $event->sheet->getColumnDimension('I')->setWidth(15);
                $event->sheet->getColumnDimension('J')->setWidth(15);
                $event->sheet->getColumnDimension('K')->setWidth(15);
                $event->sheet->getColumnDimension('L')->setWidth(15);
                $event->sheet->getColumnDimension('M')->setWidth(15);
                $event->sheet->getColumnDimension('N')->setWidth(15);
                $event->sheet->getColumnDimension('O')->setWidth(15);
                $event->sheet->getColumnDimension('P')->setWidth(15);

                $row_cell = 2;
                if ($this->with_data) {
                    foreach ($this->with_data as $i => $value) {
                        $event->sheet->setCellValue('A'. $row_cell, $value);
                        $event->sheet->setCellValue('B'. $row_cell, '');
                        $event->sheet->setCellValue('C'. $row_cell, '');
                        $event->sheet->setCellValue('D'. $row_cell, '');
                        $event->sheet->setCellValue('E'. $row_cell, '');
                        $event->sheet->setCellValue('F'. $row_cell, '');
                        $event->sheet->setCellValue('G'. $row_cell, '');
                        $event->sheet->setCellValue('H'. $row_cell, '');
                        $event->sheet->setCellValue('I'. $row_cell, '');
                        $event->sheet->setCellValue('J'. $row_cell, '');
                        $event->sheet->setCellValue('K'. $row_cell, '');
                        $event->sheet->setCellValue('L'. $row_cell, '');
                        $event->sheet->setCellValue('M'. $row_cell, '');
                        $event->sheet->setCellValue('N'. $row_cell, '');
                        $event->sheet->setCellValue('O'. $row_cell, '');
                        $event->sheet->setCellValue('P'. $row_cell, '');

                        $row_cell++;
                    }
                }

                $last_row = $row_cell == 2 ? 7 : $row_cell - 1;

                $event->sheet
                    ->styleCells('A1:P'.$last_row, [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '808080'],
                            ],
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                            'vertical'     => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP
                        ],
                    ]);
            }
        ];
    }
}
