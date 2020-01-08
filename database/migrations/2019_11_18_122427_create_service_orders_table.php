<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string("customer_name");
            $table->string("unit");
            $table->date("date_in");
            $table->date("date_out")->nullable();
            $table->enum("status", ['lunas', 'belum lunas'])->nullable()->default('belum lunas');
            $table->integer("dp");
            $table->integer("total_price")->nullable();
            $table->integer("pay")->nullable();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('service_orders');
    }
}
