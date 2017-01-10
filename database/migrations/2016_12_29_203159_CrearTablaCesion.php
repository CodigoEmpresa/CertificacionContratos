<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaCesion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('cesion', function (Blueprint $table) {

            $table->increments('Id');
            $table->integer('Contrato_Id')->unsigned();
            $table->integer('Numero_Cesion');
            $table->string('Nombre_Cesionario');
            $table->string('Cedula_Cesionario');
            $table->integer('Dv_Cesion');
            $table->integer('Valor_Cedido');
            $table->integer('Dias');
            $table->date('Fecha_Cesion');
            $table->timestamps();

            $table->foreign('Contrato_Id')->references('Id')->on('contrato');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cesion', function(Blueprint $table){
            $table->dropForeign('Contrato_Id');
        });    
        Schema::drop('cesion');
    }
}