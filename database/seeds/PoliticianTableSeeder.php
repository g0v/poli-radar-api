<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Membership;
use App\Organization;
use App\Person;
use App\Post;
use App\PostClassification;

class PoliticianTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Membership::truncate();
        Organization::truncate();
        Person::truncate();
        Post::truncate();
        PostClassification::truncate();

        $json = __DIR__ . '/json/legi-party.json';

        $legis_list = json_decode(file_get_contents($json), true);

        $legis = PostClassification::create([
            'name' => '立法委員',
        ]);

        $local_service = PostClassification::create([
            'name' => '選區',
        ]);

        $commitee_class = PostClassification::create([
            'name' => '委員會',
        ]);

        $legis_yuan = Organization::create([
            'name' => '立法院',
        ]);

        $faker = \Faker\Factory::create();

        foreach ($legis_list as $politician) {
            $person = Person::create([
                'name' => $politician['姓名'],
                'gender' => $politician['性別'],
                'image' => $faker->imageUrl(400, 400, 'cats'),
            ]);

            $party = Organization::firstOrCreate([
              'name' => $politician['黨籍']
            ]);

            $post = Post::firstOrCreate([
              'label' => '第九屆立法委員',
              'start' => '2016-02-01',
              'end' => '2020-01-31',
              'post_classification_id' => $legis->id,
              'organization_id' => $legis_yuan->id,
            ]);

            $member = Membership::create([
              'label' => '立法委員',
              'person_id' => $person->id,
              'start' => $politician['到職日期'],
              'end' => $politician['離職日期'] ?? null,
              'post_id' => $post->id,
              'organization_id' => $legis_yuan->id,
            ]);

            Membership::create([
              'label' => '黨員',
              'person_id' => $person->id,
              'organization_id' => $party->id,
            ]);

            $local = Post::firstOrCreate([
              'label' => $politician['選區'],
              'start' => '2016-02-01',
              'end' => '2020-01-31',
              'post_classification_id' => $local_service->id,
              'organization_id' => $legis_yuan->id,
            ]);

            Membership::create([
              'label' => '分區立委',
              'start' => '2016-02-01',
              'end' => '2020-01-31',
              'person_id' => $person->id,
              'organization_id' => $legis_yuan->id,
              'post_id' => $local->id,
            ]);

            if (isset($politician['委員會'])) {
              foreach ($politician['委員會'] as $period) {
                foreach ($period as $key => $value) {
                  if (strpos($value, ' (召集委員)') !== false) {
                    $name = str_replace(' (召集委員)', '', $value);
                    $commitee_org = Organization::firstOrCreate([
                        'name' => $name,
                        'parent_id' => $legis_yuan->id,
                    ]);

                    $commitee_post = Post::firstOrCreate([
                      'label' => $name . '召集委員',
                      'organization_id' => $commitee_org->id,
                      'post_classification_id' => $commitee_class->id,
                    ]);

                  } else {
                    $commitee_org = Organization::firstOrCreate([
                        'name' => $value,
                        'parent_id' => $legis_yuan->id,
                    ]);

                    $commitee_post = Post::firstOrCreate([
                      'label' => $value . '委員',
                      'organization_id' => $commitee_org->id,
                      'post_classification_id' => $commitee_class->id,
                    ]);

                  }

                  // 2016/02/19 ~ 2016/07/15
                  // 2016/09/13 ~ 2016/12/30
                  if ($key == '第9屆第1會期') {
                    $start = '2016/02/19';
                    $end = '2016/07/19';
                  }

                  if ($key == '第9屆第2會期') {
                    $start = '2016/09/13';
                    $end = '2016/12/30';
                  }

                  $commitee_member = Membership::create([
                    'label' => $key,
                    'start' => $start,
                    'end' => $end,
                    'organization_id' => $commitee_org->id,
                    'post_id' => $commitee_post->id,
                    'person_id' => $person->id,
                  ]);

                }
              }
            }

        }
    }
}
