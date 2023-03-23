<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;

class ApiHelperSearchData
{
    public static function search(Builder $query, $request, $table = null, $getCount = false)
    {
        $countQuery = clone $query;
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            if ($table) {
                $query->where("$table.name", 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere("$table.email", 'LIKE', '%' . $searchTerm . '%');
                $countQuery->where("$table.name", 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere("$table.email", 'LIKE', '%' . $searchTerm . '%');
            } else {
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('users.name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('users.email', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('posts.title', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('posts.body', 'LIKE', '%' . $searchTerm . '%');
                });
                $countQuery->where(function ($query) use ($searchTerm) {
                    $query->where('users.name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('users.email', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('posts.title', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('posts.body', 'LIKE', '%' . $searchTerm . '%');
                });
            }
        }

        $totalCount = 0;
        
        if ($getCount) {
            $totalCount = $countQuery->count();
        }

        return [
            'results' => $query->paginate(10),
            'total_count' => $totalCount
        ];
    
    }
}
