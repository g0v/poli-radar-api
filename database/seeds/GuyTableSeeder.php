<?php

use Illuminate\Database\Seeder;
use App\Guy;

class GuyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Guy::truncate();

		$guys = [
			[ 'name' => '朱立倫', 'color' => '#0071BC' ],
			[ 'name' => '蔡英文', 'color' => '#37B048' ],
			[ 'name' => '宋楚瑜', 'color' => '#C77F1E' ]
    	];

    	foreach($guys as $guy){
    		Guy::create($guy);
		}
    }
}
