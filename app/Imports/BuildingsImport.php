<?php

namespace App\Imports;

use App\Models\Building;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BuildingsImport implements ToModel, WithStartRow, ToCollection, WithHeadingRow

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
            if ($key == 'id' || $key == 'company_id' || $key == 'code' || $key == 'name' || $key == 'phone' || $key == 'address_1' || $key == 'address_2' || $key == 'town' || $key == 'county' || $key == 'country' || $key == 'post_code' || $key == 'length' || $key == 'width' || $key == 'height' || $key == 'volume' || $key == 'is_occupied' || $key == 'deleted_at' || $key == 'created_at' || $key == 'updated_at') {
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
            '*.code' => 'required|max:2',
            '*.phone' => 'required',
            '*.length' => 'required|numeric',
            '*.width' => 'required|numeric',
            '*.height' => 'required|numeric',
            '*.address_1' => 'required',
            '*.town' => 'required',
            '*.county' => 'required',
            '*.country' => 'required',
            '*.post_code' => 'required',
        ])->validate();

        foreach ($rows as $row) {


            if (is_int($row['id'])) {
                $building = Building::updateOrCreate(
                    ['id' => $row['id']],
                    [
                        'id' => intval($row['id']),
                        'company_id' => (int)$row['company_id'] == null ? Auth::user()->company_id : (int)$row['company_id'],
                        'name' => $row['name'],
                        'code' => $row['code'],
                        'phone' => $row['phone'],
                        'address_1' => $row['address_1'],
                        'address_2' => $row['address_2'],
                        'city' => $row['town'],
                        'state' => $row['county'],
                        'country' => $row['country'],
                        'zip_code' => $row['post_code'],
                        'length' => ((int)$row['length']) + 0.00,
                        'width' => ((int)$row['width']) + 0.00,
                        'height' => ((int)$row['height']) + 0.00,
                        'volume' => ((int)$row['length'] * (int)$row['width'] * (int)$row['height']) + 0.00,
                        'is_occupied' => (int)$row['is_occupied'] == null ? false : (int)$row['is_occupied']
                    ]
                );
                $building->save();
            }
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
