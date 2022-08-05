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
        Schema::create('selling_detail', function (Blueprint $table) {
            $table->increments('id_selling_detail');
            $table->integer('id_selling');
            $table->integer('id_product');
            $table->integer('sell_price');
            $table->integer('count');
            $table->tinyInteger('discount')->default(0);
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
        Schema::dropIfExists('selling_detail');
    }
};
