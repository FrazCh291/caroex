<?php

namespace App\Exports;

use App\Models\Bay;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class BaysExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Bay::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'company_id',
            'aisle_id',
            'name',
            'code',
            'length',
            'width',
            'height',
            'volume',
            'max_weight',
            'is_occupied',
            'is_active',
            'deleted_at',
            'created_at',
            'updated_at'
        ];
    }

    public function title(): string
    {
        return 'bay';
    }
}
