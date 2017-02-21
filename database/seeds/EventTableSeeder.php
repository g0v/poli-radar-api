<?php

use Illuminate\Database\Seeder;
use App\Person;
use App\PostClassification;
use App\Event;
use App\EventCategory;
use App\Location;
use App\MediaType;
use App\Media;
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
        MediaType::truncate();
        Media::truncate();
        DB::table('event_event_category')->truncate();
        $photo = MediaType::create(['name' => '照片', 'slug' => 'photo']);

        $evt_cat = EventCategory::create(['name' => '立法委員']);
        $cats_list = ['國會事務', '地方事務', '媒體公關'];
        $main_cats = array_reduce($cats_list, function($list, $cat_name) use ($evt_cat) {
          $sub_cat = EventCategory::create([
            'parent_id' => $evt_cat->id,
            'name' => $cat_name,
          ]);
          return $list;
        }, []);
        $poli_cat = PostClassification::where('name', '立法委員')->first();
        $evt_cat->post_classification()->save($poli_cat);

        foreach (['余宛如', '吳秉叡', '洪慈庸', '蔣萬安'] as $personName) {

            $fh = fopen(__DIR__ . '/csv/政治人物行程雷達探測行程表 - ' . $personName . '.csv', 'r');
            $header = fgetcsv($fh);

            $person = Person::where('name', $personName)->first();
            while (($row = fgetcsv($fh)) !== false) {
                $data = [];
                foreach ($header as $index => $field) {
                    $data[$field] = $row[$index];
                }
                $event = Event::create([
                    'date' => Carbon::createFromFormat('Y-m-d', $data['行程日期']),
                    'start' => preg_match('/^\d\d:\d\d:\d\d$/', $data['開始時間（選填）']) ? Carbon::createFromFormat('Y-m-d H:i:s', $data['行程日期'] . ' ' . $data['開始時間（選填）']) : null,
                    'end' => preg_match('/^\d\d:\d\d:\d\d$/', $data['結束時間（選填）']) ? Carbon::createFromFormat('Y-m-d H:i:s', $data['行程日期'] . ' ' . $data['結束時間（選填）']) : null,

                    'name' => $data['行程名稱'],
                    'description' => $data['行程敘述（選填）'],
                    'link' => $data['相關連結（選填）'] ?: null,
                    'user_id' => 1,
                ]);
                $event->persons()->attach($person);

                $cat = EventCategory::where('name', $data['行程分類'])->first();
                $event->categories()->attach($cat);
            }
            fclose($fh);
        }
    }
}
