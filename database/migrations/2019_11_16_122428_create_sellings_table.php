<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantity');
            $table->enum("type", ['grosir', 'satuan'])->nullable()->default('satuan');
            $table->integer('sub_total');

            // $table->unsignedInteger('stock_distribution_id');
            // $table->foreign('stock_distribution_id')->references('id')->on('stock_distributions')->onDelete('cascade');

            $table->string('code_stock', 15);
            $table->foreign('code_stock')->references('code')->on('stocks')->onDelete('cascade');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

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
        Schema::dropIfExists('sellings');
    }
}
