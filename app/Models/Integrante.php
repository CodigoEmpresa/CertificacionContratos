<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Integrante extends Model
{
    protected $table = 'integrante';
    protected $primaryKey = 'Id';
    protected $fillable = ['Contrato_Id', 'Nombre_Integrante', 'Tipo_Documento_Integrante_Id', 'Documento_Integrante', 'Porcentaje_Integrante'];

    public function contrato(){
        return $this->belongsTo('App\Models\Contrato', 'Contrato_Id');
    }
}