<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->time('start')->nullable();
            $table->time('end')->nullable();
            $table->string('name');
            $table->string('location')->nullable();
            $table->string('addr');
            $table->float('latitude');
            $table->float('longitude');
            $table->integer('guy_id')->unsigned();
            $table->foreign('guy_id')->references('id')->on('guys');
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
        Schema::drop('activities');
    }
}
