<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaIntegrante extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integrante', function (Blueprint $table) {

            $table->increments('Id');
            $table->integer('Contrato_Id')->unsigned();
            $table->string('Nombre_Integrante');
            $table->integer('Tipo_Documento_Integrante_Id');
            $table->string('Documento_Integrante');
            $table->string('Porcentaje_Integrante');
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
        Schema::table('integrante', function(Blueprint $table){
            //$table->dropForeign('Contrato_Id');
        });    
        Schema::drop('integrante');
    }
}