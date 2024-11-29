<?php

namespace App\Exports\Report\ReportDistributor;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Sheet;

class ReportDistributorExport implements WithMultipleSheets
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

    public function sheets(): array
    {
        return [
            new ReportDistributorDataExport($this->with_data),
        ];
    }
}
