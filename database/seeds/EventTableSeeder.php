<?php

use Illuminate\Database\Seeder;
use App\Politician;
use App\Event;
use App\EventCategory;
use App\Location;
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

        $evntFile = base_path() . '/database/seeds/events.json';

        $politicians = json_decode(file_get_contents($evntFile), true);

        $eventType = EventCategory::create(['name' => '行程分類']);

        foreach ($politicians as $politician)
        {
            $p = Politician::find($politician['id']);

            foreach ($politician['events'] as $event)
            {
                $location = Location::firstOrCreate([
                    'address' => $event['addr'],
                    'lat'     => $event['latitude'],
                    'lng'     => $event['longitude']
                ]);

                $location->name = $event['location'];
                $location->save();
                $date = explode("/", $event['date']);

                $new_event = Event::create([
                    'date'          => Carbon::create($date[0], $date[1], $date[2], 12),
                    'start'         => $event['start'],
                    'end'           => isset($event['end']) ? $event['end'] : null,
                    'name'          => $event['name'],
                    'location_id'   => $location->id,
                    'user_id'       => 1
                ]);

                $category = EventCategory::firstOrCreate([
                    'parent_id' => $eventType->id,
                    'name' => $event['type']
                ]);

                $new_event->categories()->attach($category->id);
                $new_event->politicians()->attach($p->id);

            }

        }

    }
}
