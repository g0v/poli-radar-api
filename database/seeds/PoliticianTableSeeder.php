<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Job;
use App\JobPosition;
use App\JobRecord;
use App\Party;
use App\Politician;
use App\PoliticianCategory;

class PoliticianTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JobRecord::truncate();
        Job::truncate();
        JobPosition::truncate();
        Party::truncate();
        Politician::truncate();
        PoliticianCategory::truncate();

        $json = __DIR__ . '/json/legi-party.json';

        $legis_list = json_decode(file_get_contents($json), true);

        $legis = PoliticianCategory::create([
            'name' => '立法委員',
        ]);

        foreach ($legis_list as $politician) {
            $p = Politician::create([
                'name' => $politician['姓名'],
                'sex' => $politician['性別']
            ]);

            $party = Party::firstOrCreate([
              'name' => $politician['黨籍']
            ]);

            $job = Job::create([
              'start' => $politician['到職日期'],
              'end' => $politician['離職日期'] ?? null,
              'politician_id' => $p->id,
              'politician_category_id' => $legis->id,
              'party_id' => $party->id,
            ]);

            if (isset($politician['委員會'])) {
              foreach ($politician['委員會'] as $period) {
                foreach ($period as $key => $value) {
                  $jp = JobPosition::firstOrCreate([
                    'title' => $value,
                  ]);
                  JobRecord::create([
                    'subtitle' => $key,
                    'job_id' => $job->id,
                    'job_position_id' => $jp->id,
                  ]);
                }
              }
            }

            if (isset($politician['選區'])) {
              $region = JobPosition::firstOrCreate([
                'title' => $politician['選區'],
              ]);
              JobRecord::create([
                'job_id' => $job->id,
                'job_position_id' => $region->id,
              ]);
            }
        }
    }
}
