<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;

class CommonHelper
{
    public static function saveData($table, $columns, $values)
    {
        $data = array_combine($columns, $values);
        $datas = DB::table($table)->insert($data);
        return $datas;
    }

    


    public static function insertData($table, $data)
    {
        $model = 'App\\Models\\' . ucfirst($table); // generate the model name based on the table name
        $model::create($data);
    }


    public static function saveDatam($model, $data)
    {
        $record = new $model();
        foreach ($data as $key => $value) {
            $record->$key = $value;
        }
        $record->save();
    }

    public static function updateData($model, $data,$id)
    {
        if (isset($data['id'])) {
            $record = $model::findOrFail($data['id']);
            foreach ($data as $key => $value) {
                $record->$key = $value;
            }
            $record->save();
        } else {
            $record = new $model();
            foreach ($data as $key => $value) {
                $record->$key = $value;
            }
            $record->save();
        }
    }

}
