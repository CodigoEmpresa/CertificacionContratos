<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaSuspencion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suspencion', function (Blueprint $table) {

            $table->increments('Id');
            $table->integer('Contrato_Id')->unsigned();
            $table->integer('Numero_Suspencion');
            //$table->string('Objeto_Suspension');
            $table->integer('Meses');
            $table->integer('Dias');
            $table->date('Fecha_Inicio');
            $table->date('Fecha_Fin');
            $table->date('Fecha_Reinicio');
            $table->date('Fecha_Fin_CTO');
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
        Schema::table('suspencion', function(Blueprint $table){
            $table->dropForeign('Contrato_Id');
        });    
        Schema::drop('suspencion');
    }
}