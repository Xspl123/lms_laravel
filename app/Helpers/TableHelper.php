<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class TableHelper
{
    public static function getTableData($tableName, $columns = ['*'])
    {
        $data = DB::table($tableName)->select($columns)->latest()->get();

        return $data;
    }
}
