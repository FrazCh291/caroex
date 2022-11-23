<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BuildingsAllExport implements WithMultipleSheets
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function sheets(): array
    {
        $sheets = [
           new BuildingsExport,
           new SectionsExport,
           new AislesExport,
           new BaysExport,
           new LevelsExport,
           new BinsExport
        ];
        
        return $sheets;
    }
}
