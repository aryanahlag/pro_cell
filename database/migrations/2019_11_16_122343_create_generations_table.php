<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenerationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->year('generation');
            $table->date('time')->nullable();
            $table->enum('status', ["verify", "unverify"])->nullable()->default("unverify");
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
        Schema::dropIfExists('generations');
    }
}
