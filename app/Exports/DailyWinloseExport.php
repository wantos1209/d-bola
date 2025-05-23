<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class DailyWinloseExport implements FromArray, WithHeadings, WithEvents
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Company',
            'Username',
            'Tanggal',
            'Turnover',
            'Bet Count',
            'Member Win',
            'Company Win',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $delegate = $sheet->getDelegate();

                $sheet->getStyle('A1:G1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                        'color' => ['rgb' => '000000'],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'D9E1F2'], 
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $rowCount = count($this->data) + 1;
                $sheet->getStyle("A2:G{$rowCount}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '999999'],
                        ],
                    ],
                ]);

                // Add totals
                $totals = [
                    'Total',
                    '',
                    '',
                    $this->sumColumn(3),
                    $this->sumColumn(4),
                    $this->sumColumn(5),
                    $this->sumColumn(6),
                ];
                $totalRowIndex = $rowCount + 1;

                $delegate->fromArray($totals, null, "A{$totalRowIndex}");

                $sheet->getStyle("A{$totalRowIndex}:G{$totalRowIndex}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FFF2CC'], 
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                foreach (range('A', 'G') as $col) {
                    $delegate->getColumnDimension($col)->setAutoSize(true);
                }

                $delegate->freezePane('A2');
            },
        ];
    }

    private function sumColumn($index)
    {
        return array_sum(array_map(function ($row) use ($index) {
            return (int)str_replace('.', '', $row[$index]);
        }, $this->data));
    }
}
