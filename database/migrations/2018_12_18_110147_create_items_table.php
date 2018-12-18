<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('id_item');
            $table->integer('id_country');
            $table->integer('id_category');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('personal_reference');
            $table->text('description');
            $table->integer('price_starting')->nullable();
            $table->integer('fixed_price')->nullable();
            $table->integer('price_present')->nullable();
            $table->integer('price_increment')->nullable();
            $table->string('currency')->default('EUR');
            $table->date('date_end');
            $table->integer('duration');
            $table->integer('renew');
            $table->integer('bids')->default(0);
            $table->boolean('option_boldtitle')->default(false);
            $table->boolean('option_coloredborder')->default(false);
            $table->boolean('option_highlight')->default(false);
            $table->boolean('option_keepoptionsonrenewal')->default(false);
            $table->boolean('option_lastminutebidding')->default(false);
            $table->boolean('option_privatebidding')->default(false);
            $table->boolean('option_subtitle')->default(false);
            $table->boolean('option_topcategory')->default(false);
            $table->boolean('option_toplisting')->default(false);
            $table->boolean('option_topmain')->default(false);
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
        Schema::dropIfExists('items');
    }
}
