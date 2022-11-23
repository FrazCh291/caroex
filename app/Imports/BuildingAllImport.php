<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BuildingAllImport implements WithMultipleSheets
{
    /**
     * @param Collection $collection
     */
    public function sheets(): array
    {

        return [
            new BuildingsImport(),
            new SectionsImport(),
            new AislesImport(),
            new BaysImport(),
            new LevelsImport(),
            new BinsImport()
        ];
    }
}
