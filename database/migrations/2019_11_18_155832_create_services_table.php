<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            // $table->string("customer_name");
            // $table->string("unit");
            // $table->date("date_in");
            // $table->date("date_out")->nullable();
            // $table->enum("status", ['lunas', 'belum lunas'])->nullable()->default('belum lunas');
            // $table->integer("dp");
            // $table->integer("total_price")->nullable();
            // $table->integer("pay")->nullable();
            // $table->integer("change")->nullable();
            // $table->unsignedInteger('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('quantity');
            $table->unsignedInteger('stock_distribution_id');
            $table->foreign('stock_distribution_id')->references('id')->on('stock_distributions')->onDelete('cascade');
            $table->unsignedInteger('service_order_id');
            $table->foreign('service_order_id')->references('id')->on('service_orders')->onDelete('cascade');
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
        Schema::dropIfExists('services');
    }
}
