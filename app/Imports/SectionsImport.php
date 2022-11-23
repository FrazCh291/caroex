<?php

namespace App\Imports;

use App\Models\Building;
use App\Models\Section;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SectionsImport implements ToModel, WithStartRow, ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $header = array_keys($row);
        foreach ($header as $key) {
            if ($key == 'id' || $key == 'company_id' || $key == 'building_id'  ||  $key == 'code' ||  $key == 'name' || $key == 'length' || $key == 'width' || $key == 'height' || $key == 'volume' || $key == 'is_active' || $key == 'is_occupied' || $key == 'deleted_at' || $key == 'created_at' || $key == 'updated_at') {
            } else {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'file' => 'Header name ' . $key . ' is not acceptable'
                ]);
                throw $error;
            }
        }
    }

    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            '*.id' => 'required|numeric',
            '*.building_id' => 'required|numeric',
            '*.code' => 'required|max:2',
            '*.length' => 'required|numeric',
            '*.width' => 'required|numeric',
            '*.height' => 'required|numeric',
        ])->validate();

        foreach ($rows as $row) {
            if (Building::where('id', $row['building_id'])->exists()) {
                $section = Section::updateOrCreate(
                    ['id' => $row['id']],
                    [
                        'id' => intval($row['id']),
                        'company_id' => (int)$row['company_id'] == null ? Auth::user()->company_id : (int)$row['company_id'],
                        'building_id' => ((int)$row['building_id']),
                        'name'     => $row['name'],
                        'code'     => $row['code'],
                        'length' => ((int)$row['length']) + 0.00,
                        'width' => ((int)$row['width']) + 0.00,
                        'height' => ((int)$row['height']) + 0.00,
                        'volume' => ((int)$row['length'] * (int)$row['width'] * (int)$row['height']) + 0.00,
                        'is_occupied' => (int)$row['is_occupied'] == null ? false : (int)$row['is_occupied'],
                        'is_active' => (int)$row['is_active'] == null ? false : (int)$row['is_active']
                    ]
                );
                $section->save();
            } else {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'file' => 'Building with id ' . $row['building_id'] . ' is not exist'
                ]);
                throw $error;
            }
        }
    }
    public function headingRow(): int
    {
        return 1;
    }
}
