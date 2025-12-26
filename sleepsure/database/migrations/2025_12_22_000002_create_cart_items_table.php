<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cart_id');
            $table->string('product_id', 100);
            $table->string('variant_id', 100)->nullable();
            $table->string('thickness_id', 20)->nullable();
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();

            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('product_information')->onDelete('cascade');
            $table->foreign('variant_id')->references('id')->on('product_variants')->onDelete('set null');
            $table->foreign('thickness_id')->references('thickness_id')->on('product_thickness')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
};
