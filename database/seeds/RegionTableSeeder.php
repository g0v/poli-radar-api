<?php

use Illuminate\Database\Seeder;
use App\City;
use App\Region;

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        City::truncate();
        Region::truncate();

        $json = base_path() . '/database/seeds/addr.json';

        $cities = json_decode(file_get_contents($json), true);

        foreach ($cities as $name => $regions) {
            $city = City::create(['name' => $name]);
            foreach ($regions as $key => $post) {
                Region::create([
                    'name' => $key,
                    'postcode' => $post,
                    'city_id' => $city['id']
                ]);
            }
        }

    }
}
