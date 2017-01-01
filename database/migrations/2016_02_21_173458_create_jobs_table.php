<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
          $table->increments('id');
          $table->date('start')->nullable();
          $table->date('end')->nullable();
          $table->integer('politician_id')->unsigned();
          $table->foreign('politician_id')->references('id')->on('politicians')->onDelete('cascade');
          $table->integer('politician_category_id')->unsigned();
          $table->foreign('politician_category_id')->references('id')->on('politician_categories')->onDelete('cascade');
          $table->integer('party_id')->unsigned();
          $table->foreign('party_id')->references('id')->on('parties')->onDelete('cascade');
          $table->timestamps();
        });

        Schema::create('job_job_position', function(Blueprint $table) {
          $table->integer('job_id')->unsigned()->index();
          $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
          $table->integer('job_position_id')->unsigned()->index();
          $table->foreign('job_position_id')->references('id')->on('job_positions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('job_job_position');
        Schema::drop('jobs');
    }
}
