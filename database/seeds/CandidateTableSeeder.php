<?php

use Illuminate\Database\Seeder;
use App\Candidate;

class CandidateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Candidate::truncate();

		$candidates = [
			[ 'name' => '朱立倫', 'color' => '#0071BC' ],
			[ 'name' => '蔡英文', 'color' => '#37B048' ],
			[ 'name' => '宋楚瑜', 'color' => '#C77F1E' ]
    	];

    	foreach($candidates as $candidate){
    		Candidate::create($candidate);
		}
    }
}
