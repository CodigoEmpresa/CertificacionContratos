<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaObligacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obligacion', function (Blueprint $table) {

            $table->increments('Id');
            $table->integer('Contrato_Id')->unsigned();
            $table->integer('Numero_Obligacion');
            $table->string('Objeto_Obligacion');
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
        Schema::table('obligacion', function(Blueprint $table){
            $table->dropForeign('Contrato_Id');
        });    
        Schema::drop('obligacion');
    }
}