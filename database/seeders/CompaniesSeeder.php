<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class CompaniesSeeder extends Seeder
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
            $companies = [
                'cname' => $faker->company,
                'cemail' => $faker->email,
                'ctax_number' => $faker->unixTime($max = 'now'),
                'cphone' => $faker->phoneNumber,
                'ccity' => $faker->city,
                'cbilling_address' => $faker->streetAddress,
                'ccountry' => $faker->country,
                'cpostal_code' => $faker->postcode,
                'cemployees_size' => rand(100,1000),
                'cfax' => $faker->phoneNumber,
                'cdescription' => 'test description',
                'client_id' => $userIds[array_rand($userIds)],
                'created_at' => \Carbon\Carbon::now()->subDays(rand(1, 33)),
                'updated_at' => \Carbon\Carbon::now(),
                'user_id' => 1
            ];

            DB::table('companies')->insert($companies);
        }
    }
}
