@extends('master')

@section('script')
    @parent
    <script src="{{ asset('public/Js/Datos/reporte_expedicion.js') }}"></script> 
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
        <form id="reporteExpedicionF" name="reporteExpedicionF">  
            <div class="content">
                <div class="panel">                                               
                    <ul class="list-group">
                       <li class="list-group-item">
                            <div class="row">                     
                                <center><h3>REPORTE DE EXPEDICIÓN DE CERTIFICACIÓN DE CONTRATOS</h3></center>
                            </div>
                            <br><br>
                            <div class="row">                                        
                               <div class="form-group col-md-1">
                                    <label for="inputEmail" class="control-label">Fecha Inicio:</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="input-group date form-control" id="FechaInicioDate" style="border: none;">
                                        <input id="FechaInicio" class="form-control " type="text" value="" name="FechaInicio" default="" data-date="" data-behavior="FechaInicio">
                                    <span class="input-group-addon btn"><i class="glyphicon glyphicon-calendar"></i> </span>
                                    </div>  
                                </div> 

                                <div class="form-group col-md-1">
                                    <label for="inputEmail" class="control-label">Fecha Fin:</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="input-group date form-control" id="FechaFinDate" style="border: none;">
                                        <input id="FechaFin" class="form-control " type="text" value="" name="FechaFin" default="" data-date="" data-behavior="FechaFin">
                                    <span class="input-group-addon btn"><i class="glyphicon glyphicon-calendar"></i> </span>
                                    </div>  
                                </div>

                                <div class="form-group col-md-4">
                                    <button type="button" class="btn btn-primary" name="GenerarReporte" id="GenerarReporte">
                                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>Generar Reporte
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