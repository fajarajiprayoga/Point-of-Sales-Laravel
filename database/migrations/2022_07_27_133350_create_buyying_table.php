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
        Schema::create('buyying', function (Blueprint $table) {
            $table->increments('id_buyying');
            $table->integer('id_supplier');
            $table->integer('item_total');
            $table->integer('price_total');
            $table->tinyInteger('discount')->default(0);
            $table->integer('bayar')->default(0);
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
        Schema::dropIfExists('buyying');
    }
};
