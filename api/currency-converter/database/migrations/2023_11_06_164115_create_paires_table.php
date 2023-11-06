<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paire', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('devise_source_id');
            $table->unsignedBigInteger('devise_cible_id');
            $table->float('taux');
            $table->integer('nombre_conversions')->default(0);

            $table->foreign('devise_source_id')->references('id')->on('devises');
            $table->foreign('devise_cible_id')->references('id')->on('devises');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paire');
    }
}
