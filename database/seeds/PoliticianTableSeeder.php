<?php

use Illuminate\Database\Seeder;
use App\Politician;
use App\PoliticianCategory;
use App\PoliticianTrait;

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
        PoliticianTrait::truncate();
        DB::table('politician_politician_category')->truncate();
        DB::table('politician_politician_trait')->truncate();

        $json = base_path() . '/database/seeds/legi-party.json';

        $legis = json_decode(file_get_contents($json), true);

		$politicians = [
			[ 'name' => '朱立倫', 'party' => '中國國民黨', 'sex' => '男' ],
			[ 'name' => '蔡英文', 'party' => '民主進步黨', 'sex' => '女' ],
			[ 'name' => '宋楚瑜', 'party' => '親民黨', 'sex' => '男' ]
    	];

        $candidate = PoliticianCategory::create([
            'name' => '總統候選人',
        ]);

        $president = PoliticianCategory::create([
            'name' => '現任總統',
        ]);

        $legiss = PoliticianCategory::create([
            'name' => '第九屆立法委員',
        ]);

        $mayor = PoliticianCategory::create([
            'name' => '縣市首長',
        ]);

        $sexRoot = PoliticianTrait::create(['name' => '性別']);
        $partyRoot = PoliticianTrait::create(['name' => '政黨']);
        
    	foreach($politicians as $politician){
    		$p = Politician::create([
                'name' => $politician['name']
            ]);
            $sex = PoliticianTrait::firstOrCreate([
                'parent_id' => $sexRoot->id,
                'name' => $politician['sex']
            ]);
            $party = PoliticianTrait::firstOrCreate([
                'parent_id' => $partyRoot->id,
                'name' => $politician['party']
            ]);

            $p->traits()->attach([$sex->id, $party->id]);         
            $p->categories()->attach($candidate->id);  

            if ($p->name == '蔡英文') {
                $p->categories()->attach($president->id);
            }
		}

        foreach ($legis as $politician) {
            $p = Politician::create([
                'name' => $politician['name']
            ]);

            $party = PoliticianTrait::firstOrCreate([
                'parent_id' => $partyRoot->id,
                'name' => $politician['party']
            ]);

            $p->traits()->attach($party->id);
            $p->categories()->attach($legiss->id);   
        }

        $k = Politician::create([
            'name' => '柯文哲'
        ]);

        $noParty = PoliticianTrait::where('name', '無黨籍')->first();

        $k->traits()->attach($noParty->id);
        $k->categories()->attach($mayor->id);
    }
}
