<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Devloper']);
        Role::create(['name' => 'Tester']);
        Role::create(['name' => 'Support']);
        Role::create(['name' => 'Hr']);
        Role::create(['name' => 'Accopuntant']);
        Role::create(['name' => 'Sales']);
        
    }
}
