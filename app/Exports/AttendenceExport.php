<?php

namespace App\Exports;

use App\Models\AttendenceFile;
use Maatwebsite\Excel\Concerns\FromCollection;

class AttendenceExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AttendenceFile::all();
    }
}
