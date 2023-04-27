<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use App\Models\EmployeeHistory;

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


    public static function updateWithHistoryLog($model, $data)
    {
        $model->update($data);

        $log = new EmployeeHistory([
            'model_id' => $model->id,
            'model_type' => get_class($model),
            'action' => 'update',
            'data' => json_encode($data),
        ]);

        $log->update();
    }


    public static function update($data)
    {
        DB::beginTransaction();

        try {
            // Your update logic here
            $result = DB::table('clients')
                         ->where('id', $data['id'])
                         ->update(['column_name' => $data['new_value']]);
            dd($result); // Debugging statement to print out the result of the update query

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

}
