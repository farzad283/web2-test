<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBottlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wine_bottles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->nullable();
            $table->string('image', 200)->nullable();
            $table->string('code_saq', 50)->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->string('description', 200)->nullable();
            $table->float('price')->nullable();
            $table->string('url_saq', 200)->nullable();
            $table->string('url_image', 200)->nullable();
            $table->string('format', 20)->nullable();
            $table->year('vintage')->nullable();
            $table->foreign('type_id')->references('id')->on('types');
            $table->foreign('country_id')->references('id')->on('countries');
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
        Schema::dropIfExists('bottles');
    }
}
