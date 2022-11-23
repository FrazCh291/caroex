<?php

namespace App\Exports;

use App\Models\Level;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;


class LevelsExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Level::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'company_id',
            'bay_id',
            'name',
            'code',
            'length',
            'width',
            'height',
            'volume',
            'max_weight',
            'is_occupied',
            'deleted_at',
            'created_at',
            'updated_at'
        ];
    }

    public function title(): string
    {
        return 'level';
    }
}
