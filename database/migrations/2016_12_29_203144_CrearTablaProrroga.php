<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaProrroga extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prorroga', function (Blueprint $table) {

            $table->increments('Id');
            $table->integer('Contrato_Id')->unsigned();
            $table->integer('Numero_Prorroga');
            $table->integer('Meses');
            $table->integer('Dias');
            $table->date('Fecha_Fin');
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
        Schema::table('prorroga', function(Blueprint $table){
            $table->dropForeign('Contrato_Id');
        });    
        Schema::drop('prorroga');
    }
}