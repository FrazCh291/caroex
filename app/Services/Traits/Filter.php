<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 10/22/2020
 * Time: 4:13 PM
 */

namespace App\Services\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filter
{
    public function filter(Builder $query, array $filters)
    {
        $query->where(function ($query) use ($filters) {
            foreach ($filters as $key => $value) {
                if (request()->has($key)) {
                    $query->orWhere($key, $value);
                }
            }
        });

        return $query;
    }
}
