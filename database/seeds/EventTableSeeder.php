<?php

use Illuminate\Database\Seeder;
use App\Politician;
use App\PoliticianCategory;
use App\Event;
use App\EventCategory;
use App\Location;
use App\Region;
use Carbon\Carbon;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Event::truncate();
        EventCategory::truncate();
        Location::truncate();
        DB::table('event_event_category')->truncate();
        DB::table('event_politician')->truncate();

        $politicianCategories = [
            '總統',
            '行政首長',
            '立法委員',
            '縣市首長'
        ];

        foreach ($politicianCategories as $name) {
            $politicianCategory = EventCategory::create(['name' => $name]);
            $attachment = PoliticianCategory::where('name', $name)->first();
            if ($attachment) {
                $politicianCategory->politicianCategories()->save($attachment);
            }
        }
    }
}
