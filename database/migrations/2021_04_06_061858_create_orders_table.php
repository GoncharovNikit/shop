<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->decimal('total_price', 9, 2, true);
            $table->string('fullname');
            $table->string('phone');
            $table->unsignedBigInteger('payment_type_id');
            $table->unsignedBigInteger('delivery_type_id');
            $table->string('delivery_data');
            $table->string('remarks');
            $table->timestamps();

            $table->foreign('payment_type_id')->references('id')->on('payment_types');
            $table->foreign('delivery_type_id')->references('id')->on('delivery_types');
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
