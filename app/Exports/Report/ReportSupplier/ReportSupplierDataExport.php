<?php

namespace App\Exports\Report\ReportSupplier;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Sheet;

class ReportSupplierDataExport implements WithCustomStartCell, WithHeadings, WithTitle, WithEvents
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
            'ID',
            'Nama',
            'Email',
            'Negara',
            'Provinsi',
            'Kabupaten/Kota',
            'Kecamatan',
            'Kelurahan',
            'Alamat',
            'No. Hp',
            'Directur',	
            'No. Hp Directur',
            'PIC',
            'No. Hp PIC',
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
                    ->styleCells('A1:N1', [
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

                $row_cell = 2;

                $data = DB::table('tcompany as a')->sharedLock()
                    ->select(
                        'a.id as Id',
                        'a.name as SupplierName',
                        'a.email as Email',
                        'b.country_name as Country',
                        'c.provinsi_name as Province',
                        'd.kabupaten_name as Regency',
                        'e.kecamatan_name as District',
                        'f.kelurahan_name as SubDistrict',
                        'a.address as Address',
                        'a.handphone as SupplierPhone',
                        'a.director as DirectorName',
                        'a.handphone_director as DirectorPhone',
                        'a.pic as PersonInChargeName',
                        'a.handphone_pic as PersonInChargePhone'
                    )
                    ->join('tcountry as b', function($join) {
                        $join->on('a.country', '=', 'b.country_id');
                    })
                    ->join('tprovinsi as c', function($join) {
                        $join->on('a.province', '=', 'c.provinsi_id');
                    })
                    ->join('tkabupaten as d', function($join) {
                        $join->on('a.regency', '=', 'd.kabupaten_id');
                    })
                    ->join('tkecamatan as e', function($join) {
                        $join->on('a.district', '=', 'e.kecamatan_id');
                    })
                    ->join('tkelurahan as f', function($join) {
                        $join->on('a.subdistrict', '=', 'f.kelurahan_id');
                    })
                    ->join('users as g', function($join) {
                        $join->on('a.id', '=', 'g.client_id');
                    })
                    ->where('a.type', '1')
                    ->where('g.status', 1)
                    ->get();

                $rslt = $data->map(function($value, $key) {
                    return [
                        'Id' => $value->Id,
                        'SupplierName' => $value->SupplierName,
                        'Email' => $value->Email,
                        'Country' => $value->Country,
                        'Province' => $value->Province,
                        'Regency' => $value->Regency,
                        'District' => $value->District,
                        'SubDistrict' => $value->SubDistrict,
                        'Address' => $value->Address,
                        'SupplierPhone' => $value->SupplierPhone,
                        'DirectorName' => $value->DirectorName,
                        'DirectorPhone' => $value->DirectorPhone,
                        'PersonInChargeName' => $value->PersonInChargeName,
                        'PersonInChargePhone' => $value->PersonInChargePhone,
                    ];
                });

                foreach ($rslt as $i => $value) {
                    $event->sheet->setCellValue('A'. $row_cell, $value['Id']);
                    $event->sheet->setCellValue('B'. $row_cell, $value['SupplierName']);
                    $event->sheet->setCellValue('C'. $row_cell, $value['Email']);
                    $event->sheet->setCellValue('D'. $row_cell, $value['Country']);
                    $event->sheet->setCellValue('E'. $row_cell, $value['Province']);
                    $event->sheet->setCellValue('F'. $row_cell, $value['Regency']);
                    $event->sheet->setCellValue('G'. $row_cell, $value['District']);
                    $event->sheet->setCellValue('H'. $row_cell, $value['SubDistrict']);
                    $event->sheet->setCellValue('I'. $row_cell, $value['Address']);
                    $event->sheet->setCellValue('J'. $row_cell, $value['SupplierPhone']);
                    $event->sheet->setCellValue('K'. $row_cell, $value['DirectorName']);
                    $event->sheet->setCellValue('L'. $row_cell, $value['DirectorPhone']);
                    $event->sheet->setCellValue('M'. $row_cell, $value['PersonInChargeName']);
                    $event->sheet->setCellValue('N'. $row_cell, $value['PersonInChargePhone']);

                    $row_cell++;
                }

                $last_row = $row_cell == 2 ? 7 : $row_cell - 1;

                $event->sheet
                    ->styleCells('A1:N'.$last_row, [
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
