<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basket', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->char('product_vendorCode', 15);

            $table->unsignedBigInteger('size_id')->nullable();
            $table->foreign('size_id')->on('sizes')->references('id')->onDelete('cascade');

            $table->unsignedInteger('count');

            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('product_vendorCode')->on('products')->references('vendorCode')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('basket');
    }
}
