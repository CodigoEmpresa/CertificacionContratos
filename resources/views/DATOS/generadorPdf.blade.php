@extends('master')

@section('script')
    @parent
    <script src="{{ asset('public/Js/Datos/generador.js') }}"></script> 
    <script src="{{ asset('public/Js/bootstrap-datepicker.js') }}"></script>   
    {{Html::style('public/Css/bootstrap-datepicker3.css')}}   
    
    <style type="text/css">
        .botonX {width:150px;}
    </style>

    @stop

@section('content')
<!-- ------------------------------------------------------------------------------------ -->
<input type="hidden" name="_token" value="{{csrf_token()}}" id="token"/>
<div id="main_persona" class="row" data-url="{{ url(config('usuarios.prefijo_ruta')) }}">  
    <div class="content">
        <form id="generarPdf" name="generarPdf">  
            <div class="content">
                <div class="panel">                                               
                    <ul class="list-group">
                       <li class="list-group-item">
                            <div class="row">                     
                                <center><h3>EXPEDICIÓN DE CERTIFICADOS DE CONTRATISTAS, PERSONAS NATURALES Y JURÍDICAS</h3></center>
                                <br>
                                <justify>
                                    <p>
                                        Para la solicitud del certificado debe seleccionar el tipo de documento, a continuación digite el número de identificación (En dado caso que sea una empresa especifíquelo colocando el NIT sin el número de verificación), y por último el año del contrato.
                                    </p>
                                </justify>
                            </div>
                            <br><br>
                            <div class="row">                                        
                                <div class="form-group col-md-1">
                                    <label for="inputEmail" class="control-label">Tipo de documento:</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <select name="Tipo_Documento" id="Tipo_Documento" class="form-control">
                                        <option value="">Seleccionar</option>   
                                        @foreach($TipoDocumento as $TipoDocumentos)
                                            <option value="{{ $TipoDocumentos['Id_TipoDocumento'] }}">{{ $TipoDocumentos['Descripcion_TipoDocumento'] }}</option>                                                    
                                        @endforeach                   
                                    </select>
                                </div>                                    

                                <div class="form-group col-md-1">
                                    <label id="Numero_Cedula_Inicial" for="inputEmail" class="control-label">Número documento:</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="text" class="form-control"  placeholder="Número de documento" id="Documento" name="Documento">
                                </div>

                                <div class="form-group col-md-1">
                                    <label for="inputEmail" class="control-label">Año contrato:</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="input-group date form-control" id="AnioDate" style="border: none;">
                                        <input id="Anio" class="form-control " type="text" value="" name="Anio" default="" data-date="" data-behavior="Anio">
                                    <span class="input-group-addon btn"><i class="glyphicon glyphicon-calendar"></i> </span>
                                    </div>  
                                </div>
                            </div>                            
                            <br>
                            <div align="right">
                                <button type="button" class="btn btn-primary" name="Expedir" id="Expedir">
                                    <span class="glyphicon glyphicon-circle-arrow-down" aria-hidden="true"></span> Expedir virtualmente
                                </button>
                            </div>
                            <div id="mensaje"></div>
                            <br>
                            <div class="row" id="VariosD" style="display:none;">
                                <table id="TablaVarios" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>CÉDULA</th>                        
                                            <th>CONTRATISTA</th>
                                            <th>N° DE CONTRATO</th>
                                            <th>AÑO DE CONTRATO</th>
                                            <th>DESCARGAR</th>
                                        </tr>
                                    </thead>
                                    <tbody id="RegistrosVarios">                                                    
                                    </tbody> 
                                </table>
                            </div>
                        </li>
                    </ul>                    
                </div>
            </div>
        </form>
    </div>
</div>                        
@stop