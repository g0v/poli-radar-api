<?php

use Illuminate\Database\Seeder;
use App\Politician;

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
			[ 'name' => '朱立倫', 'party_id' => 1 ],
			[ 'name' => '蔡英文', 'party_id' => 2 ],
			[ 'name' => '宋楚瑜', 'party_id' => 3 ]
    	];

    	foreach($politicians as $politician){
    		Politician::create($politician);
		}
    }
}
