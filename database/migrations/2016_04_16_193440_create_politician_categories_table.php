<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoliticianCategoriesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('politician_categories', function(Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->integer('event_category_id')->unsigned()->nullable();
      $table->timestamps();
    });
    Schema::create('politician_politician_category', function(Blueprint $table) {
      $table->integer('politician_id')->unsigned()->index();
      $table->foreign('politician_id')->references('id')->on('politicians')->onDelete('cascade');
      $table->integer('politician_category_id')->unsigned()->index();
      $table->foreign('politician_category_id')->references('id')->on('politician_categories')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('politician_politician_category', function($table) {
        $table->dropForeign('politician_politician_category_politician_id_foreign');
        $table->dropForeign('politician_politician_category_politician_category_id_foreign');
    });
    Schema::drop('politician_categories');
    Schema::drop('politician_politician_category');
  }

}
