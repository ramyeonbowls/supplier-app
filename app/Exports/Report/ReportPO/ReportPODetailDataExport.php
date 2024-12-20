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

class ReportPODetailDataExport implements WithCustomStartCell, WithEvents
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

                $filter = (object) $this->with_data;

                $event->sheet->mergeCells('A1:J1')->setCellValue('A1', 'Laporan Penjualan Buku');
                $event->sheet->mergeCells('A2:J2')->setCellValue('A2', 'Supplier '.auth()->user()->name);

                $event->sheet
                    ->styleCells('A1:J2', [
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
                $event->sheet->setCellValue('B4', ': '.$filter->po_number);
                
                $event->sheet->setCellValue('A5', 'Nama Client');
                $event->sheet->setCellValue('B5', ': '.$filter->client_name);

                $bank = DB::table('tcompany_bank_account')->sharedLock()->where('client_id', $filter->supplier_id)->first();
                
                $account_name = $bank->account_name ?? '';
                $account_bank = $bank->account_bank ?? '';
                $bank_name = $bank->bank ?? '';
                $bank_city = $bank->bank_city ?? '';
                $npwp = $bank->npwp ?? '';

                $event->sheet->setCellValue('A7', 'Nama Rekening');
                $event->sheet->setCellValue('B7', ': '.$account_name);
                $event->sheet->setCellValue('A8', 'Nomor Rekening');
                $event->sheet->setCellValue('B8', ': '.$account_bank);
                $event->sheet->setCellValue('A9', 'Nama Bank');
                $event->sheet->setCellValue('B9', ': '.$bank_name);
                $event->sheet->setCellValue('A10', 'Kota Bank');
                $event->sheet->setCellValue('B10', ': '.$bank_city);
                $event->sheet->setCellValue('A11', 'NPWP');
                $event->sheet->setCellValue('B11', ': '.$npwp);
                $event->sheet->setCellValue('A13', 'Status');
                $event->sheet->setCellValue('B13', ': '.($filter->status == '4' ? 'Lunas' : 'Belum Lunas'));
                    

                $event->sheet->getColumnDimension('A')->setWidth(18);
                $event->sheet->getColumnDimension('B')->setWidth(70);
                $event->sheet->getColumnDimension('C')->setWidth(20);
                $event->sheet->getColumnDimension('D')->setWidth(50);
                $event->sheet->getColumnDimension('E')->setWidth(20);
                $event->sheet->getColumnDimension('F')->setWidth(20);
                $event->sheet->getColumnDimension('G')->setWidth(20);
                $event->sheet->getColumnDimension('H')->setWidth(20);
                $event->sheet->getColumnDimension('I')->setWidth(20);
                $event->sheet->getColumnDimension('J')->setWidth(20);

                $event->sheet->setCellValue('A15', 'No.');
                $event->sheet->setCellValue('B15', 'Judul');
                $event->sheet->setCellValue('C15', 'ISBN');
                $event->sheet->setCellValue('D15', 'Penulis');
                $event->sheet->setCellValue('E15', 'Penerbit');
                $event->sheet->setCellValue('F15', 'Qty');
                $event->sheet->setCellValue('G15', 'Harga');
                $event->sheet->setCellValue('H15', 'Netto ('.$filter->persentase_supplier.'%)');
                $event->sheet->setCellValue('I15', 'Total Harga');
                $event->sheet->setCellValue('J15', 'Total Netto ('.$filter->persentase_supplier.'%)');

                $event->sheet
                    ->styleCells('A15:J15', [
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

                $row_cell = 16;

                $tbook = DB::table('tbook as a')->sharedLock()
                    ->select(
                        'a.*',
                        'b.name',
                        'c.description as publisher_desc'
                    )
                    ->join('tcompany as b', function($join) {
                        $join->on('a.supplier_id', '=', 'b.id')
                            ->on('b.type', '=', DB::raw("'1'"));
                    })
                    ->leftJoin('tpublisher as c', function($join) {
                        $join->on('a.supplier_id', '=', 'c.client_id') 
                            ->on('a.publisher_id', '=', 'c.id') ;
                    });

                $data = DB::table('tpo_header as a')->sharedLock()
                    ->select(
                        'a.client_id as client_id',
                        'a.po_number as po_number',
                        'a.po_date as po_date',
                        'c.supplier_id as supplier_id',
                        'c.name as supplier_name',
                        'b.book_id as book_id',
                        'c.title as book_name',
                        'b.qty as qty',
                        'b.sellprice as sellprice',
                        'c.cover as cover',
                        'c.isbn as isbn',
                        'c.writer as writer',
                        'c.publisher_id as publisher_id',
                        'c.publisher_desc as publisher_desc',
                        'a.persentase_supplier as persentase_supplier'
                    )
                    ->join('tpo_detail as b', function($join) {
                        $join->on('a.client_id', '=', 'b.client_id')
                            ->on('a.po_number', '=', 'b.po_number')
                            ->on('a.po_date', '=', 'b.po_date');
                    })
                    ->joinSub($tbook, 'c', function($join) {
                        $join->on('b.book_id', '=', 'c.book_id');
                    })
                    ->when(isset($filter->supplier_id) && $filter->supplier_id != '', function($query) use ($filter) {
                        $query->where('c.supplier_id', $filter->supplier_id);
                    })
                    ->when(isset($filter->po_number) && $filter->po_number != '', function($query) use ($filter) {
                        $query->where('a.po_number', $filter->po_number);
                    })
                    ->when(isset($filter->po_date) && $filter->po_date != '', function($query) use ($filter) {
                        $query->where('a.po_date', $filter->po_date);
                    })
                    ->when(isset($filter->client_id) && $filter->client_id != '', function($query) use ($filter) {
                        $query->where('a.client_id', $filter->client_id);
                    })
                    ->get();

                $no = 1;
                $total_gross = 0;
                $total_nett = 0;
                $total_netts = 0;
                $total_qty = 0;
                $total_sellprice = 0;
                foreach ($data as $i => $value) {
                    $tgross = $value->sellprice * $value->qty;
                    $tnett = ($value->persentase_supplier != 0) ? ($value->sellprice * $value->qty) * ($value->persentase_supplier / 100) : ($value->sellprice * $value->qty);
                    $nett = ($value->persentase_supplier != 0) ? $value->sellprice * ($value->persentase_supplier / 100) : $value->sellprice;

                    $event->sheet->styleCells('A'. $row_cell, [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical'     => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                        ],
                    ]);
                    $event->sheet->styleCells('F'. $row_cell, [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                            'vertical'     => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                        ],
                    ]);
                    $event->sheet->styleCells('G'. $row_cell, [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                            'vertical'     => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                        ],
                    ]);
                    $event->sheet->styleCells('H'. $row_cell, [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                            'vertical'     => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                        ],
                    ]);
                    $event->sheet->styleCells('I'. $row_cell, [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                            'vertical'     => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                        ],
                    ]);
                    $event->sheet->styleCells('J'. $row_cell, [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                            'vertical'     => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                        ],
                    ]);

                    $event->sheet->setCellValue('A'. $row_cell, $no);
                    $event->sheet->setCellValue('B'. $row_cell, $value->book_name);
                    $event->sheet->setCellValue('C'. $row_cell, $value->isbn);
                    $event->sheet->setCellValue('D'. $row_cell, $value->writer);
                    $event->sheet->setCellValue('E'. $row_cell, $value->publisher_desc);
                    $event->sheet->setCellValue('F'. $row_cell, $value->qty);
                    $event->sheet->setCellValue('G'. $row_cell, $value->sellprice);
                    $event->sheet->setCellValue('H'. $row_cell, $nett);
                    $event->sheet->setCellValue('I'. $row_cell, $tgross);
                    $event->sheet->setCellValue('J'. $row_cell, $tnett);

                    $total_gross += $tgross;
                    $total_nett += $tnett;
                    $total_netts += $nett;
                    $total_qty += $value->qty;
                    $total_sellprice += $value->sellprice;

                    $no++;
                    $row_cell++;
                }

                $last_row = $row_cell == 2 ? 7 : $row_cell - 1;

                $event->sheet
                    ->styleCells('A15:J'.$last_row, [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '808080'],
                            ],
                        ],
                    ]);

                $event->sheet->setCellValue('A12', 'Total Penerimaan');
                $event->sheet->setCellValue('B12', ': '.$total_nett);

                $footer_row = $last_row + 1;

                $event->sheet->mergeCells('A'.$footer_row.':E'.$footer_row)->setCellValue('A'.$footer_row, 'Total');
                $event->sheet->setCellValue('F'.$footer_row, $total_qty);
                $event->sheet->setCellValue('G'.$footer_row, $total_sellprice);
                $event->sheet->setCellValue('H'.$footer_row, $total_netts);
                $event->sheet->setCellValue('I'.$footer_row, $total_gross);
                $event->sheet->setCellValue('J'.$footer_row, $total_nett);

                $event->sheet
                    ->styleCells('A'.$footer_row.':J'.$footer_row, [
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
