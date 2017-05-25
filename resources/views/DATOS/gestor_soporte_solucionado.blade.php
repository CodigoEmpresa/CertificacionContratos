@extends('master')

@section('script')
    @parent
    <script src="{{ asset('public/Js/Datos/gestor_soporte_solucionado.js') }}"></script> 
    <script src="{{ asset('public/Js/bootstrap-datepicker.js') }}"></script>   
    {{Html::style('public/Css/bootstrap-datepicker3.css')}}   
    
    <style type="text/css">
        .botonX {width:150px;}
    </style>

    @stop

@section('content')
<!-- ------------------------------------------------------------------------------------ -->
<center><h3>SOPORTES SOLUCIONADOS</h3></center>
<input type="hidden" name="_token" value="{{csrf_token()}}" id="token"/>
<div id="main_persona" class="row" data-url="{{ url(config('usuarios.prefijo_ruta')) }}">  
    <div class="content">
        <div class="panel-body">
            <li class="list-group-item">
                <div class="row">  
                    <div id="DatosDiv"></div>      
                </div>   
            </li>
        </div>      
    </div>
     <div class="modal fade bs-example-modal-lg" id="SolucionarD" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="myModalLabel">SOPORTE</h3>
                 </div>
                <form id="respondeSoporteF" name="respondeSoporteF">  
                    <input type="hidden" name="Soporte_Id" id="Soporte_Id">
                    <div class="content">
                        <div class="panel">                                               
                            <ul class="list-group" id="seccion_uno" name="seccion_uno">
                               <li class="list-group-item">
                                    <h4 class="modal-title" id="myModalLabel">Solución al soporte</h4>
                                    <br>
                                    <div class="row" id="Peticion" name="Peticion">
                                    </div>
                                    <div class="row">                                       
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail" class="control-label">Solución al soporte</label>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <textarea class="form-control"  placeholder="Digite la solución" id="SolucionText" name="SolucionText"></textarea>
                                        </div>
                                    </div>
                                    <div class="row" align="center">       
                                        <div class="form-group col-md-12">
                                            <button type="button" class="btn btn-success" id="SolucionarB" name="SolucionarB">Solucionar</button>
                                        </div>
                                    </div>
                                    <div class="row" id="MensajeSoporte" name="MensajeSoporte"></div>
                                    <div class="row" id="Esperar" style="display: none;">
                                        <div id="loading" >
                                            <center>
                                                <button class="btn btn-lg btn-default">
                                                    <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>
                                                     Espere...
                                                </button>
                                            </center>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>    


<div class="modal fade bs-example-modal-lg" id="VerSolucionarD" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="myModalLabel">VER SOPORTE</h3>
                 </div>
                <form id="respondeSoporteF" name="respondeSoporteF">  
                    <input type="hidden" name="Soporte_Id" id="Soporte_Id">
                    <div class="content">
                        <div class="panel">                                               
                            <ul class="list-group" id="seccion_uno" name="seccion_uno">
                               <li class="list-group-item">
                                    <h4 class="modal-title" id="myModalLabel">Ver Soporte</h4>
                                    <br>
                                    <div class="row">                                      
                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Fecha de Soporte</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" disabled="disabled" class="form-control"  id="FechaV" name="FechaV">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Estado de Soporte</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" disabled="disabled" class="form-control"  id="EstadoV" name="EstadoV">
                                        </div>
                                    </div>

                                    <div class="row">                                      
                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Nombre del solicitante</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" disabled="disabled" class="form-control"  id="NombreV" name="NombreV">
                                        </div>                                      
                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Documento del solicitante</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" disabled="disabled" class="form-control"  id="DocumentoV" name="DocumentoV">
                                        </div>
                                    </div>

                                    <div class="row">                                      
                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Correo del solicitante</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" disabled="disabled" class="form-control"  id="CorreoV" name="CorreoV">
                                        </div>
                                    </div>
                                    <div class="row">                                      
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail" class="control-label">Descripción del soporte</label>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <textarea disabled="disabled" class="form-control"  id="DescripcionV" name="DescripcionV"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">                                      
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail" class="control-label">Solución del soporte</label>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <textarea disabled="disabled" class="form-control"  id="SolucionV" name="SolucionV"></textarea>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>    
@stop