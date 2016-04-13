<?php

use Illuminate\Database\Seeder;
use App\Activity;

class ActivityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	Activity::truncate();

    	$evntFile = base_path() . '/database/seeds/events.json';

		$candidates = json_decode(file_get_contents($evntFile), true);

        foreach ($candidates as $candidate) {

            foreach ($candidate['events'] as $event){
                $tag = (string)$event['type'];
                unset($event['type']); // remove 'type' field from dataset 
                $event['guy_id'] = $candidate['id'];
                $event['addr'] = $event['addr'] || '';
                $activity = Activity::create($event);
                $activity->tag($tag);
            }

        }

    	

    }
}
