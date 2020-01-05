<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockDistributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_distributions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cabang_id');
            $table->foreign('cabang_id')->references('id')->on('cabangs')->onDelete('cascade');
            $table->unsignedInteger('stock_id');
            $table->foreign('stock_id')->references('id')->on('stocks')->onDelete('cascade');
            $table->integer('quantity');
            $table->integer('price_sell')->nullable();
            $table->integer('price_grosir');
            $table->enum('status', ['submission', 'accepted', 'rejected', 'shipment']);
            $table->text('information')->nullable();
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
        Schema::dropIfExists('stock_distributions');
    }
}
