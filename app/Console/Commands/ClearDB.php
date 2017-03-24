<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      if(config('database.default') == 'mysql') {
          \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      }
      foreach(\DB::select('SHOW TABLES') as $table) {
          $table_array = get_object_vars($table);
          \Schema::drop($table_array[key($table_array)]);
      }
      if(config('database.default') == 'mysql') {
          \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
      }
    }
}
