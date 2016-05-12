<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->time('start')->nullable();
            $table->time('end')->nullable();
            $table->string('name');
            $table->string('url')->nullable();
            $table->integer('location_id')->unsigned()->nullable();
            $table->foreign('location_id')->references('id')->on('locations');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('event_politician', function(Blueprint $table) {
            $table->integer('politician_id')->unsigned()->index();
            $table->foreign('politician_id')->references('id')->on('politicians')->onDelete('cascade');
            $table->integer('event_id')->unsigned()->index();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('event_politician', function($table) {
            $table->dropForeign('event_politician_politician_id_foreign');
            $table->dropForeign('event_politician_event_id_foreign');
        });
        Schema::drop('events');
        Schema::drop('event_politician');
    }
}
