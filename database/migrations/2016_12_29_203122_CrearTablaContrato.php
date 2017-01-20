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
            $table->integer('Tipo_Documento');
            $table->string('Cedula');
            $table->integer('Dv')->nullable();
            $table->string('Nombre_Contratista');
            $table->string('Numero_Contrato');
            $table->integer('Tipo_Contrato_Id')->unsigned();
            $table->string('Nombre_Representante')->nullable();
            $table->integer('Tipo_Documento_Representante')->nullable();
            $table->string('Cedula_Representante')->nullable();
            $table->string('Objeto');
            $table->date('Fecha_Firma');
            $table->date('Fecha_Inicio');
            $table->date('Fecha_Fin');
            $table->date('Fecha_Terminacion_Anticipada')->nullable();
            $table->integer('Meses_Duracion');
            $table->integer('Dias_Duracion');
            $table->string('Otra_Duracion')->nullable();
            $table->integer('Valor_Inicial');
            $table->integer('Valor_Mensual');
            //$table->date('fecha_Final_CTO');
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