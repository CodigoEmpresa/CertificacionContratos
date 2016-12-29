<?php

return array( 
 
  'conexion' => 'db_principal', 
   
  'prefijo_ruta' => 'personas', 
 
  'modelo_persona' => 'App\Models\Persona', 
  'modelo_documento' => 'App\Models\Documento', 
  'modelo_pais' => 'App\Models\Pais', 
  'modelo_ciudad' => 'App\Models\Ciudad', 
  'modelo_genero' => 'App\Models\Genero', 
  'modelo_etnia' => 'App\Models\Etnia', 
  'modelo_tipo' => 'App\Models\Tipo', 
   
  //vistas que carga las vistas 
  'vista_lista' => 'list', 
 
  //lista 
  'lista'  => 'idrd.usuarios.lista', 
);