<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unique();
            $table->integer('tiffin_id')->unique();
            $table->integer('no_of_tiffin')->default(1);
            $table->boolean('is_lunch')->default(false);
            $table->boolean('is_dinner')->default(false);
            $table->decimal('price',3,2);
            $table->decimal('total_amount',4,2); // Price * No_Of_Tiffins
            $table->integer('status')->default(0); // [0 => undelivered, 1 => delivered] 
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
        Schema::dropIfExists('orders');
    }
}
