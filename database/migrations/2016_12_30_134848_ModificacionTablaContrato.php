<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificacionTablaContrato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('contrato', function(Blueprint $table){                 
            $table->foreign('Tipo_Contrato_Id')->references('Id')->on('tipo_contrato');
        });        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contrato', function(Blueprint $table){
            $table->dropForeign('Tipo_Contrato_Id');
        });        
    }
}
