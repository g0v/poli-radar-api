<?php

use Illuminate\Database\Seeder;
use App\Type;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Type::truncate();

		$types = [
			[ 'name' => '站台助選' ],
			[ 'name' => '掃街與接觸民眾' ],
			[ 'name' => '定點造勢活動' ],
			[ 'name' => '拜訪樁腳' ],
			[ 'name' => '訪談演說' ],
			[ 'name' => '其他' ]
    	];

    	foreach($types as $type){
    		Type::create($type);
		}
    }
}
