<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoliticianTraitsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('politician_traits', function(Blueprint $table) {
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
    Schema::create('politician_politician_trait', function(Blueprint $table) {
      $table->integer('politician_id')->unsigned()->index();
      $table->foreign('politician_id')->references('id')->on('politicians')->onDelete('cascade');
      $table->integer('politician_trait_id')->unsigned()->index();
      $table->foreign('politician_trait_id')->references('id')->on('politician_traits')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('politician_politician_trait', function($table) {
        $table->dropForeign('politician_politician_trait_politician_id_foreign');
        $table->dropForeign('politician_politician_trait_politician_trait_id_foreign');
    });
    Schema::drop('politician_traits');
    Schema::drop('politician_politician_trait');
  }

}
