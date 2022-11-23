<?php

namespace App\Imports;

use App\Models\Bay;
use App\Models\Aisle;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BaysImport implements ToModel, WithStartRow, ToCollection, WithHeadingRow
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
            if ($key == 'id' || $key == 'company_id' || $key == 'aisle_id' || $key == 'code' || $key == 'name' || $key == 'length' || $key == 'width' || $key == 'height' || $key == 'volume' || $key == 'max_weight' || $key == 'is_occupied' || $key == 'is_active' || $key == 'deleted_at' || $key == 'created_at' || $key == 'updated_at') {
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
            '*.aisle_id' => 'required|numeric',
            '*.code' => 'required|max:2',
            '*.length' => 'required|numeric',
            '*.width' => 'required|numeric',
            '*.height' => 'required|numeric',
            '*.max_weight' => 'required|numeric',
        ])->validate();

        foreach ($rows as $row) {
            if (Aisle::where('id', $row['aisle_id'])->exists()) {
                $bay = Bay::updateOrCreate(
                    ['id' => $row['id']],
                    [
                        'id' => intval($row['id']),
                        'company_id' => (int)$row['company_id'] == null ? Auth::user()->company_id : (int)$row['company_id'],
                        'aisle_id' => ((int)$row['aisle_id']),
                        'name'     => $row['name'],
                        'code'     => $row['code'],
                        'length' => ((int)$row['length']) + 0.00,
                        'width' => ((int)$row['width']) + 0.00,
                        'height' => ((int)$row['height']) + 0.00,
                        'volume' => ((int)$row['length'] * (int)$row['width'] * (int)$row['height']) + 0.00,
                        'max_weight' => (int)$row['max_weight'],
                        'is_occupied' => (int)$row['is_occupied'] == null ? false : (int)$row['is_occupied'],
                        'is_active' => (int)$row['is_active'] == null ? false : (int)$row['is_active']
                    ]
                );
                $bay->save();
            } else {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'file' => 'Aisle with id ' . $row['aisle_id'] . ' is not exist'
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
