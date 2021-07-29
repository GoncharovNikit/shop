<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            $table->char('vendorCode', 15)->unique();
            $table->unsignedDecimal('price', 8, 2);
            $table->longText('description_ru');
            $table->longText('description_uk');
            
            $table->unsignedBigInteger('metal_id');
            $table->unsignedBigInteger('category_id');
            
            $table->timestamp('created_at')->useCurrent();
            
            $table->foreign('metal_id')->references('id')->on('metals');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_sizes');
        Schema::dropIfExists('basket');
        Schema::dropIfExists('products');
    }
}
