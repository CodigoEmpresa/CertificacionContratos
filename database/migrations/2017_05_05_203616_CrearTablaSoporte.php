<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaSoporte extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('soporte', function (Blueprint $table) {

            $table->increments('Id');
            $table->integer('Tipo_Documento_Solicitante_Id')->unsigned();
            $table->string('Nombre_Solicitante');
            $table->string('Documento_Solicitante');
            $table->string('Correo_Solicitante');
            $table->longText('Descripcion_Solicitud');
            $table->string('Estado'); //1->Abierto // 2->Solucionado
            $table->longText('Solucion');
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
        Schema::drop('soporte');
    }
}