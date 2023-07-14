<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBottleInCellarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bottle_in_cellars', function (Blueprint $table) {
            $table->id()->notNullable();
            $table->unsignedBigInteger('bottle_id');
            $table->unsignedBigInteger('cellar_id');
            $table->unsignedInteger('quantity')->notNullable();
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
        Schema::dropIfExists('bottle_in_cellars');
    }
}
