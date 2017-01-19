<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaAdicion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('adicion', function (Blueprint $table) {

            $table->increments('Id');
            $table->integer('Contrato_Id')->unsigned();
            $table->integer('Numero_Adicion');
            $table->integer('Valor_Adicion');
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
        Schema::table('adicion', function(Blueprint $table){
            $table->dropForeign('Contrato_Id');
        });    
        Schema::drop('adicion');
    }
}