<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suspencion extends Model
{
    protected $table = 'suspencion';
    protected $primaryKey = 'Id';
    protected $fillable = ['Contrato_Id', 'Numero_Suspencion', 'Objeto_Suspension', 'Meses', 'Dias', 'Fecha_Inicio', 'Fecha_Fin', 'Fecha_Reinicio', 'Fecha_Fin_CTO'];

    public function contrato(){
        return $this->belongsTo('App\Models\Contrato', 'Contrato_Id');
    }
}
