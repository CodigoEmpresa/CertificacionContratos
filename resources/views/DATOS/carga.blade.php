@extends('master')

@section('script')
    @parent
    <script src="{{ asset('public/Js/Datos/carga.js') }}"></script> 
    <script src="{{ asset('public/Js/bootstrap-datepicker.js') }}"></script>   
    {{Html::style('public/Css/bootstrap-datepicker3.css')}}   
    
    <style type="text/css">
        .botonX {width:150px;}
    </style>

    @stop

@section('content')
<!-- ------------------------------------------------------------------------------------ -->
<center><h3>CARGA MASIVA DE CONTRATOS</h3></center>
<input type="hidden" name="_token" value="{{csrf_token()}}" id="token"/>
<div id="main_persona" class="row" data-url="{{ url(config('usuarios.prefijo_ruta')) }}">  
    <div class="content">
        <form action="" id="CargaMasivaF">
            <div class="form-group col-xs-12 col-md-6">
                <div class="form-group">
                    <label for="exampleInputFile">Archivo para carga masiva</label>
                    <input type="file" name="ArchivoCM" id="ArchivoCM">
                    <p class="help-block">Archivo en formato xls.</p>
                 </div>
            </div>
            <button type="button" class="btn btn-primary" id="agregarArchivo">Cargar Archivo</button>
            <button type="button" class="btn btn-primary" id="NuevaCarga" style="display:none;">Nueva Carga</button>
            <div class="col-xs-12">
                <div class="panel-body" id="Esperar" style="display: none;">
                    <div class="container" id="loading" >
                        <center><button class="btn btn-lg btn-default"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Espere...</button></center>
                    </div>
               </div>
            </div>
            <div class="col-xs-12">
                <div id="mensaje_carga"></div>
            </div>            
        </form>              
    </div>
</div>                        
@stop