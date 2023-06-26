<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class TableHelper
{
        public static function getTableData($tableName, $columns = ['*'])
        {
            $user = Auth::user(); // Assuming you are using Laravel's authentication system
            
            if ($user) {
                $data = DB::table($tableName)
                    ->select($columns)
                    ->where('owner_id', $user->id) // Assuming you have a column named 'user_id' to identify the owner of the data
                    ->latest()
                    ->paginate(10); // Change the '10' to your desired number of results per page

                return $data;
            }

            // If the user is not logged in, you may return an empty result or throw an exception
            throw new \Exception('User not logged in.');
        }

        public static function deleteIfOwner($model, $id)
        {
            $user = Auth::user();
        
            if (!$user) {
                return false; // User is not authenticated
            }
            
            try {
                $data = $model->findOrFail($id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return false; // Data not found
            }
            
            if ($data->owner_id != $user->id) {
                return false; // User is not the owner of the data
            }
            
            return $data->delete(); // Delete the data
        }


        public static function updateIfOwnerByUuid($model, $uuid, $data)
        {
            $user = Auth::user();
    
            if (!$user) {
                return false; // User is not authenticated
            }
    
            $dataToUpdate = $model->where('uuid', $uuid)->firstOrFail();
    
            if ($dataToUpdate->owner_id != $user->id) {
                return false; // User is not the owner of the data
            }
    
            return $dataToUpdate->update($data); // Update the data
        }
}
