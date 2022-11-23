<?php

namespace App\Exports;

use App\Models\Aisle;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AislesExport implements FromCollection, WithHeadings, WithTitle

{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Aisle::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'company_id',
            'section_id',
            'name',
            'code',
            'length',
            'width',
            'height',
            'volume',
            'is_occupied',
            'is_active',
            'deleted_at',
            'created_at',
            'updated_at'
        ];
    }
    
    public function title(): string
    {
        return 'aisle';
    }
}
