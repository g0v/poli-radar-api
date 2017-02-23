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
            $table->text('description')->nullable();
            $table->string('link')->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('place_id')->unsigned()->nullable();
            $table->string('place_type')->nullable();
            $table->integer('person_id')->unsigned();
            $table->foreign('person_id')->references('id')->on('persons');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('events');
    }
}
