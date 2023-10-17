<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;


class TableHelper
{
        // public static function getTableData($tableName, $columns = ['*'])
        // {
        //     $user = Auth::user(); // Assuming you are using Laravel's authentication system
            
        //     if ($user) {
        //         $data = DB::table($tableName)
        //             ->select($columns)
        //             ->where('owner_id', $user->id) // Assuming you have a column named 'user_id' to identify the owner of the data
        //             ->latest()
        //             ->paginate(10); // Change the '10' to your desired number of results per page

        //         return $data;
        //     }

        //     // If the user is not logged in, you may return an empty result or throw an exception
        //     throw new \Exception('User not logged in.');
        // }

        public static function getTableData($tableName, $columns = ['*'])
        {
            $user = Auth::user();

            if (!$user) {
                throw new \Exception('User not logged in.');
            }

            $userRole = $user->role_id;

            // Retrieve the role hierarchy based on the user's role ID
            $roleHierarchy = self::getRolesHierarchy($userRole);

            if ($roleHierarchy === null) {
                throw new \Exception('Role hierarchy not defined for the user.');
            }

            // Initialize an array to store user_ids for specified roles
            $userIdsForRoles = self::collectUserIdsForRoles($roleHierarchy);

            $data = DB::table($tableName)
                ->select($columns)
                ->whereIn('owner_id', $userIdsForRoles)
                ->latest()
                ->paginate(10);

            return $data;
        }

        private static function getRolesHierarchy($userRole)
        {
            // Assuming you have a 'roles' table with columns: 'id', 'role_name', 'p_id'
            $userRoles = DB::table('roles')
                ->select('id', 'role_name', 'p_id')
                ->where('id', $userRole)
                ->get();

            return $userRoles;
        }

        private static function collectUserIdsForRoles($roles)
        {
            $userIdsForRoles = [];
            foreach ($roles as $role) {
                $userIds = DB::table('users')
                    ->where('role_id', $role->id)
                    ->pluck('id')
                    ->toArray();
                $userIdsForRoles = array_merge($userIdsForRoles, $userIds);
                // Fetch child roles recursively
                $childRoles = DB::table('roles')
                    ->where('p_id', $role->id)
                    ->get();

                if ($childRoles->count() > 0) {
                    $userIdsForRoles = array_merge($userIdsForRoles, self::collectUserIdsForRoles($childRoles));
                }
            }
            return $userIdsForRoles;
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
