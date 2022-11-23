<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 10/22/2020
 * Time: 3:05 PM
 */

namespace App\Services\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Sort
{

   
    public function sort(Builder $query, array $columns, $direction = 'desc')
    {
        foreach ($columns as $column) {
            $query = $query->orderBy($column, $direction);
        }

        return $query;
    }
}
