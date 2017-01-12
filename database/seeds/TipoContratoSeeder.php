<?php

use Illuminate\Database\Seeder;

class TipoContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_contrato')->delete();        
        DB::table('tipo_contrato')->insert([
            ['Nombre_Tipo_Contrato' => 'CONTRATO DE PRESTACION DE SERVICIOS'],
            ['Nombre_Tipo_Contrato' => 'CONTRATO DE PRESTACION DE SERVICIOS PROFESIONALES'],
            ['Nombre_Tipo_Contrato' => 'CONTRATO DE PRESTACION DE SERVICIOS DE APOYO A LA GESTIÓN'],
            ['Nombre_Tipo_Contrato' => 'CONTRATO DE COMODATO'],
            ['Nombre_Tipo_Contrato' => 'CONTRATO CONVENIO DE ASOCIACIÓN'],
            ['Nombre_Tipo_Contrato' => 'CONTRATO DE APROVECHAMIENTO ECONOMICO'],
            ['Nombre_Tipo_Contrato' => 'CONTRATO DE COMISION - TRANSPORTE'],
            ['Nombre_Tipo_Contrato' => 'CONTRATO DE COMPRA VENTA'],
            ['Nombre_Tipo_Contrato' => 'CONTRATO DE CONCESION'],
            ['Nombre_Tipo_Contrato' => 'CONTRATO DE CONSULTORIA'],
            ['Nombre_Tipo_Contrato' => 'CONTRATO DE DONACION'],
            ['Nombre_Tipo_Contrato' => 'CONTRATO DE INTERVENTORIA'],
            ['Nombre_Tipo_Contrato' => 'CONTRATO DE OBRA'],
            ['Nombre_Tipo_Contrato' => 'CONTRATO DE OBRA PÚBLICA'],
            ['Nombre_Tipo_Contrato' => 'CONTRATO DE PAGO DE DERECHOS CONEXOS DE AUTOR'],
            ['Nombre_Tipo_Contrato' => 'CONTRATO DE PRESTACION DE MANTENIMIENTO'],
            ['Nombre_Tipo_Contrato' => 'CONTRATO DE SEGUROS'],
            ['Nombre_Tipo_Contrato' => 'CONTRATO DE SUMINISTRO'],
            ['Nombre_Tipo_Contrato' => 'CONTRATO DE SUSCRIPCION'],
            ['Nombre_Tipo_Contrato' => 'CONTRATO INTERADMINISTRATIVO'],
            ['Nombre_Tipo_Contrato' => 'CONTRATO PRESTACION DE SERVICIOS-PROVEEDOR EXCLUSIVO'],
            ['Nombre_Tipo_Contrato' => 'CONTRATO PRESTACION DE SERVICIOS ARTISTICOS'],
            ['Nombre_Tipo_Contrato' => 'CONVENIO DE ASOCIACION'],
            ['Nombre_Tipo_Contrato' => 'CONVENIO INTERADMINISTRATIVO'],
            ['Nombre_Tipo_Contrato' => 'CONVENIO DE COOPERACION'],
            ['Nombre_Tipo_Contrato' => 'CONVENIO INTERADMINISTRATIVO DE COOPERACION '],
            ['Nombre_Tipo_Contrato' => 'CONVENIO INTERADMINISTRATIVO DE COMODATO'],
            ['Nombre_Tipo_Contrato' => 'INTERMEDIACION DE SEGUROS'],
            ['Nombre_Tipo_Contrato' => 'ORDEN DE COMPRA'],
            ['Nombre_Tipo_Contrato' => 'ORDEN DE COMPRA-ACUERDO MARCO'],
            ['Nombre_Tipo_Contrato' => 'ORDEN DE COMPRAVENTA'],
        ]);
    }
}
