<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prorroga extends Model
{
    protected $table = 'prorroga';
    protected $primaryKey = 'Id';
    protected $fillable = ['Contrato_Id', 'Numero_Prorroga', 'Meses', 'Dias', 'Fecha_Fin'];

    public function contrato(){
        return $this->belongsTo('App\Models\Contrato', 'Contrato_Id');
    }
}
