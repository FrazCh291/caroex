<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 10/22/2020
 * Time: 4:32 PM
 */

namespace App\Services\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

trait Search
{
    public function search(Builder $query, $columns, $param = 'query')
    {
        if (request()->has($param)) {
            request()->merge(['page'=>1]);
            if (strtotime(request($param)) || strtotime(str_replace('/', '-', request($param)))) {
                $array[] = Carbon::parse(strtotime(str_replace('/', '-', request($param))))->format('Y-m-d');
            } else {
                $array = Str::of(request($param))->explode(' ');
            }
            foreach ($array as $item) {
                $query->where(function ($query) use ($columns, $item) {
                    foreach ($columns as $column) {
                        if (env('DB_CONNECTION') == 'pgsql') {
                            $query->orWhere($column, 'ILIKE', '%' . $item . '%');
                        } else {
                            $query->orWhere($column, 'LIKE', '%' . $item . '%');
                        }
                    }
                });
            }
        }

        return $query;
    }

    public function customerSearch(Builder $query, $columns)
    {
        if (request()->has('cus_query')) {
            $array = Str::of(request('cus_query'))->explode(' ');
            foreach ($array as $item) {
                $query->where(function ($query) use ($columns, $item) {
                    foreach ($columns as $column) {
                        if (env('DB_CONNECTION') == 'pgsql') {
                            $query->orWhere($column, 'LIKE', '%' . $item . '%');
                        } else {
                            $query->orWhere($column, 'LIKE', '%' . $item . '%');
                        }
                    }
                });
            }
        }

        return $query;
    }

}
