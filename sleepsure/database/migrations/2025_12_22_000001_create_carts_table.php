<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('customer_id', 250)->nullable();
            $table->string('session_id', 255)->nullable();
            $table->string('status', 50)->default('active');
            $table->timestamps();

            $table->foreign('customer_id')->references('customer_id')->on('customer_information')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts');
    }
};
