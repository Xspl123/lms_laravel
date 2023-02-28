<?php

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function givePermissionToAdmin()
    {
        $adminRole = Role::where('name', 'admin')->first();
        $manageUsersPermission = Permission::where('name', 'manage-users')->first();
        $adminRole->permissions()->attach($manageUsersPermission);

        // return a response or redirect
    }

    // add other methods to manage roles and permissions
}

