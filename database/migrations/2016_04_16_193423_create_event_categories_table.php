<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventCategoriesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('event_categories', function(Blueprint $table) {
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
    Schema::create('event_event_category', function(Blueprint $table) {
      $table->integer('event_id')->unsigned()->index();
      $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
      $table->integer('event_category_id')->unsigned()->index();
      $table->foreign('event_category_id')->references('id')->on('event_categories')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('event_event_category', function($table) {
        $table->dropForeign('event_event_category_event_id_foreign');
        $table->dropForeign('event_event_category_event_category_id_foreign');
    });
    Schema::drop('event_categories');
    Schema::drop('event_event_category');
  }

}
