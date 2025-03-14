<?php

namespace App\Exports\Transactions;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Sheet;

class UploadPOExport implements WithMultipleSheets
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
            new UploadPODataExport($this->with_data),
        ];
    }
}
