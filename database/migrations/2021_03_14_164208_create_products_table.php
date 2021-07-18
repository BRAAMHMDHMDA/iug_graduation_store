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
            $table->string('name')->unique();
            $table->unsignedBigInteger('category_id');
            $table->string('main_image');
            $table->float('purchase_price')->unsigned();
            $table->float('sale_price')->unsigned();
            $table->integer('stock')->unsigned();
            $table->string('short_description');
            $table->text('long_description');
            $table->boolean('status')->default(0);
            $table->decimal('discount','5','2')->default('0')->unsigned();
            $table->timestamps();

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
        Schema::dropIfExists('products');
    }
}
