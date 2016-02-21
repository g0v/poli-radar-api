<?php

use Illuminate\Database\Seeder;
use App\Event;

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

    	$evntFile = base_path() . '/database/seeds/events.json';

		$candidates = json_decode(file_get_contents($evntFile), true);

        foreach ($candidates as $candidate) {

            foreach($candidate['events'] as $event){
                $event['candidate_id'] = $candidate['id'];
                Event::create($event);
            }
        }

    	

    }
}
