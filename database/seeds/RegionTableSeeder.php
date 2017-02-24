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
        DB::statement('TRUNCATE cities CASCADE');
        DB::statement('TRUNCATE regions CASCADE');

        $json = __DIR__ . '/json/addr.json';

        $cities = json_decode(file_get_contents($json), true);

        foreach ($cities as $name => $regions) {
            $city = City::create(['name' => $name]);
            foreach ($regions as $key => $post) {
                Region::create([
                    'name'        => $key,
                    'postal_code' => $post,
                    'city_id'     => $city->id
                ]);
            }
        }

    }
}
