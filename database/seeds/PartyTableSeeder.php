<?php

use Illuminate\Database\Seeder;
use App\Party;

class PartyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Party::truncate();

		$parties = [
			[ 'name' => '國民黨' ],
			[ 'name' => '民進黨' ],
			[ 'name' => '親民黨' ]
    	];

    	foreach($parties as $party){
    		Party::create($party);
		}
    }
}
