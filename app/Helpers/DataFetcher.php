<?php

namespace App\Helpers;

use App\Models\Employee;
use App\Models\Company;
use App\Models\Product;

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

    
}
