<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $table = 'contrato';
    protected $primaryKey = 'Id';
    protected $fillable = ['Tipo_Documento', 'Cedula', 'Div', 'Nombre_Contratista', 'Numero_Contrato', 'Tipo_Contrato_Id', 'Nombre_Representante', 'Cedula_Representante', 'Objeto',
    					   'Fecha_Firma', 'Fecha_Inicio', 'Fecha_Fin', 'Fecha_Terminacion_Anticipada', 'Meses_Duracion', 'Dias_Duracion', 'Otra_Duracion', 'Valor_Inicial',
    					   'Valor_Mensual', 'fecha_Final_CTO'];

    public function Tipocontrato(){
        return $this->belongsTo('App\Models\TipoContrato', 'Tipo_Contrato_Id');
    }

    public function Adicion(){
        return $this->hasMany('App\Models\Adicion', 'Contrato_Id');
    }

    public function Prorroga(){
        return $this->hasMany('App\Models\Prorroga', 'Contrato_Id');
    }

    public function Suspencion(){
        return $this->hasMany('App\Models\Suspencion', 'Contrato_Id');
    }

    public function Cesion(){
        return $this->hasMany('App\Models\Cesion', 'Contrato_Id');
    }

    public function Obligacion(){
        return $this->hasMany('App\Models\Obligacion', 'Contrato_Id');
    }

    public function TipoDocumento(){
        return $this->belongsTo('App\Models\TipoDocumento', 'Tipo_Documento');
    }

    public function ExpedicionContrato(){
        return $this->hasMany('App\Models\ExpedicionContrato', 'Contrato_Id');
    }
}
