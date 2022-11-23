<?php

namespace App\Exports\Stocks;

use App\Models\ProductStock;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

//Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
//    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
//});

class StockReportExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    use Importable, RegistersEventListeners;

    protected $filter;
    protected $lastRecord;
    protected $sum;


    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if (is_string($this->filter)) {
            $productStocks = ProductStock::where('date', date("Y-m-d",
                strtotime($this->filter)))
                ->with('product')->get();
        } else {
            if ($this->filter['product_id'] !== 'all') {
                $productStocks = ProductStock::where('product_id', $this->filter['product_id'])->whereBetween('date',
                    [date("Y-m-d", strtotime($this->filter['date_from'])), date("Y-m-d",
                        strtotime($this->filter['date_to']))])->with('product')->get();
            } else {
                $productStocks = ProductStock::whereBetween('date', [date("Y-m-d",
                    strtotime($this->filter['date_from'])), date("Y-m-d", strtotime($this->filter['date_to']))])
                    ->with('product')->get();
            }
        }

        $this->resultSize = sizeOf($productStocks);
        if (!$productStocks->isEmpty()) {
            $this->sum = $productStocks->sum('quantity');
            $this->lastRecord = $productStocks[sizeOf($productStocks) - 1];
        }

        return $productStocks;

    }

    /**
     * @param mixed $rate
     * @return array
     */
    public function map($productStock): array
    {
        if ($productStock->id == $this->lastRecord['id']) {
            return [
                [$productStock->product->name,
                    $productStock->quantity,
                ],
                ['Total',
                    $this->sum,
                    ''
                ]
            ];
        } else {
            return [
                $productStock->product->name,
                $productStock->quantity,
//                $productStock->date
            ];
        }
    }

    /**
     * @return array|string[]
     */
    public function headings(): array
    {
        if (is_string($this->filter)) {
            return [
                ['PRODUCT NAME', 'Closing'],
                ['', 'QTY as on'],
                ['', $this->filter],
            ];
        } else {
            return [
                ['PRODUCT NAME', 'Closing'],
                ['', 'QTY as on'],
                ['', $this->filter['date_to']],
            ];
        }
    }

//    public static function afterSheet(AfterSheet $event)
//    {
//        // GET BORDER
//        $event->sheet->getDelegate()->getStyle('A1:A3')
//            ->getBorders()
//            ->getBottom()
//            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
//
//        $event->sheet->getDelegate()->getStyle('A1:A3')
//            ->getBorders()
//            ->getLeft()
//            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
//
//        $event->sheet->getDelegate()->getStyle('A1:A3')
//            ->getBorders()
//            ->getRight()
//            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
//
//        $event->sheet->getDelegate()->getStyle('A1:A3')
//            ->getBorders()
//            ->getTop()
//            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
//
//        // MERGE CELLS
//        $event->sheet->getDelegate()->mergeCells('A1:A3');
//
//        // APPLY COLOR ON CELLS
//        $event->sheet->getDelegate()->getStyle('A1:A3')
//            ->getFill()
//            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
//            ->getStartColor()
//            ->setARGB('DBE0F3');
//
//        // APPLY ALLIGNMENT ON CELLS
//        $event->sheet->getDelegate()->getStyle('A1:A3')
//            ->getAlignment()
//            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
//
//        $event->sheet->getDelegate()->getStyle('B1:B3')
//            ->getFill()
//            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
//            ->getStartColor()
//            ->setARGB('FCE995');
//
//        // SET COLOR ON CELLS
//        $event->sheet->getDelegate()->getStyle('B4:B' . ($event->sheet->getHighestRow() - 1))
//            ->getFill()
//            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
//            ->getStartColor()
//            ->setARGB('FFFF00');
//
//        $event->sheet->getDelegate()->getStyle('B4:B' . ($event->sheet->getHighestRow()))
//            ->getFill()
//            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
//            ->getStartColor()
//            ->setARGB('DBE0F3');
//
//        $event->sheet->getDelegate()->getStyle('B4:B' . $event->sheet->getHighestRow())
//            ->getBorders()
//            ->getBottom()
//            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
//
//        $event->sheet->getDelegate()->getStyle('B4:B' . $event->sheet->getHighestRow())
//            ->getBorders()
//            ->getLeft()
//            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
//
//        $event->sheet->getDelegate()->getStyle('B4:B' . $event->sheet->getHighestRow())
//            ->getBorders()
//            ->getRight()
//            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
//
//        $event->sheet->getDelegate()->getStyle('B4:B' . $event->sheet->getHighestRow())
//            ->getBorders()
//            ->getTop()
//            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
//
//        $event->sheet->getDelegate()->getStyle('B1')
//            ->getBorders()
//            ->getBottom()
//            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
//
//        $event->sheet->getDelegate()->getStyle('B1')
//            ->getBorders()
//            ->getRight()
//            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
//
//        $event->sheet->getDelegate()->getStyle('B2')
//            ->getBorders()
//            ->getBottom()
//            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
//
//        $event->sheet->getDelegate()->getStyle('B2')
//            ->getBorders()
//            ->getRight()
//            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
//
//        $event->sheet->getDelegate()->getStyle('B3')
//            ->getBorders()
//            ->getBottom()
//            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
//
//        $event->sheet->getDelegate()->getStyle('B3')
//            ->getBorders()
//            ->getRight()
//            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
//    }

}
