<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->integer('custom_length')->nullable()->after('thickness_id');
            $table->integer('custom_breadth')->nullable()->after('custom_length');
        });
    }

    public function down()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn(['custom_length', 'custom_breadth']);
        });
    }
};
