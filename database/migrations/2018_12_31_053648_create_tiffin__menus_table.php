<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiffinMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiffin__menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tiffin_id');
            $table->string('lunch_desc');
            $table->string('dinner_desc');
            $table->integer('day')->unsigned(); // Min:1 | Max: 7
            $table->timestamps();

            $table->foreign('tiffin_id')->references('id')->on('tiffins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiffin__menus');
    }
}
