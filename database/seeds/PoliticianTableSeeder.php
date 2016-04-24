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

		$politicians = [
			[ 'name' => '朱立倫', 'party_id' => 1, 'sex' => '男' ],
			[ 'name' => '蔡英文', 'party_id' => 2, 'sex' => '女' ],
			[ 'name' => '宋楚瑜', 'party_id' => 3, 'sex' => '男' ]
    	];

        $sexRoot = PoliticianCategory::create(['name' => '性別']);

    	foreach($politicians as $politician){
    		$p = Politician::create([
                'name' => $politician['name'],
                'party_id' => $politician['party_id']
            ]);
            $sex = PoliticianCategory::firstOrCreate([
                'parent_id' => $sexRoot->id,
                'name' => $politician['sex']
            ]);

            $p->categories()->attach($sex->id);
		}
    }
}
