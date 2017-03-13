<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adicion extends Model
{
    protected $table = 'adicion';
    protected $primaryKey = 'Id';
    protected $fillable = ['Contrato_Id', 'Numero_Adicion', 'Valor_Adicion'];

    public function contrato(){
        return $this->belongsTo('App\Models\Contrato', 'Contrato_Id');
    }
}
