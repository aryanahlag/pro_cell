<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 15);
            $table->string('name');
            $table->integer('price');
            $table->integer('quantity');
            $table->text('information')->nullable();
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            // $table->foreign('category_id')->reference('id')->on('categories');
            $table->unsignedInteger('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            // $table->foreign('brand_id')->reference('id')->on('brands');
            $table->unsignedInteger('buying_id');
            $table->foreign('buying_id')->references('id')->on('buyings')->onDelete('cascade');
            // $table->foreign('buying_id')->reference('id')->on('buyings');
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
        Schema::dropIfExists('stocks');
    }
}
