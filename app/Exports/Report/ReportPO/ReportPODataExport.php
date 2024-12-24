<?php

namespace App\Exports\Report\ReportPO;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Sheet;

class ReportPODataExport implements WithCustomStartCell, WithEvents
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
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function(BeforeExport $event) {
                $event->writer->getProperties()->setTitle('Laporan Penjualan Supplier');
                $event->writer->getProperties()->setCreator( config('app.name') );
            },
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $event->sheet->getDelegate()->setShowGridlines(false);

                $sdate = DB::table('tpo_header')->select(DB::raw('min(po_date) as date'))->first();
                $edate = DB::table('tpo_header')->select(DB::raw('max(po_date) as date'))->first();

                $event->sheet->mergeCells('A1:G1')->setCellValue('A1', 'Laporan Penjualan Supplier '.auth()->user()->name);
                $event->sheet->mergeCells('A2:G2')->setCellValue('A2', 'Tanggal '.$sdate->date.' s.d '.$edate->date);

                $event->sheet
                    ->styleCells('A1:F2', [
                        'font' => [
                            'bold' => true
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical'     => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        ]
                    ]);

                $event->sheet->setCellValue('A4', 'Nomor PO');
                $event->sheet->setCellValue('B4', 'Nama Client');
                $event->sheet->setCellValue('C4', 'Nama Supplier');
                $event->sheet->setCellValue('D4', 'Total Gross');
                $event->sheet->setCellValue('E4', 'Total Nett');
                $event->sheet->setCellValue('F4', 'Persentase Supplier');
                $event->sheet->setCellValue('G4', 'Status Pembayaran');
                    

                $event->sheet->getColumnDimension('A')->setWidth(30);
                $event->sheet->getColumnDimension('B')->setWidth(50);
                $event->sheet->getColumnDimension('C')->setWidth(50);
                $event->sheet->getColumnDimension('D')->setWidth(20);
                $event->sheet->getColumnDimension('E')->setWidth(20);
                $event->sheet->getColumnDimension('F')->setWidth(20);
                $event->sheet->getColumnDimension('G')->setWidth(20);

                $event->sheet
                    ->styleCells('A4:G4', [
                        'font' => [
                            'bold' => true
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical'     => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '808080'],
                            ],
                        ],
                    ]);

                $row_cell = 5;

                $tbook = DB::table('tbook as a')->sharedLock()
                    ->select(
                        'a.*',
                        'b.name'
                    )
                    ->join('tcompany as b', function($join) {
                        $join->on('a.supplier_id', '=', 'b.id')
                            ->on('b.type', '=', DB::raw("'1'"));
                    });

                $detail = DB::table('tpo_detail as a')->sharedLock()
                    ->select(
                        'a.client_id as client_id',
                        'a.po_number as po_number',
                        'a.po_date as po_date',
                        'b.supplier_id as supplier_id',
                        'b.name as supplier_name',
                        'a.book_id as book_id',
                        'a.qty as qty',
                        'a.sellprice as sellprice',
                        'c.status as status',
                        'c.payment_image as payment_image'
                    )
                    ->joinSub($tbook, 'b', function($join) {
                        $join->on('a.book_id', '=', 'b.book_id');
                    })
                    ->join('tpo_paid_off as c', function($join) {
                        $join->on('a.client_id', '=', 'c.client_id')
                            ->on('b.supplier_id', '=', 'c.supplier_id')
                            ->on('a.po_number', '=', 'c.po_number')
                            ->on('a.po_date', '=', 'c.po_date');
                    });

                $data = DB::table('tpo_header as a')->sharedLock()
                    ->select(
                        'a.client_id as client_id',
                        'b.instansi_name as client_name',
                        'c.supplier_id as supplier_id',
                        'c.supplier_name as supplier_name',
                        'a.po_number as po_number',
                        'a.po_date as po_date',
                        'a.po_type as po_type',
                        DB::raw('sum(c.sellprice * c.qty) as po_amount'),
                        'a.po_discount as po_discount',
                        'a.persentase_supplier as persentase_supplier',
                        DB::raw("CASE WHEN c.status != '' THEN c.status ELSE a.status END as status"),
                        'c.payment_image as payment_image'
                    )
                    ->join('tclient as b', function($join) {
                        $join->on('a.client_id', '=', 'b.client_id');
                    })
                    ->joinSub($detail, 'c', function($join) {
                        $join->on('a.client_id', '=', 'c.client_id')
                            ->on('a.po_number', '=', 'c.po_number')
                            ->on('a.po_date', '=', 'c.po_date');
                    })
                    ->where('c.supplier_id', auth()->user()->client_id)
                    ->whereIn('a.status', ['3', '4'])
                    ->groupBy(
                        'a.client_id',
                        'b.instansi_name',
                        'c.supplier_id',
                        'c.supplier_name',
                        'a.po_number',
                        'a.po_date',
                        'a.po_type',
                        'a.po_discount',
                        'a.persentase_supplier',
                        'a.status',
                        DB::raw("CASE WHEN c.status != '' THEN c.status ELSE a.status END"),
                        'c.payment_image'
                    )
                    ->get();

                $total_gross = 0;
                $total_nett = 0;
                foreach ($data as $i => $value) {
                    $nett = ($value->persentase_supplier != 0) ? $value->po_amount * ($value->persentase_supplier / 100) : $value->po_amount;
                    $status = $value->status == '4' ? 'Lunas' : 'Belum Lunas';

                    $event->sheet->styleCells('D'. $row_cell, [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                            'vertical'     => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                        ],
                    ]);

                    $event->sheet->styleCells('E'. $row_cell, [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                            'vertical'     => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                        ],
                    ]);

                    $event->sheet->setCellValue('A'. $row_cell, $value->po_number);
                    $event->sheet->setCellValue('B'. $row_cell, $value->client_name);
                    $event->sheet->setCellValue('C'. $row_cell, $value->supplier_name);
                    $event->sheet->setCellValue('D'. $row_cell, $value->po_amount);
                    $event->sheet->setCellValue('E'. $row_cell, $nett);
                    $event->sheet->setCellValue('F'. $row_cell, $value->persentase_supplier);
                    $event->sheet->setCellValue('G'. $row_cell, $status);

                    $total_gross += $value->po_amount;
                    $total_nett += $nett;

                    $row_cell++;
                }

                $last_row = $row_cell == 2 ? 7 : $row_cell - 1;

                $event->sheet
                    ->styleCells('A5:G'.$last_row, [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '808080'],
                            ],
                        ],
                    ]);

                $footer_row = $last_row + 1;

                $event->sheet->mergeCells('A'.$footer_row.':C'.$footer_row)->setCellValue('A'.$footer_row, 'Total');
                $event->sheet->setCellValue('D'.$footer_row, $total_gross);
                $event->sheet->setCellValue('E'.$footer_row, $total_nett);
                $event->sheet->setCellValue('F'.$footer_row, '');
                $event->sheet->setCellValue('G'.$footer_row, '');

                $event->sheet
                    ->styleCells('A'.$footer_row.':G'.$footer_row, [
                        'font' => [
                            'bold' => true
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                            'vertical'     => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '808080'],
                            ],
                        ],
                    ]);
            }
        ];
    }
}
