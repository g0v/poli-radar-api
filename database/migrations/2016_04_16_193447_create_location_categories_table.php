<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationCategoriesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('location_categories', function(Blueprint $table) {
      // These columns are needed for Baum's Nested Set implementation to work.
      // Column names may be changed, but they *must* all exist and be modified
      // in the model.
      // Take a look at the model scaffold comments for details.
      // We add indexes on parent_id, lft, rgt columns by default.
      $table->increments('id');
      $table->integer('parent_id')->nullable()->index();
      $table->integer('lft')->nullable()->index();
      $table->integer('rgt')->nullable()->index();
      $table->integer('depth')->nullable();

      // Add needed columns here (f.ex: name, slug, path, etc.)
      $table->string('name', 255);

      $table->timestamps();
    });
    Schema::create('location_location_category', function(Blueprint $table) {
      $table->integer('location_id')->unsigned()->index();
      $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
      $table->integer('location_category_id')->unsigned()->index();
      $table->foreign('location_category_id')->references('id')->on('location_categories')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('location_location_category', function($table) {
        $table->dropForeign('location_location_category_location_id_foreign');
        $table->dropForeign('location_location_category_location_category_id_foreign');
    });
    Schema::drop('location_categories');
    Schema::drop('location_location_category');
  }

}
