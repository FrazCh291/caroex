<?php

namespace App\Exports;

use App\Models\Bin;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class BinsExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Bin::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'company_id',
            'level_id',
            'name',
            'code',
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
        return 'bin';
    }
}
