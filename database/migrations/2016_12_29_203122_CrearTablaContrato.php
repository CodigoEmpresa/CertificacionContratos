<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaContrato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrato', function (Blueprint $table) {

            $table->increments('Id');
            $table->string('Cedula');
            $table->integer('Dv');
            $table->string('Nombre_Contratista');
            $table->string('Numero_Contrato');
            $table->integer('Tipo_Contrato_Id')->unsigned();
            $table->string('Nombre_Representante');
            $table->string('Cedula_Representante');
            $table->string('Objeto');
            $table->date('Fecha_Firma');
            $table->date('Fecha_Inicio');
            $table->date('Fecha_Fin');
            $table->date('Fecha_Terminacion_Anticipada');
            $table->integer('Meses_Duracion');
            $table->integer('Dias_Duracion');
            $table->string('Otra_Duracion');
            $table->integer('Valor_Inicial');
            $table->integer('Valor_Mensual');
            $table->date('fecha_Final_CTO');
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
        Schema::drop('contrato');
    }
}