<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->integer('id_category')->unsigned()->unique();
            $table->primary('id_category');
            $table->unsignedInteger('id_site')->nullable();
            $table->string('name');
            $table->unsignedInteger('id_parent')->nullable();
            $table->boolean('child');
            $table->boolean('selectable')->default(false);
            $table->timestamps();

            $table->foreign('id_parent')->references('id_category')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
