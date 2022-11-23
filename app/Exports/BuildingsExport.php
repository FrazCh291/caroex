<?php

namespace App\Exports;

use App\Models\Building;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class BuildingsExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Building::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'company_id',
            'name',
            'code',
            'phone',
            'address_1',
            'address_2',
            'town',
            'county',
            'country',
            'post_code',
            'length',
            'width',
            'height',
            'volume',
            'is_occupied',
            'deleted_at',
            'created_at',
            'updated_at'
        ];
    }

    public function title(): string
    {
        return 'building';
    }
}
