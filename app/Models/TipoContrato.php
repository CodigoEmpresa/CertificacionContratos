<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoContrato extends Model
{
    protected $table = 'tipo_contrato';
    protected $primaryKey = 'Id';
    protected $fillable = ['Nombre_Tipo_Contrato'];

    public function Contrato(){
        return $this->hasMany('App\Models\Contrato', 'Tipo_Contrato_Id');
    }
}
