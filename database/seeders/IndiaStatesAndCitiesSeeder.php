<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class IndiaStatesAndCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    $response = Http::get('https://indian-cities-api.herokuapp.com/cities');

    $data = $response->json();

    $states = collect($data)->pluck('State')->unique()->map(function ($state) {
        return [
            'name' => $state,
            'code' => str_slug($state),
        ];
    })->toArray();

    DB::table('states')->insert($states);

    $cities = collect($data)->map(function ($city) {
        return [
            'name' => $city['City'],
            'state_code' => str_slug($city['State']),
            'latitude' => $city['Latitude'],
            'longitude' => $city['Longitude'],
        ];
    })->toArray();

    DB::table('cities')->insert($cities);
}

}
