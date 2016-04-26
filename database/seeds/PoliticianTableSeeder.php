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

		$politicians = [
			[ 'name' => '朱立倫', 'party' => '國民黨', 'sex' => '男' ],
			[ 'name' => '蔡英文', 'party' => '民進黨', 'sex' => '女' ],
			[ 'name' => '宋楚瑜', 'party' => '親民黨', 'sex' => '男' ]
    	];

        $sexRoot = PoliticianCategory::create(['name' => '性別']);
        $partyRoot = PoliticianCategory::create(['name' => '政黨']);

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

            $p->categories()->attach([$sex->id, $party->id]);
		}
    }
}
