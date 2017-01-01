<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('organization_classifications', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->timestamps();
      });

      Schema::create('organizations', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('parent_id')->unsigned()->nullable()->index();
        $table->integer('classification_id')->unsigned()->nullable()->index();
        $table->foreign('classification_id')->references('id')->on('organization_classifications')->onDelete('cascade');
        $table->string('name');
        $table->string('altName')->nullable();
        $table->string('formerName')->nullable();
        $table->string('identifier')->nullable();
        $table->text('description')->nullable();
        $table->string('image')->nullable();
        $table->date('foundAt')->nullable();
        $table->date('dissolutedAt')->nullable();
        $table->string('link')->nullable();
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
      Schema::drop('organizations');
      Schema::drop('organization_classifications');
    }
}
