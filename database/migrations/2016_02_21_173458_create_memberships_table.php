<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('memberships', function (Blueprint $table) {
          $table->increments('id');
          $table->string('label');
          $table->string('role')->nullable();
          $table->date('start')->nullable();
          $table->date('end')->nullable();
          $table->integer('organization_id')->unsigned()->nullable()->index();
          $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
          $table->integer('post_id')->unsigned()->nullable()->index();
          $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
          $table->integer('person_id')->unsigned()->index();
          $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
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
      Schema::drop('memberships');
    }
}
