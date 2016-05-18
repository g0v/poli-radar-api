<?php

use Illuminate\Database\Seeder;
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
        Politician::truncate();
        PoliticianCategory::truncate();
        DB::table('politician_politician_category')->truncate();

        $json = base_path() . '/database/seeds/legi-party.json';

        $legis = json_decode(file_get_contents($json), true);

		$politicians = [
			[ 'name' => '朱立倫', 'party' => '中國國民黨', 'sex' => '男' ],
			[ 'name' => '蔡英文', 'party' => '民主進步黨', 'sex' => '女' ],
			[ 'name' => '宋楚瑜', 'party' => '親民黨', 'sex' => '男' ]
    	];

        $typeRoot = PoliticianCategory::create(['name' => '類型']);
        $sexRoot = PoliticianCategory::create(['name' => '性別']);
        $partyRoot = PoliticianCategory::create(['name' => '政黨']);

        $candidate = PoliticianCategory::create([
            'name' => '總統候選人',
            'parent_id' => $typeRoot->id,
        ]);

        $legiss = PoliticianCategory::create([
            'name' => '第九屆立法委員',
            'parent_id' => $typeRoot->id,
        ]);
        
    	foreach($politicians as $politician){
    		$p = Politician::create([
                'name' => $politician['name']
            ]);
            $sex = PoliticianCategory::firstOrCreate([
                'parent_id' => $sexRoot->id,
                'name' => $politician['sex']
            ]);
            $party = PoliticianCategory::firstOrCreate([
                'parent_id' => $partyRoot->id,
                'name' => $politician['party']
            ]);

            $p->categories()->attach([$candidate->id, $sex->id, $party->id]);
		}

        foreach ($legis as $politician) {
            $p = Politician::create([
                'name' => $politician['name']
            ]);

            $party = PoliticianCategory::firstOrCreate([
                'parent_id' => $partyRoot->id,
                'name' => $politician['party']
            ]);

            $p->categories()->attach([$legiss->id, $party->id]);
        }
    }
}
