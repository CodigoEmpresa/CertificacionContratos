<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obligacion extends Model
{
    protected $table = 'obligacion';
    protected $primaryKey = 'Id';
    protected $fillable = ['Contrato_Id', 'Objeto_Obligacion'];

    public function contrato(){
        return $this->belongsTo('App\Models\Contrato', 'Contrato_Id');
    }
}
