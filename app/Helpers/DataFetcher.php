<?php

namespace App\Helpers;

use App\Models\Employee;
use App\Models\Company;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Module;

class DataFetcher
{
    public static function getEmp($columns = ['*'], $perPage = 10)
    {
        $query = Employee::select($columns);
        $count = $query->count();
        $employee = $query->paginate($perPage);
        return response()->json(['data' => $employee, 'count' => $count]);
    }

    public static function getCompanies($columns = ['*'], $perPage = 10)
    {
        $query = Company::select($columns);
        $count = $query->count();
        $companies = $query->paginate($perPage);
        return response()->json(['data' => $companies, 'count' => $count]);
    }

    public static function getProducts($columns = ['*'], $perPage = 10)
    {
        $query = Product::select($columns);
        $count = $query->count();
        $products = $query->paginate($perPage);
        return response()->json(['data' => $products, 'count' => $count]);
    }

    public static function getProfilesWithModules($columns = ['*'], $perPage = 10)
    {
        $query = Profile::select($columns);
        $count = $query->count();
        $profiles = $query->paginate($perPage);

        // Fetch associated modules for each profile
        foreach ($profiles as $profile) {
            $modules = Module::where('profile_id', $profile->id)->get();
            $profile->modules = $modules;
        }

        return response()->json(['data' => $profiles, 'count' => $count]);
    }

    


    
}
