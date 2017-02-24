<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeEventPlace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function(Blueprint $table) {
            $table->dropColumn('location_id');
            $table->dropColumn('location_type');
            $table->integer('place_id')->unsigned()->nullable();
            $table->string('place_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function(Blueprint $table) {
            $table->dropColumn('place_id');
            $table->dropColumn('place_type');
            $table->integer('location_id')->unsigned()->nullable();
            $table->string('location_type')->nullable();
        });
    }
}
