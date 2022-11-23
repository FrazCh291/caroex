<?php

namespace App\Exports\Products;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $products = Product::select('name','sku')->get();
        return $products;
    }

    /**
     * @param mixed $rate
     * @return array
     */
    public function map($product): array
    {
            return [
                $product->name,
                $product->sku
            ];
    }

    /**
     * @return array|string[]
     */
    public function headings(): array
    {
        return [
            'Product',
            'Sku'
        ];
    }
}
