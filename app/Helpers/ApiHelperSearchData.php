<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
class ApiHelperSearchData
{
    function search($table, $column, $searchTerm)
    {
        return DB::table($table)
            ->where($column, 'LIKE', '%' . $searchTerm . '%')
            ->get();
    }
}
