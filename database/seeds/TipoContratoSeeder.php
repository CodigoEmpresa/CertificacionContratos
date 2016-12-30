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
            ['Nombre_Tipo_Contrato' => 'Ejm 1'],
            ['Nombre_Tipo_Contrato' => 'Ejm 2'],
            ['Nombre_Tipo_Contrato' => 'Ejm 3'],
        ]);
    }
}
