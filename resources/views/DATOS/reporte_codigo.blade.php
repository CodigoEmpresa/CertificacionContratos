@extends('master')

@section('script')
    @parent
    <script src="{{ asset('public/Js/Datos/reporte_codigo.js') }}"></script> 
    <script src="{{ asset('public/Js/bootstrap-datepicker.js') }}"></script>   
    {{Html::style('public/Css/bootstrap-datepicker3.css')}}   
    
    <style type="text/css">
        .botonX {width:150px;}
    </style>

    @stop

@section('content')
<input type="hidden" name="_token" value="{{csrf_token()}}" id="token"/>
<div id="main_persona" class="row" data-url="{{ url(config('usuarios.prefijo_ruta')) }}">  
    <div class="content">
        <form id="reporteCodigoF" name="reporteCodigoF">  
            <div class="content">
                <div class="panel">                                               
                    <ul class="list-group">
                       <li class="list-group-item">
                            <div class="row">                     
                                <center><h3>REPORTE Y BÚSQUEDA POR CÓDIGO DE EXPEDICIÓN</h3></center>
                            </div>
                            <br><br>
                            <div class="row">                                        
                               <div class="form-group col-md-2">
                                    <label for="inputEmail" class="control-label">Código de Expedición:</label>
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="text" class="form-control"  placeholder="Parte 1" id="Codigo1" name="Codigo1">
                                </div> 
                                <div class="form-group col-md-2">
                                    <input type="text" class="form-control"  placeholder="Parte 2" id="Codigo2" name="Codigo2">
                                </div> 
                                <div class="form-group col-md-2">
                                    <input type="text" class="form-control"  placeholder="Parte 3" id="Codigo3" name="Codigo3">
                                </div> 

                                <div class="form-group col-md-4">
                                    <button type="button" class="btn btn-primary" name="GenerarReporte" id="GenerarReporte">
                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>Buscar
                                    </button>
                                </div>
                            </div>                            
                            <br>
                            <div id="mensaje"></div>
                            <br>
                            <div class="row" id="VariosD" style="display:none;">                              
                            </div>
                        </li>
                    </ul>                    
                </div>
            </div>
        </form>
    </div>
</div>                        
@stop