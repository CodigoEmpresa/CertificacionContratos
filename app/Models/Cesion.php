<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cesion extends Model
{
    protected $table = 'cesion';
    protected $primaryKey = 'Id';
    protected $fillable = ['Contrato_Id', 'Numero_Cesion', 'Nombre_Cesionario', 'Tipo_Documento_Cesionario', 'Cedula_Cesionario', 'Dv_Cesion', 'Valor_Cedido', 'Dias', 'Fecha_Cesion'];

    public function contrato(){
        return $this->belongsTo('App\Models\Contrato', 'Contrato_Id');
    }
    public function TipoDocumento(){
        return $this->belongsTo('App\Models\TipoDocumento', 'Tipo_Documento_Cesionario');
    }
}
