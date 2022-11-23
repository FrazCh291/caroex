<?php

namespace App\Exports;

use App\Models\Section;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class SectionsExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Section::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'company_id',
            'building_id',
            'name',
            'code',
            'length',
            'width',
            'height',
            'volume',
            'is_active',
            'is_occupied',
            'deleted_at',
            'created_at',
            'updated_at'
        ];
    }

    public function title(): string
    {
        return 'section';
    }
}
