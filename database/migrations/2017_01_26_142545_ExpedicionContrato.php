<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExpedicionContrato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expedicion_contrato', function (Blueprint $table) {

            $table->increments('Id');
            $table->integer('Contrato_Id')->unsigned();
            $table->string('Nombre_Expedicion');
            $table->integer('Conteo');
            $table->timestamps();

            //$table->foreign('Contrato_Id')->references('Id')->on('contrato');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expedicion_contrato', function(Blueprint $table){
            //$table->dropForeign('Contrato_Id');
        });    
        Schema::drop('expedicion_contrato');
    }
}