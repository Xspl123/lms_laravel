<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use \Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $section = ['transport', 'logistic', 'finances','IT'];

        for ($i = 0; $i<=100; $i++) {
            $client = [
                'clfull_name' => $faker->name,
                'clphone' => $faker->phoneNumber,
                'clemail' => $faker->companyEmail,
                'clsection' => Arr::random($section),
                'clbudget' => rand(100, 1000),
                'cllocation' => $faker->country,
                'clzip' => $faker->postcode,
                'clcity' => $faker->city,
                'clcountry' => $faker->country,
                'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now'),
                'updated_at' => \Carbon\Carbon::now(),
                'user_id' => 1
            ];

             DB::table('clients')->insert($client);
        }
    }
}
