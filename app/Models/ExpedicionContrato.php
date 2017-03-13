<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpedicionContrato extends Model
{
     protected $table = 'expedicion_contrato';
    protected $primaryKey = 'Id';
    protected $fillable = ['Contrato_Id', 'Nombre_Expedicion', 'Conteo'];

    public function contrato(){
        return $this->belongsTo('App\Models\Contrato', 'Contrato_Id');
    }
}
