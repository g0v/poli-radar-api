<?php

use Illuminate\Database\Seeder;
use App\Person;
use App\PostClassification;
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

        EventCategory::truncate();
        Event::truncate();
        Location::truncate();
        DB::table('event_event_category')->truncate();

        $evt_cat = EventCategory::create(['name' => '立法委員']);
        $cats_list = ['中央行程', '地方行程', '媒體行程'];
        $main_cats = array_map(function($cat_name) use ($evt_cat) {
          $sub_cat = EventCategory::create([
            'parent_id' => $evt_cat->id,
            'name' => $cat_name,
          ]);
          return $sub_cat;
        }, $cats_list);
        $poli_cat = PostClassification::where('name', '立法委員')->first();
        $evt_cat->post_classification()->save($poli_cat);

        $faker = \Faker\Factory::create('zh_TW');

        foreach (Person::all() as $person) {
          foreach ($main_cats as $sub_cat) {
            for ($i = 0; $i < 3; $i++) {
              $evt = Event::create([
                'date' => $faker->dateTimeBetween('2016-02-01'),
                'name' => $faker->realText($faker->numberBetween(10,20)),
                'person_id' => $person->id,
                'user_id' => 1,
              ]);

              $evt->categories()->attach($sub_cat);
            }
          }
        }
    }
}
