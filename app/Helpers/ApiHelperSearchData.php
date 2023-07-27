<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class ApiHelperSearchData
{
    public static function search($table, $searchTerm)
    {
        $loggedInUserId = Auth::id();

        if ($loggedInUserId) 
        {
            $columns = Schema::getColumnListing($table);

            return DB::table($table)
                ->where('user_id', $loggedInUserId)
                ->where(function ($query) use ($columns, $searchTerm) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'LIKE', '%' . $searchTerm . '%');
                    }
                })
                ->latest()
                ->paginate(10);
        }
        // Return null if the user is not logged in
        return null;
    }
}
