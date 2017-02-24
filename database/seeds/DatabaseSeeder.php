<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        //disable foreign key check for this connection before running seeders
        if(config('database.default') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::statement('TRUNCATE cities CASCADE');
        DB::statement('TRUNCATE regions CASCADE');
        //DB::statement('TRUNCATE locations_categories CASCADE');
        DB::statement('TRUNCATE organization_classifications CASCADE');
        DB::statement('TRUNCATE event_categories CASCADE');
        DB::statement('TRUNCATE roles CASCADE');
        DB::statement('TRUNCATE permissions CASCADE');
        DB::statement('TRUNCATE users CASCADE');
        DB::statement('TRUNCATE persons CASCADE');

        $this->call(UserTableSeeder::class);
        $this->call(RegionTableSeeder::class);

        $this->call(PoliticianTableSeeder::class);
        $this->call(EventTableSeeder::class);

        if(config('database.default') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        Model::reguard();
    }
}
