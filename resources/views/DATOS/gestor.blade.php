@extends('master')

@section('script')
    @parent
    <script src="{{ asset('public/Js/Datos/gestor.js') }}"></script> 
    <script src="{{ asset('public/Js/bootstrap-datepicker.js') }}"></script>   
    {{Html::style('public/Css/bootstrap-datepicker3.css')}}   

    
    <style type="text/css">
        .botonX {width:150px;}
    </style>

    @stop

@section('content')
<!-- ------------------------------------------------------------------------------------ -->
<center><h3>GESTOR DE CONTRATOS</h3></center>
<input type="hidden" name="_token" value="{{csrf_token()}}" id="token"/>
<div id="main_persona" class="row" data-url="{{ url(config('usuarios.prefijo_ruta')) }}">  
    <div class="content">
        <br>
        <div align="right">
            <button type="button" class="btn btn-success" name="Enviar" id="Agregar_Contrato">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar contrato
            </button>
        </div>
        <br><br>            
        <div class="panel-body">
            <table id="datosTabla" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>CÉDULA</th>
                        <th>DV</th>
                        <th>CONTRATISTA</th>
                        <th>OPCIONES</th>
                    </tr>
                </thead>
                <tbody>    
                    @foreach($Contrato as $Contratos)
                        <tr>
                            <td>{{ $Contratos['Cedula']}}</td>
                            <td>{{ $Contratos['Dv'] }}</td>
                            <td>{{ $Contratos['Nombre_Contratista'] }}</td>
                            <td>                                
                                <button type="button" class="btn btn-info" value="{{$Contratos['Id']}}" >
                                    <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                                </button>

                                <button type="button" class="btn btn-primary" value="{{$Contratos['Id']}}" >
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </button>

                                <button type="button" class="btn btn-danger" value="{{$Contratos['Id']}}" >
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                </button>                                
                            </td>
                        </tr>
                    @endforeach                    
                </tbody> 
            </table>
            <!--<div class="container" id="loading" style="display:none;">
                <center><button class="btn btn-lg btn-default"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Espere...</button></center>
            </div>-->
        </div>
    </div>

    <!-- ------------------------------ MODAL REGISTRO DE CONTRATOS ----------------------------------------- -->
    <div class="modal fade bs-example-modal-lg" id="AgregarContratoD" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="myModalLabel">AGREGAR CONTRATO</h3>
                 </div>
                <form id="agregarContratoF" name="agregarContratoF">  
                    <div class="content">
                        <div class="panel">                                               
                            <ul class="list-group" id="seccion_uno" name="seccion_uno">
                               <li class="list-group-item">
                                    <h4 class="modal-title" id="myModalLabel">Datos Básicos</h4>
                                    <br>
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Número de cédula</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control"  placeholder="Número de Cédula" id="Cedula" name="Cedula">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Dv</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control"  placeholder="Número Dv" id="Dv" name="Dv">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Número de Contrato</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control"  placeholder="Número de Contrato" id="Numero_Contrato" name="Numero_Contrato">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Tipo de Contrato</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input class="form-control" type="hidden" name="Tipo_Contrato" id="Tipo_Contrato">     
                                            <select name="Evento_Id" id="Evento_Id" class="form-control">
                                                <option value="">Seleccionar</option>   
                                                @foreach($TipoContrato as $TipoContratos)
                                                    <option value="{{ $TipoContratos['Id'] }}">{{ $TipoContratos['Nombre_Tipo_Contrato'] }}</option>
                                                @endforeach                                                                                                   
                                            </select>                                            
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <h4 class="modal-title" id="myModalLabel">Datos del Representante Legal</h4>
                                    <br>
                                    <div class="row">                                        
                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Nombre Representante Legal</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control"  placeholder="Nombre Representante Legal" id="Nombre_Representante" name="Nombre_Representante">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Cédula Representante Legal</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control"  placeholder="Cédula Representante Legal" id="Cedula_Representante" name="Cedula_Representante">
                                        </div>
                                    </div>

                                    <div class="row">                                        
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail" class="control-label">Objeto del Contrato</label>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <textarea class="form-control"  placeholder="Objeto del Contrato" id="Objeto_Contrato" name="Objeto_Contrato"></textarea>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">  
                                    <h4 class="modal-title" id="myModalLabel">Datos de Fechas</h4>
                                    <br>                                  
                                    <div class="row">
                                       <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Fecha de Firma</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input-group date form-control" id="FechaFirmaDate" style="border: none;">
                                                <input id="FechaFirma" class="form-control " type="text" value="" name="FechaFirma" default="" data-date="" data-behavior="FechaFirma">
                                            <span class="input-group-addon btn"><i class="glyphicon glyphicon-calendar"></i> </span>
                                            </div>    
                                        </div> 

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Fecha de Inicio</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input-group date form-control" id="FechaInicioDate" style="border: none;">
                                                <input id="FechaInicio" class="form-control " type="text" value="" name="FechaInicio" default="" data-date="" data-behavior="FechaInicio">
                                            <span class="input-group-addon btn"><i class="glyphicon glyphicon-calendar"></i> </span>
                                            </div>    
                                        </div> 
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Fecha de Finalización</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input-group date form-control" id="FechaFinDate" style="border: none;">
                                                <input id="FechaFin" class="form-control " type="text" value="" name="FechaFin" default="" data-date="" data-behavior="FechaFin">
                                            <span class="input-group-addon btn"><i class="glyphicon glyphicon-calendar"></i> </span>
                                            </div>    
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Fecha de Terminación Anticipada</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input-group date form-control" id="FechaFinAnticipadoDate" style="border: none;">
                                                <input id="FechaFinAnticipado" class="form-control " type="text" value="" name="FechaFinAnticipado" default="" data-date="" data-behavior="FechaFinAnticipado">
                                            <span class="input-group-addon btn"><i class="glyphicon glyphicon-calendar"></i> </span>
                                            </div>    
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <h4 class="modal-title" id="myModalLabel">Datos de la Duración</h4>
                                    <br>
                                    <div class="row">                                        
                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Meses de Duración</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control"  placeholder="Meses de Duración" id="Meses_Duracion" name="Meses_Duracion">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Días de Duración</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control"  placeholder="Días de Duración" id="Dias_Duracion" name="Dias_Duracion">
                                        </div>
                                    </div>

                                    <div class="row">                                        
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail" class="control-label">Otra Forma de Duración Equivalente</label>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <textarea class="form-control"  placeholder="Forma de Duración" id="Otra_Duracion" name="Otra_Duracion"></textarea>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <h4 class="modal-title" id="myModalLabel">Datos de Valores</h4>
                                    <br>
                                    <div class="row">                                        
                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Valor Inicial</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control"  placeholder="Valor Inicial" id="Valor_Inicial" name="Valor_Inicial">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Valor Mensual</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control"  placeholder="Valor Mensual" id="Valor_Mensual" name="Valor_Mensual">
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">                                        
                                        <div class="form-group col-md-2">
                                            <h4 class="modal-title" id="myModalLabel">Adiciones</h4>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <button type="button" class="btn btn-info botonX" value="" name="NuevaAdicion" id="NuevaAdicion" >Nueva Adición</button>
                                        </div>
                                    </div>
                                    <div id="NuevaAdicionD" style="display:none;">                                        
                                        <div class="row">
                                            <!--<div class="form-group col-md-2">
                                                <label for="inputEmail" class="control-label">Número de Adición</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" class="form-control"  placeholder="Número Adición" id="Numero_Adicion" name="Numero_Adicion">
                                            </div>-->

                                            <div class="form-group col-md-12">
                                                <label for="inputEmail" class="control-label">Valor de Adición</label>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <input type="text" class="form-control"  placeholder="Valor Adición" id="Valor_Adicion" name="Valor_Adicion">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <center>
                                                <div class="form-group col-md-12">
                                                    <button type="button" class="btn btn-primary" value="" name="AgregarAdicion" id="AgregarAdicion" >Agregar Adición</button>
                                                </div>
                                            </center>   
                                        </div>
                                    </div>                                    
                                </li>
                                <li class="list-group-item">
                                    <div class="row">                                        
                                        <div class="form-group col-md-2">
                                            <h4 class="modal-title" id="myModalLabel">Prórrogas</h4>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <button type="button" class="btn btn-info botonX"  value="" name="NuevaProrroga" id="NuevaProrroga" >Nueva Prórroga</button>
                                        </div>
                                    </div>
                                    <div id="NuevaProrrogaD" style="display:none;">                                        
                                        <div class="row">
                                            <!--<div class="form-group col-md-2">
                                                <label for="inputEmail" class="control-label">Número de Prórroga</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" class="form-control"  placeholder="Número Prórroga" id="Numero_Prorroga" name="Numero_Prorroga">
                                            </div>-->

                                            <div class="form-group col-md-2">
                                                <label for="inputEmail" class="control-label">Duración Meses</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" class="form-control"  placeholder="Duración Meses" id="Meses_Prorroga" name="Meses_Prorroga">
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="inputEmail" class="control-label">Duración Días</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" class="form-control"  placeholder="Duración Días" id="Dias_Prorroga" name="Dias_Prorroga">
                                            </div>
                                        </div>
                                        <div class="row">
                                            
                                            <div class="form-group col-md-2">
                                                <label for="inputEmail" class="control-label">Fecha Fin CTO Prórroga</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <div class="input-group date form-control" id="FechaFinCtoProrrogaDate" style="border: none;">
                                                    <input id="FechaFinCtoProrroga" class="form-control " type="text" value="" name="FechaFinCtoProrroga" default="" data-date="" data-behavior="FechaFinCtoProrroga">
                                                <span class="input-group-addon btn"><i class="glyphicon glyphicon-calendar"></i> </span>
                                                </div>    
                                            </div>                                           
                                        </div>
                                        <div class="row">
                                            <center>
                                                <div class="form-group col-md-12">
                                                    <button type="button" class="btn btn-primary " value="" name="AgregarProrroga" id="AgregarProrroga" >Agregar Prórroga</button>
                                                </div>
                                            </center>   
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">                                        
                                        <div class="form-group col-md-2">
                                            <h4 class="modal-title" id="myModalLabel">Suspenciones</h4>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <button type="button" class="btn btn-info botonX" value="" name="NuevaSuspencion" id="NuevaSuspencion" >Nueva Suspención</button>
                                        </div>
                                    </div>
                                    <div id="NuevaSuspencionD" style="display:none;">                                        
                                        <div class="row">
                                            <div class="form-group col-md-2">
                                                <label for="inputEmail" class="control-label">Número de Suspención</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" class="form-control"  placeholder="Número Suspención" id="Numero_Suspencion" name="Numero_Suspencion">
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="inputEmail" class="control-label">Objeto Suspención</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <textarea class="form-control"  placeholder="Duración Meses" id="Meses_Prorroga" name="Meses_Prorroga"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-2">
                                                <label for="inputEmail" class="control-label">Duración Meses</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" class="form-control"  placeholder="Duración Meses" id="Meses_Suspencion" name="Meses_Suspencion">
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="inputEmail" class="control-label">Duración Días</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" class="form-control"  placeholder="Duración Días" id="Dias_Suspencion" name="Dias_Suspencion">
                                            </div>
                                        </div>                                        
                                        <div class="row">
                                            <div class="form-group col-md-2">
                                                <label for="inputEmail" class="control-label">Fecha Inicio</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <div class="input-group date form-control" id="FechaInicioSuspencionDate" style="border: none;">
                                                    <input id="FechaInicioSuspencion" class="form-control " type="text" value="" name="FechaInicioSuspencion" default="" data-date="" data-behavior="FechaInicioSuspencion">
                                                <span class="input-group-addon btn"><i class="glyphicon glyphicon-calendar"></i> </span>
                                                </div>    
                                            </div>   

                                            <div class="form-group col-md-2">
                                                <label for="inputEmail" class="control-label">Fecha Fin</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <div class="input-group date form-control" id="FechaFinSuspencionDate" style="border: none;">
                                                    <input id="FechaFinSuspencion" class="form-control " type="text" value="" name="FechaFinSuspencion" default="" data-date="" data-behavior="FechaFinSuspencion">
                                                <span class="input-group-addon btn"><i class="glyphicon glyphicon-calendar"></i> </span>
                                                </div>    
                                            </div>                                           
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-2">
                                                <label for="inputEmail" class="control-label">Fecha Reinicio</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <div class="input-group date form-control" id="FechaReinicioSuspencionDate" style="border: none;">
                                                    <input id="FechaReinicioSuspencion" class="form-control " type="text" value="" name="FechaReinicioSuspencion" default="" data-date="" data-behavior="FechaReinicioSuspencion">
                                                <span class="input-group-addon btn"><i class="glyphicon glyphicon-calendar"></i> </span>
                                                </div>    
                                            </div>                                    
                                        </div>
                                        <div class="row">
                                            <center>
                                                <div class="form-group col-md-12">
                                                    <button type="button" class="btn btn-primary" value="" name="AgregarSuspencion" id="AgregarAgregarSuspencionProrroga" >Agregar Suspención</button>
                                                </div>
                                            </center>   
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">                                        
                                        <div class="form-group col-md-2">
                                            <h4 class="modal-title" id="myModalLabel">Cesiones</h4>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <button type="button" class="btn btn-info botonX" value="" name="NuevaCesion" id="NuevaCesion" >Nueva Cesión</button>
                                        </div>
                                    </div>
                                    <div id="NuevaCesionD" style="display:none;">                                        
                                        <div class="row">
                                            <div class="form-group col-md-2">
                                                <label for="inputEmail" class="control-label">Nombre Cesionario</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" class="form-control"  placeholder="Nombre Cesionario" id="Nombre_Cesionario" name="Nombre_Cesionario">
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="inputEmail" class="control-label">Cédula del  Cesionario</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" class="form-control"  placeholder="Cédula del Cesionario" id="Cedula_Cesionario" name="Cedula_Cesionario">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-2">
                                                <label for="inputEmail" class="control-label">Dv Cesión</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" class="form-control"  placeholder="Dv Cesión" id="Dv_Cesion" name="Dv_Cesion">
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="inputEmail" class="control-label">Valor Cesión</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" class="form-control"  placeholder="Valor Cesión" id="Valor_Cesion" name="Valor_Cesion">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-2">
                                                <label for="inputEmail" class="control-label">Fecha Cesión</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <div class="input-group date form-control" id="FechaCesionDate" style="border: none;">
                                                    <input id="FechaCesion" class="form-control " type="text" value="" name="FechaCesion" default="" data-date="" data-behavior="FechaCesion">
                                                <span class="input-group-addon btn"><i class="glyphicon glyphicon-calendar"></i> </span>
                                                </div>    
                                            </div>                                           
                                        </div>
                                        <div class="row">
                                            <center>
                                                <div class="form-group col-md-12">
                                                    <button type="button" class="btn btn-primary" value="" name="AgregarCesion" id="AgregarCesion" >Agregar Cesión</button>
                                                </div>
                                            </center>   
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">                                        
                                        <div class="form-group col-md-2">
                                            <h4 class="modal-title" id="myModalLabel">Obligaciones</h4>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <button type="button" class="btn btn-info botonX" value="" name="NuevaObligacion" id="NuevaObligacion" >Nueva Obligación</button>
                                        </div>
                                    </div>
                                    <div id="NuevaObligacionD" style="display:none;">                                        
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="inputEmail" class="control-label">Obligación</label>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <textarea class="form-control"  placeholder="Obligación" id="Obligacion" name="Obligacion"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <center>
                                                <div class="form-group col-md-12">
                                                    <button type="button" class="btn btn-primary" value="" name="AgregarObligacion" id="AgregarObligacion" >Agregar Obligación</button>
                                                </div>
                                            </center>   
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <center>
                                                <button type="button" class="btn btn-success" value="" name="Agregar" id="Agregar" >Agregar Contrato</button>
                                            </center>
                                        </div>
                                    </div>
                                </li>
                            </ul>   
                            <div class="form-group"  id="mensaje_contrato" style="display: none;">
                                <div id="alert_contrato"></div>
                            </div>                         
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>                        
@stop