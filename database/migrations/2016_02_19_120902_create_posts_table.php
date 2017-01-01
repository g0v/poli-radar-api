<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_classifications', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->integer('event_category_id')->unsigned()->nullable()->index();
          $table->timestamps();
        });
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->string('altLabel')->nullable();
            $table->string('role')->nullable();
            $table->integer('organization_id')->unsigned()->index();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->integer('post_classification_id')->unsigned()->nullable()->index();
            $table->foreign('post_classification_id')->references('id')->on('post_classifications')->onDelete('cascade');
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
        Schema::drop('posts');
        Schema::drop('post_classifications');
    }
}
