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
                                <button type="button" class="btn btn-info"  data-funcion="verContrato" value="{{$Contratos['Id']}}" >
                                    <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                                </button>

                                <button type="button" class="btn btn-primary" data-funcion="modificarContrato" value="{{$Contratos['Id']}}" >
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
                                            <input type="text" class="form-control"  placeholder="Número de Cédula" id="Cedula_Contratista" name="Cedula_Contratista">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Dv</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control"  placeholder="Número Dv" id="Dv" name="Dv">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail" class="control-label">Nombre Contratista</label>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input type="text" class="form-control"  placeholder="Nombre del Contratista" id="Nombre_Contratista" name="Nombre_Contratista">
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
                                            <select name="Tipo_Contrato" id="Tipo_Contrato" class="form-control">
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
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Fecha de Final Contrato</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input-group date form-control" id="FechaFinContratoDate" style="border: none;">
                                                <input id="FechaFinContrato" class="form-control " type="text" value="" name="FechaFinContrato" default="" data-date="" data-behavior="FechaFinContrato">
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
                                        <div class="row">
                                            <div class="form-group col-md-1"></div>                                                
                                            <div class="form-group col-md-10">
                                                <table class="table table-bordered" id="TablaAdicion" style="display:none;">
                                                    <thead>
                                                        <tr>
                                                            <th>N° de Adición</th>
                                                            <th>Valor de Adición</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="RegistrosAdicion"></tbody>
                                                </table>
                                            </div>
                                            <div class="form-group col-md-1"></div>                                                
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
                                        <div class="row">
                                            <div class="form-group col-md-1"></div>                                                
                                            <div class="form-group col-md-10">
                                                <table class="table table-bordered" id="TablaProrroga" style="display:none;">
                                                    <thead>
                                                        <tr>
                                                            <th>N° de Prórroga</th>
                                                            <th>Duración Meses</th>
                                                            <th>Duración Días</th>
                                                            <th>Fecha Fin CTO Prórroga</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="RegistrosProrroga"></tbody>
                                                </table>
                                            </div>
                                            <div class="form-group col-md-1"></div>                                                
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
                                            <div class="form-group col-md-12">
                                                <label for="inputEmail" class="control-label">Objeto Suspención</label>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <textarea class="form-control"  placeholder="Objeto de la suspención" id="Objeto_Suspencion" name="Objeto_Suspencion"></textarea>
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
                                                    <button type="button" class="btn btn-primary" value="" name="AgregarSuspencion" id="AgregarSuspencion" >Agregar Suspención</button>
                                                </div>
                                            </center>   
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-1"></div>                                                
                                            <div class="form-group col-md-10">
                                                <table class="table table-bordered" id="TablaSuspencion" style="display:none;">
                                                    <thead>
                                                        <tr>
                                                            <th>N° de Suspención</th>
                                                            <th>Objeto de la Suspención</th>
                                                            <th>Duración Meses</th>
                                                            <th>Duración Días</th>
                                                            <th>Fecha de Inicio</th>
                                                            <th>Fecha de Fin</th>
                                                            <th>Fecha de Reincio</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="RegistrosSuspencion"></tbody>
                                                </table>
                                            </div>
                                            <div class="form-group col-md-1"></div>                                                
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
                                                <label for="inputEmail" class="control-label">Valor Cedido</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" class="form-control"  placeholder="Valor Cedido" id="Valor_Cesion" name="Valor_Cesion">
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
                                        <div class="row">
                                            <div class="form-group col-md-1"></div>                                                
                                            <div class="form-group col-md-10">
                                                <table class="table table-bordered" id="TablaCesion" style="display:none;">
                                                    <thead>
                                                        <tr>
                                                            <th>N° de Cesión</th>
                                                            <th>Nombre del Cesionario</th>
                                                            <th>Cédula del Cesionario</th>
                                                            <th>Dv Cesión</th>
                                                            <th>Valor Cedido</th>
                                                            <th>Fecha de Cesión</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="RegistrosCesion"></tbody>
                                                </table>
                                            </div>
                                            <div class="form-group col-md-1"></div>                                                
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
                                        <div class="row">
                                            <div class="form-group col-md-1"></div>                                                
                                            <div class="form-group col-md-10">
                                                <table class="table table-bordered" id="TablaObligacion" style="display:none;">
                                                    <thead>
                                                        <tr>
                                                            <th>N° de Obligación</th>
                                                            <th>Obligación</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="RegistrosObligacion"></tbody>
                                                </table>
                                            </div>
                                            <div class="form-group col-md-1"></div>                                                
                                        </div>
                                    </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <center>
                                                <button type="button" class="btn btn-success" value="" name="AgregarContrato" id="AgregarContrato" >Agregar Contrato</button>
                                            </center>
                                        </div>
                                    </div>
                                    <div id="mensaje"></div>
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
    <!-- ------------------------------FINAL DE MODAL REGISTRO DE CONTRATOS ----------------------------------------- -->


    <!-- ------------------------------ MODAL VER CONTRATOS ----------------------------------------- -->
    <div class="modal fade bs-example-modal-lg" id="VerContratoD" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="myModalLabel">VER CONTRATO</h3>
                 </div>
                <form id="verContratoF" name="verContratoF">  
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
                                            <input type="text" class="form-control"  placeholder="Número de Cédula" id="Cedula_ContratistaV" name="Cedula_ContratistaV" readonly>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Dv</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control"  placeholder="Número Dv" id="DvV" name="DvV" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail" class="control-label">Nombre Contratista</label>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input type="text" class="form-control"  placeholder="Nombre del Contratista" id="Nombre_ContratistaV" name="Nombre_ContratistaV" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Número de Contrato</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control"  placeholder="Número de Contrato" id="Numero_ContratoV" name="Numero_ContratoV" readonly>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Tipo de Contrato</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control"  placeholder="Tipo de Contrato" id="Tipo_ContratoV" name="Tipo_ContratoV" readonly>                                            
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
                                            <input type="text" class="form-control"  placeholder="Nombre Representante Legal" id="Nombre_RepresentanteV" name="Nombre_RepresentanteV" readonly>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Cédula Representante Legal</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control"  placeholder="Cédula Representante Legal" id="Cedula_RepresentanteV" name="Cedula_RepresentanteV" readonly>
                                        </div>
                                    </div>

                                    <div class="row">                                        
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail" class="control-label">Objeto del Contrato</label>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <textarea class="form-control"  placeholder="Objeto del Contrato" id="Objeto_ContratoV" name="Objeto_ContratoV" readonly></textarea>
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
                                            <input id="FechaFirmaV" class="form-control " type="text"name="FechaFirmaV"readonly>
                                        </div> 

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Fecha de Inicio</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input class="form-control " type="text"  id="FechaInicioV" name="FechaInicioV" readonly>
                                        </div> 
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Fecha de Finalización</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input class="form-control " type="text"  id="FechaFinV" name="FechaFinV" readonly>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Fecha de Terminación Anticipada</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input class="form-control " type="text"  id="FechaFinAnticipadoV" name="FechaFinAnticipadoV" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Fecha de Final Contrato</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input class="form-control " type="text"  id="FechaFinContratoV" name="FechaFinContratoV" readonly>
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
                                            <input type="text" class="form-control"  placeholder="Meses de Duración" id="Meses_DuracionV" name="Meses_DuracionV" readonly>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Días de Duración</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control"  placeholder="Días de Duración" id="Dias_DuracionV" name="Dias_DuracionV" readonly>
                                        </div>
                                    </div>

                                    <div class="row">                                        
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail" class="control-label">Otra Forma de Duración Equivalente</label>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <textarea class="form-control"  placeholder="Forma de Duración" id="Otra_DuracionV" name="Otra_DuracionV" readonly></textarea>
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
                                            <input type="text" class="form-control"  placeholder="Valor Inicial" id="Valor_InicialV" name="Valor_InicialV" readonly>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Valor Mensual</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control"  placeholder="Valor Mensual" id="Valor_MensualV" name="Valor_MensualV" readonly>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">                                        
                                        <div class="form-group col-md-2">
                                            <h4 class="modal-title" id="myModalLabel">Adiciones</h4>
                                        </div>
                                    </div>
                                    <div id="NuevaAdicionDV" style="display:none;"> 
                                        <div class="row">
                                            <div class="form-group col-md-1"></div>                                                
                                            <div class="form-group col-md-10">
                                                <table class="table table-bordered" id="TablaAdicionV" style="display:none;">
                                                    <thead>
                                                        <tr>
                                                            <th>N° de Adición</th>
                                                            <th>Valor de Adición</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="RegistrosAdicionV"></tbody>
                                                </table>
                                            </div>
                                            <div class="form-group col-md-1"></div>                                                
                                        </div>
                                    </div>                                    
                                </li>
                                <li class="list-group-item">
                                    <div class="row">                                        
                                        <div class="form-group col-md-2">
                                            <h4 class="modal-title" id="myModalLabel">Prórrogas</h4>
                                        </div>
                                    </div>
                                    <div id="NuevaProrrogaDV" style="display:none;">                                        
                                        <div class="row">
                                            <div class="form-group col-md-1"></div>                                                
                                            <div class="form-group col-md-10">
                                                <table class="table table-bordered" id="TablaProrrogaV" style="display:none;">
                                                    <thead>
                                                        <tr>
                                                            <th>N° de Prórroga</th>
                                                            <th>Duración Meses</th>
                                                            <th>Duración Días</th>
                                                            <th>Fecha Fin CTO Prórroga</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="RegistrosProrrogaV"></tbody>
                                                </table>
                                            </div>
                                            <div class="form-group col-md-1"></div>                                                
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">                                        
                                        <div class="form-group col-md-2">
                                            <h4 class="modal-title" id="myModalLabel">Suspenciones</h4>
                                        </div>
                                    </div>
                                    <div id="NuevaSuspencionDV" style="display:none;">
                                        <div class="row">
                                            <div class="form-group col-md-1"></div>                                                
                                            <div class="form-group col-md-10">
                                                <table class="table table-bordered" id="TablaSuspencionV" style="display:none;">
                                                    <thead>
                                                        <tr>
                                                            <th>N° de Suspención</th>
                                                            <th>Objeto de la Suspención</th>
                                                            <th>Duración Meses</th>
                                                            <th>Duración Días</th>
                                                            <th>Fecha de Inicio</th>
                                                            <th>Fecha de Fin</th>
                                                            <th>Fecha de Reincio</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="RegistrosSuspencionV"></tbody>
                                                </table>
                                            </div>
                                            <div class="form-group col-md-1"></div>                                                
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">                                        
                                        <div class="form-group col-md-2">
                                            <h4 class="modal-title" id="myModalLabel">Cesiones</h4>
                                        </div>
                                    </div>
                                    <div id="NuevaCesionDV" style="display:none;">  
                                        <div class="row">
                                            <div class="form-group col-md-1"></div>                                                
                                            <div class="form-group col-md-10">
                                                <table class="table table-bordered" id="TablaCesionV" style="display:none;">
                                                    <thead>
                                                        <tr>
                                                            <th>N° de Cesión</th>
                                                            <th>Nombre del Cesionario</th>
                                                            <th>Cédula del Cesionario</th>
                                                            <th>Dv Cesión</th>
                                                            <th>Valor Cedido</th>
                                                            <th>Fecha de Cesión</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="RegistrosCesionV"></tbody>
                                                </table>
                                            </div>
                                            <div class="form-group col-md-1"></div>                                                
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">                                        
                                        <div class="form-group col-md-2">
                                            <h4 class="modal-title" id="myModalLabel">Obligaciones</h4>
                                        </div>
                                    </div>
                                    <div id="NuevaObligacionDV" style="display:none;">
                                        <div class="row">
                                            <div class="form-group col-md-1"></div>                                                
                                            <div class="form-group col-md-10">
                                                <table class="table table-bordered" id="TablaObligacionV" style="display:none;">
                                                    <thead>
                                                        <tr>
                                                            <th>N° de Obligación</th>
                                                            <th>Obligación</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="RegistrosObligacionV"></tbody>
                                                </table>
                                            </div>
                                            <div class="form-group col-md-1"></div>                                                
                                        </div>
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
    <!-- ------------------------------FINAL DE MODAL VER CONTRATOS ----------------------------------------- -->

    <!-- ------------------------------ MODAL MODIFICAR CONTRATOS ----------------------------------------- -->
    <div class="modal fade bs-example-modal-lg" id="ModificarContratoD" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="myModalLabel">MODIFICAR CONTRATO</h3>
                 </div>
                <form id="agregarContratoF" name="modificarContratoF">  
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
                                            <input type="text" class="form-control"  placeholder="Número de Cédula" id="Cedula_ContratistaM" name="Cedula_ContratistaM">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Dv</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control"  placeholder="Número Dv" id="DvM" name="DvM">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail" class="control-label">Nombre Contratista</label>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input type="text" class="form-control"  placeholder="Nombre del Contratista" id="Nombre_ContratistaM" name="Nombre_ContratistaM">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Número de Contrato</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control"  placeholder="Número de Contrato" id="Numero_ContratoM" name="Numero_ContratoM">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Tipo de Contrato</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <select name="Tipo_ContratoM" id="Tipo_ContratoM" class="form-control">
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
                                            <input type="text" class="form-control"  placeholder="Nombre Representante Legal" id="Nombre_RepresentanteM" name="Nombre_RepresentanteM">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Cédula Representante Legal</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control"  placeholder="Cédula Representante Legal" id="Cedula_RepresentanteM" name="Cedula_RepresentanteM">
                                        </div>
                                    </div>

                                    <div class="row">                                        
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail" class="control-label">Objeto del Contrato</label>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <textarea class="form-control"  placeholder="Objeto del Contrato" id="Objeto_ContratoM" name="Objeto_ContratoM"></textarea>
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
                                            <div class="input-group date form-control" id="FechaFirmaDateM" style="border: none;">
                                                <input id="FechaFirmaM" class="form-control " type="text" value="" name="FechaFirmaM" default="" data-date="" data-behavior="FechaFirmaM">
                                            <span class="input-group-addon btn"><i class="glyphicon glyphicon-calendar"></i> </span>
                                            </div>    
                                        </div> 

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Fecha de Inicio</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input-group date form-control" id="FechaInicioDateM" style="border: none;">
                                                <input id="FechaInicioM" class="form-control " type="text" value="" name="FechaInicioM" default="" data-date="" data-behavior="FechaInicioM">
                                            <span class="input-group-addon btn"><i class="glyphicon glyphicon-calendar"></i> </span>
                                            </div>    
                                        </div> 
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Fecha de Finalización</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input-group date form-control" id="FechaFinDateM" style="border: none;">
                                                <input id="FechaFinM" class="form-control " type="text" value="" name="FechaFinM" default="" data-date="" data-behavior="FechaFinM">
                                            <span class="input-group-addon btn"><i class="glyphicon glyphicon-calendar"></i> </span>
                                            </div>    
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Fecha de Terminación Anticipada</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input-group date form-control" id="FechaFinAnticipadoDateM" style="border: none;">
                                                <input id="FechaFinAnticipadoM" class="form-control " type="text" value="" name="FechaFinAnticipadoM" default="" data-date="" data-behavior="FechaFinAnticipadoM">                                            <span class="input-group-addon btn"><i class="glyphicon glyphicon-calendar"></i> </span>
                                            </div>    
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Fecha de Final Contrato</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input-group date form-control" id="FechaFinContratoDateM" style="border: none;">
                                                <input id="FechaFinContratoM" class="form-control " type="text" value="" name="FechaFinContratoM" default="" data-date="" data-behavior="FechaFinContratoM">
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
                                            <input type="text" class="form-control"  placeholder="Meses de Duración" id="Meses_DuracionM" name="Meses_DuracionM">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Días de Duración</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control"  placeholder="Días de Duración" id="Dias_DuracionM" name="Dias_DuracionM">
                                        </div>
                                    </div>

                                    <div class="row">                                        
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail" class="control-label">Otra Forma de Duración Equivalente</label>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <textarea class="form-control"  placeholder="Forma de Duración" id="Otra_DuracionM" name="Otra_DuracionM"></textarea>
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
                                            <input type="text" class="form-control"  placeholder="Valor Inicial" id="Valor_InicialM" name="Valor_InicialM">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="inputEmail" class="control-label">Valor Mensual</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control"  placeholder="Valor Mensual" id="Valor_MensualM" name="Valor_MensualM">
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">                                        
                                        <div class="form-group col-md-2">
                                            <h4 class="modal-title" id="myModalLabel">Adiciones</h4>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <button type="button" class="btn btn-info botonX" value="" name="NuevaAdicionM" id="NuevaAdicionM" >Nueva Adición</button>
                                        </div>
                                    </div>
                                    <div id="NuevaAdicionDM" style="display:none;">                                        
                                        <div class="row">
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
                                                    <button type="button" class="btn btn-primary" value="" name="AgregarAdicionM" id="AgregarAdicionM" >Agregar Adición</button>
                                                </div>
                                            </center>   
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-1"></div>                                                
                                            <div class="form-group col-md-10">
                                                <table class="table table-bordered" id="TablaAdicionM" style="display:none;">
                                                    <thead>
                                                        <tr>
                                                            <th>N° de Adición</th>
                                                            <th>Valor de Adición</th>
                                                            <th>Opción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="RegistrosAdicionM"></tbody>
                                                </table>
                                            </div>
                                            <div class="form-group col-md-1"></div>                                                
                                        </div>
                                    </div>                                    
                                </li>
                                <li class="list-group-item">
                                    <div class="row">                                        
                                        <div class="form-group col-md-2">
                                            <h4 class="modal-title" id="myModalLabel">Prórrogas</h4>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <button type="button" class="btn btn-info botonX"  value="" name="NuevaProrrogaM" id="NuevaProrrogaM" >Nueva Prórroga</button>
                                        </div>
                                    </div>
                                    <div id="NuevaProrrogaDM" style="display:none;">                                        
                                        <div class="row">
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
                                                    <button type="button" class="btn btn-primary " value="" name="AgregarProrrogaM" id="AgregarProrrogaM" >Agregar Prórroga</button>
                                                </div>
                                            </center>   
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-1"></div>                                                
                                            <div class="form-group col-md-10">
                                                <table class="table table-bordered" id="TablaProrrogaM" style="display:none;">
                                                    <thead>
                                                        <tr>
                                                            <th>N° de Prórroga</th>
                                                            <th>Duración Meses</th>
                                                            <th>Duración Días</th>
                                                            <th>Fecha Fin CTO Prórroga</th>
                                                            <th>Opción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="RegistrosProrrogaM"></tbody>
                                                </table>
                                            </div>
                                            <div class="form-group col-md-1"></div>                                                
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">                                        
                                        <div class="form-group col-md-2">
                                            <h4 class="modal-title" id="myModalLabel">Suspenciones</h4>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <button type="button" class="btn btn-info botonX" value="" name="NuevaSuspencionM" id="NuevaSuspencionM" >Nueva Suspención</button>
                                        </div>
                                    </div>
                                    <div id="NuevaSuspencionDM" style="display:none;">                                        
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="inputEmail" class="control-label">Objeto Suspención</label>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <textarea class="form-control"  placeholder="Objeto de la suspención" id="Objeto_Suspencion" name="Objeto_Suspencion"></textarea>
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
                                                    <button type="button" class="btn btn-primary" value="" name="AgregarSuspencionM" id="AgregarSuspencionM" >Agregar Suspención</button>
                                                </div>
                                            </center>   
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-1"></div>                                                
                                            <div class="form-group col-md-10">
                                                <table class="table table-bordered" id="TablaSuspencionM" style="display:none;">
                                                    <thead>
                                                        <tr>
                                                            <th>N° de Suspención</th>
                                                            <th>Objeto de la Suspención</th>
                                                            <th>Duración Meses</th>
                                                            <th>Duración Días</th>
                                                            <th>Fecha de Inicio</th>
                                                            <th>Fecha de Fin</th>
                                                            <th>Fecha de Reincio</th>
                                                            <th>Opción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="RegistrosSuspencionM"></tbody>
                                                </table>
                                            </div>
                                            <div class="form-group col-md-1"></div>                                                
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">                                        
                                        <div class="form-group col-md-2">
                                            <h4 class="modal-title" id="myModalLabel">Cesiones</h4>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <button type="button" class="btn btn-info botonX" value="" name="NuevaCesionM" id="NuevaCesionM" >Nueva Cesión</button>
                                        </div>
                                    </div>
                                    <div id="NuevaCesionDM" style="display:none;">                                        
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
                                                <label for="inputEmail" class="control-label">Valor Cedido</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" class="form-control"  placeholder="Valor Cedido" id="Valor_Cesion" name="Valor_Cesion">
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
                                                    <button type="button" class="btn btn-primary" value="" name="AgregarCesionM" id="AgregarCesionM" >Agregar Cesión</button>
                                                </div>
                                            </center>   
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-1"></div>                                                
                                            <div class="form-group col-md-10">
                                                <table class="table table-bordered" id="TablaCesionM" style="display:none;">
                                                    <thead>
                                                        <tr>
                                                            <th>N° de Cesión</th>
                                                            <th>Nombre del Cesionario</th>
                                                            <th>Cédula del Cesionario</th>
                                                            <th>Dv Cesión</th>
                                                            <th>Valor Cedido</th>
                                                            <th>Fecha de Cesión</th>
                                                            <th>Opción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="RegistrosCesionM"></tbody>
                                                </table>
                                            </div>
                                            <div class="form-group col-md-1"></div>                                                
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">                                        
                                        <div class="form-group col-md-2">
                                            <h4 class="modal-title" id="myModalLabel">Obligaciones</h4>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <button type="button" class="btn btn-info botonX" value="" name="NuevaObligacionM" id="NuevaObligacionM" >Nueva Obligación</button>
                                        </div>
                                    </div>
                                    <div id="NuevaObligacionDM" style="display:none;">                                        
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
                                                    <button type="button" class="btn btn-primary" value="" name="AgregarObligacionM" id="AgregarObligacionM" >Agregar Obligación</button>
                                                </div>
                                            </center>   
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-1"></div>                                                
                                            <div class="form-group col-md-10">
                                                <table class="table table-bordered" id="TablaObligacionM" style="display:none;">
                                                    <thead>
                                                        <tr>
                                                            <th>N° de Obligación</th>
                                                            <th>Obligación</th>
                                                            <th>Opción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="RegistrosObligacionM"></tbody>
                                                </table>
                                            </div>
                                            <div class="form-group col-md-1"></div>                                                
                                        </div>
                                    </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <center>
                                                <button type="button" class="btn btn-success" value="" name="ModificarContrato" id="ModificarContrato" >Modificar Contrato</button>
                                            </center>
                                        </div>
                                    </div>
                                    <div id="mensaje"></div>
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
    <!-- ------------------------------FINAL DE MODAL MODIFICAR CONTRATOS ----------------------------------------- -->

</div>                        
@stop