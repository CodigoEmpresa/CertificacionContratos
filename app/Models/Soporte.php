<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soporte extends Model
{
    protected $table = 'soporte';
    protected $primaryKey = 'Id';
    protected $fillable = ['Tipo_Documento_Solicitante_Id', 'Nombre_Solicitante', 'Documento_Solicitante', 'Correo_Solicitante', 'Descripcion_Solicitud', 'Estado'];

    public function tipo_documento(){
        return $this->belongsTo('App\Models\TipoDocumento', 'Tipo_Documento_Solicitante_Id');
    }
}
