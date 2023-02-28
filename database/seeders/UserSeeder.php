<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $user = [
        //     'name' => 'Abhishek',
        //     'email' => 'admin@vert-age.com',
        //     'password' => Hash::make('admin'),
        //     'phone' => '7982748233',
        //     'role' => 'admin',
        //     'experience' => '2',
        //     'cname'=> 'Vert-Age'
        //     ];

        // DB::table('users')->insert($user);


        User::create(['domain_name' => 'vert-age.com']);
        User::create(['domain_name' => 'gmail.com']);
        User::create(['domain_name' => 'yahoo.com']);
        User::create(['domain_name' => 'outlook.com']);
        User::create(['domain_name' => 'live.com']);
        User::create(['domain_name' => 'hotmail.com']);
    }
}
