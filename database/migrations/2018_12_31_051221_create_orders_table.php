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
            $table->integer('customer_id')->unsigned();
            $table->integer('provider_id')->unsigned();
            $table->integer('tiffin_id');
            $table->integer('no_of_tiffin')->default(1);
            $table->boolean('is_lunch')->default(false);
            $table->boolean('is_dinner')->default(false);
            $table->decimal('price',10,2);
            $table->decimal('total_amount',10,2); // Price * No_Of_Tiffins
            $table->integer('status')->default(0); // [0 => undelivered, 1 => delivered] 
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');
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
