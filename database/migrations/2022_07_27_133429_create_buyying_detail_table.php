<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyying_detail', function (Blueprint $table) {
            $table->increments('id_buyying_detail');
            $table->integer('id_buyying');
            $table->integer('id_product');
            $table->integer('buy_price');
            $table->integer('count');
            $table->integer('subtotal');
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
        Schema::dropIfExists('buyying_detail');
    }
};
