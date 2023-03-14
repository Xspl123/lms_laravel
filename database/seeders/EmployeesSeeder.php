<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
class EmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $userIds = \App\Models\Client::all()->pluck('id')->toArray();
        $rowRand = rand(1,100);

        for ($i = 0; $i<$rowRand; $i++) {
            $employees = [
                'full_name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'job' => 'engineer',
                'note' => 'test note',
                'client_id' => $faker->randomElement($userIds),
                'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now'),
                'updated_at' => \Carbon\Carbon::now(),
                'user_id' => 1
            ];

            DB::table('employees')->insert($employees);
        }
    }
}
