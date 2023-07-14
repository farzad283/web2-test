<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBottleConsumedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bottles_consumed', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bottle_id');
            $table->unsignedBigInteger('cellar_id');
            $table->date('consumption_date')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->foreign('cellar_id')->references('id')->on('cellars');
            $table->foreign('bottle_id')->references('id')->on('wine_bottles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bottle_consumeds');
    }
}
