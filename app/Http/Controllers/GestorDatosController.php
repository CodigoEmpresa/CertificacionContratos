<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Idrd\Usuarios\Repo\PersonaInterface;
use Validator;
use Exception;

use App\Models\Contrato;
use App\Models\TipoContrato;
use App\Models\Adicion;
use App\Models\Prorroga;
use App\Models\Suspencion;
use App\Models\Cesion;
use App\Models\Obligacion;
use App\Models\TipoDocumento;

class GestorDatosController extends Controller
{
    public function __construct(PersonaInterface $repositorio_personas)
	{
		if (isset($_SESSION['Usuario']))
			$this->Usuario = $_SESSION['Usuario'];

		$this->repositorio_personas = $repositorio_personas;
	}

    public function index()
	{
		$TipoContrato = TipoContrato::all();
		$TipoDocumento = TipoDocumento::all();
		return view('DATOS/gestor')
				->with(compact('TipoContrato'))
				->with(compact('TipoDocumento'))
				;
	}
	
	public function GetContratoDate(Request $request, $anio){
		$Contrato = Contrato::whereBetween('Fecha_Firma', array($anio.'-01-01', $anio.'-12-31'))
		->get();
		$html ="";

		foreach ($Contrato as $key) {
			$Cedula = "<tr><td>".$key->Cedula."</td>";
			$Nombre_Contratista = "<td>".$key->Nombre_Contratista."</td>";
			$Numero_Contrato = "<td>".$key->Numero_Contrato."</td>";
			$Fecha_Inicio = "<td>".$key->Fecha_Inicio."</td>";

			$Botones = '<td><button type="button" class="btn btn-info" data-funcion="verContrato" value="'.$key->Id.'" >
                                  <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                              </button>
                              <button type="button" class="btn btn-primary" data-funcion="modificarContrato" value="'.$key->Id.'" >
                                  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                              </button>
                              <button type="button" class="btn btn-danger"  data-funcion="eliminarContrato" value="'.$key->Id.'" >
                                  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                              </button></td></tr>';

			$h = $Cedula.$Nombre_Contratista.$Numero_Contrato.$Fecha_Inicio.$Botones;

			$html = $html.$h;
		}
		$Resultado = "<table id='datosTabla' name='datosTabla'>
			        <thead>
			            <tr>
							<th>CÉDULA</th>                        
	                        <th>CONTRATISTA</th>
	                        <th>N° DE CONTRATO</th>
	                        <th>AÑO DE CONTRATO</th>
	                        <th>OPCIONES</th>							
						</tr>
					</thead>
						<tbody>".$html."</tbody></table>";
		return ($Resultado);
	}
	

	public function RevisionAdicion(Request $request){
		if ($request->ajax()) { 
    		$validator = Validator::make($request->all(), [
    			'Valor_Adicion' => 'required|numeric',
    			]);

	        if ($validator->fails()){
	            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
	        }else{        			
	        	return response()->json(array('status' => 'success', 'OK' => 'OK'));
			}
		}else{
			return response()->json(["Sin acceso"]);
		}
	}

	public function RevisionProrroga(Request $request){
		if ($request->ajax()) { 
    		$validator = Validator::make($request->all(), [
    			'Meses_Prorroga' => 'required|numeric',
    			'Dias_Prorroga' => 'required|numeric',
    			'FechaFinCtoProrroga' => 'required|date'
    			]);

	        if ($validator->fails()){
	            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
	        }else{        			
	        	return response()->json(array('status' => 'success', 'OK' => 'OK'));
			}
		}else{
			return response()->json(["Sin acceso"]);
		}
	}

	public function RevisionSuspencion(Request $request){
		if ($request->ajax()) { 
    		$validator = Validator::make($request->all(), [
    			//'Objeto_Suspencion' => 'required',
    			'Meses_Suspencion' => 'required|numeric',
    			'Dias_Suspencion' => 'required|numeric',
    			'FechaInicioSuspencion' => 'required|date',
    			'FechaFinSuspencion' => 'required|date',
    			'FechaReinicioSuspencion' => 'required|date'    			
    			]);

	        if ($validator->fails()){
	            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
	        }else{        			
	        	return response()->json(array('status' => 'success', 'OK' => 'OK'));
			}
		}else{
			return response()->json(["Sin acceso"]);
		}
	}

	public function RevisionCesion(Request $request){
		if ($request->ajax()) { 
			$var = '';
			if($request->Tipo_Documento_Cesion == 1 || $request->Tipo_Documento_Cesion == 2 || $request->Tipo_Documento_Cesion == 3 || $request->Tipo_Documento_Cesion == 7){
				$var = '|numeric|digits_between:1,15';
			}elseif($request->Tipo_Documento_Cesion == 4 || $request->Tipo_Documento_Cesion == 5 || $request->Tipo_Documento_Cesion == 6){
				$var = '|alpha_num';
			}else{
				$var = '';
			}

    		$validator = Validator::make($request->all(), [
    			'Tipo_Documento_Cesion' => 'required',
    			'Nombre_Cesionario' => 'required',
    			"Cedula_Cesionario" => 'required'.$var,
    			'Dv_Cesion' => array('required_if:Tipo_Documento_Cesion,7', 'numeric'),
    			'Valor_Cesion' => 'required|numeric',
    			'FechaCesion' => 'required|date',
    			]);

	        if ($validator->fails()){
	            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
	        }else{        			
	        	return response()->json(array('status' => 'success', 'OK' => 'OK'));
			}
		}else{
			return response()->json(["Sin acceso"]);
		}
	}

	public function RevisionObligacion(Request $request){
		if ($request->ajax()) { 
    		$validator = Validator::make($request->all(), [
    			'Obligacion' => 'required',
    			]);

	        if ($validator->fails()){
	            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
	        }else{        			
	        	return response()->json(array('status' => 'success', 'OK' => 'OK'));
			}
		}else{
			return response()->json(["Sin acceso"]);
		}
	}

	public function AgregarContrato(Request $request){
		if ($request->ajax()) { 

			$var = '';
			if($request->Tipo_Documento_Inicial == 1 || $request->Tipo_Documento_Inicial == 2 || $request->Tipo_Documento_Inicial == 3 || $request->Tipo_Documento_Inicial == 7){
				$var = '|numeric|digits_between:1,15';
			}elseif($request->Tipo_Documento_Inicial == 4 || $request->Tipo_Documento_Inicial == 5 || $request->Tipo_Documento_Inicial == 6){
				$var = '|alpha_num';
			}else{
				$var = '';
			}

			$varRep = array('required_if:Tipo_Documento_Representante,7');
			if($request->Tipo_Documento_Representante == 1 || $request->Tipo_Documento_Representante == 2 || $request->Tipo_Documento_Representante == 3 || $request->Tipo_Documento_Representante == 7){
				$varRep = array('required_if:Tipo_Documento_Representante,7', 'numeric', 'digits_between:1,15');
			}elseif($request->Tipo_Documento_Representante == 4 || $request->Tipo_Documento_Representante == 5 || $request->Tipo_Documento_Representante == 6){
				$varRep = array('required_if:Tipo_Documento_Representante,7', 'alpha_num');
			}else{
				$varRep = array('required_if:Tipo_Documento_Representante,7');
			}

			$varTipoCI = 'required|numeric:|digits_between:1,15';
	   		$varTipoCM = 'required|numeric:|digits_between:1,8';
			if($request->Tipo_Contrato == 4 || $request->Tipo_Contrato == 11 || $request->Tipo_Contrato == 17 || $request->Tipo_Contrato == 23 || $request->Tipo_Contrato == 24 ||
			   $request->Tipo_Contrato == 25 || $request->Tipo_Contrato == 26 || $request->Tipo_Contrato == 27){
			   		$varTipoCI = 'numeric:|digits_between:1,15';
			   		$varTipoCM = 'numeric:|digits_between:1,8';
			}

    		$validator = Validator::make($request->all(), [
    			  "Tipo_Documento_Inicial" => "required",
			   	  "Cedula_Contratista" => 'required'.$var,
				  "Dv" => array('required_if:Tipo_Documento_Inicial,7','numeric', 'digits:1', 'min:1', 'max:9'),
				  "Nombre_Contratista" => "required",
				  "Numero_Contrato" => "required|numeric|digits_between:1,10",
				  "Tipo_Contrato" => "required",
				  "Tipo_Documento_Representante" => array('required_if:Tipo_Documento_Inicial,7'),
				  "Nombre_Representante" => array('required_if:Tipo_Documento_Inicial,7'),
				  "Cedula_Representante" => $varRep,
				  "Objeto_Contrato" => "required",
				  "FechaFirma" => "required|date",
				  "FechaInicio" => "required|date",
				  "FechaFin" => "required|date",
				  /*"FechaFinAnticipado" => "required|date",*/
				  "Meses_Duracion" => "required|numeric:|digits_between:1,4",
				  "Dias_Duracion" => "required|numeric:|digits_between:1,4",
				  "Otra_Duracion" => "",
				  "Valor_Inicial" => $varTipoCI,
				  "Valor_Mensual" => $varTipoCM,
    			]);    		

	        if ($validator->fails()){
	            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
	        }else{ 

	        	$Contrato = new Contrato;
	        	$Contrato->Tipo_Documento = $request->Tipo_Documento_Inicial;
	        	$Contrato->Cedula = $request->Cedula_Contratista;
	        	$Contrato->Dv = $request->Dv;
	        	$Contrato->Nombre_Contratista = $request->Nombre_Contratista;
	        	$Contrato->Numero_Contrato = $request->Numero_Contrato;
	        	$Contrato->Tipo_Contrato_Id = $request->Tipo_Contrato;
	        	$Contrato->Nombre_Representante = $request->Nombre_Representante;
	        	$Contrato->Tipo_Documento_Representante = $request->Tipo_Documento_Representante;
	        	$Contrato->Cedula_Representante = $request->Cedula_Representante;
	        	$Contrato->Objeto = $request->Objeto_Contrato;
	        	$Contrato->Fecha_Firma = $request->FechaFirma;
	        	$Contrato->Fecha_Inicio = $request->FechaInicio;
	        	$Contrato->Fecha_Fin = $request->FechaFin;
	        	$Contrato->Fecha_Terminacion_Anticipada = $request->FechaFinAnticipado;
	        	$Contrato->Meses_Duracion = $request->Meses_Duracion;
	        	$Contrato->Dias_Duracion = $request->Dias_Duracion;
	        	$Contrato->Otra_Duracion = $request->Otra_Duracion;	        	
	        	$Contrato->Valor_Inicial = $request->Valor_Inicial;
	        	$Contrato->Valor_Mensual = $request->Valor_Mensual;

	        	if($Contrato->save()){	        		
	        		$AdicionVector = json_decode($request['Adicion']);
					if(count($AdicionVector) > 0){	
						$i = 1;					
						foreach($AdicionVector as $Vector){
							$Adicion = new Adicion;
							$Adicion->Contrato_Id = $Contrato->Id;
							$Adicion->Numero_Adicion = $i;
							$Adicion->Valor_Adicion = $Vector->Valor_Adicion;
							$Adicion->save();
							$i= $i+1;
						}
					}

					$ProrrogaVector = json_decode($request['Prorroga']);
					if(count($ProrrogaVector) > 0){	
						$i = 1;					
						foreach($ProrrogaVector as $Vector){
							$Prorroga = new Prorroga;
							$Prorroga->Contrato_Id = $Contrato->Id;
							$Prorroga->Numero_Prorroga = $i;
							$Prorroga->Meses = $Vector->Meses_Prorroga;
							$Prorroga->Dias = $Vector->Dias_Prorroga;
							$Prorroga->Fecha_Fin = $Vector->FechaFinCtoProrroga;
							$Prorroga->save();
							$i= $i+1;
						}
					}

					$SuspencionVector = json_decode($request['Suspencion']);
					if(count($SuspencionVector) > 0){	
						$i = 1;					
						foreach($SuspencionVector as $Vector){
							$Suspencion = new Suspencion;
							$Suspencion->Contrato_Id = $Contrato->Id;
							$Suspencion->Numero_Suspencion = $i;
							//$Suspencion->Objeto_Suspension = $Vector->Objeto_Suspencion;
							$Suspencion->Meses = $Vector->Meses_Suspencion;
							$Suspencion->Dias = $Vector->Dias_Suspencion;
							$Suspencion->Fecha_Inicio = $Vector->FechaInicioSuspencion;
							$Suspencion->Fecha_Fin = $Vector->FechaFinSuspencion;
							$Suspencion->Fecha_Reinicio = $Vector->FechaReinicioSuspencion;
							$Suspencion->save();
							$i= $i+1;
						}
					}

					$CesionVector = json_decode($request['Cesion']);
					if(count($CesionVector) > 0){	
						$i = 1;					
						foreach($CesionVector as $Vector){
							$Cesion = new Cesion;
							$Cesion->Contrato_Id = $Contrato->Id;
							$Cesion->Numero_Cesion = $i;
							$Cesion->Nombre_Cesionario = $Vector->Nombre_Cesionario;							
							$Cesion->Tipo_Documento_Cesionario = $Vector->Tipo_Documento_Cesionario;
							$Cesion->Cedula_Cesionario = $Vector->Cedula_Cesionario;
							$Cesion->Dv_Cesion = $Vector->Dv_Cesion;
							$Cesion->Valor_Cedido = $Vector->Valor_Cesion;
							$Cesion->Fecha_Cesion = $Vector->FechaCesion;
							$Cesion->save();
							$i= $i+1;
						}
					}

					$ObligacionVector = json_decode($request['Obligacion']);
					if(count($ObligacionVector) > 0){	
						$i = 1;					
						foreach($ObligacionVector as $Vector){
							$Obligacion = new Obligacion;
							$Obligacion->Contrato_Id = $Contrato->Id;
							$Obligacion->Numero_Obligacion = $i;
							$Obligacion->Objeto_Obligacion = $Vector->Obligacion;							
							$Obligacion->save();
							$i= $i+1;
						}
					}
	        	}

	        	return response()->json(array('status' => 'success', 'Mensaje' => 'El contrato ha sido agregado con éxito!', 'Id' => $Contrato->Id, 
	        								  'Cedula' => $Contrato->Cedula, 'Nombre' => $Contrato->Nombre_Contratista, 'Numero' => $Contrato->Numero_Contrato,
	        								  'Fecha' => $Contrato->Fecha_Inicio));
			}
		}else{
			return response()->json(["Sin acceso"]);
		}
	}

	public function GetContrato(Request $request){
		$Contratos = Contrato::all();
		return $Contratos;
	}

	public function GetContratoOne(Request $request, $id_contrato){
		$Contrato = Contrato::with('Tipocontrato', 'Adicion', 'Prorroga', 'Suspencion', 'Cesion', 'Obligacion', 'TipoDocumento')->find($id_contrato);
		return $Contrato;
	}

	public function ModificarContrato(Request $request){
		if ($request->ajax()) { 
			$var = '';
			if($request->Tipo_Documento_InicialM == 1 || $request->Tipo_Documento_InicialM == 2 || $request->Tipo_Documento_InicialM == 3 || $request->Tipo_Documento_InicialM == 7){
				$var = '|numeric|digits_between:1,15';
			}elseif($request->Tipo_Documento_InicialM == 4 || $request->Tipo_Documento_InicialM == 5 || $request->Tipo_Documento_InicialM == 6){
				$var = '|alpha_num';
			}else{
				$var = '';
			}

			$varRep = array('required_if:Tipo_Documento_InicialM,7');
			if($request->Tipo_Documento_RepresentanteM == 1 || $request->Tipo_Documento_RepresentanteM == 2 || $request->Tipo_Documento_RepresentanteM == 3 || $request->Tipo_Documento_RepresentanteM == 7){
				$varRep = array('required_if:Tipo_Documento_InicialM,7', 'numeric', 'digits_between:1,15');
			}elseif($request->Tipo_Documento_RepresentanteM == 4 || $request->Tipo_Documento_RepresentanteM == 5 || $request->Tipo_Documento_RepresentanteM == 6){
				$varRep = array('required_if:Tipo_Documento_InicialM,7', 'alpha_num');
			}else{
				$varRep = array('required_if:Tipo_Documento_InicialM,7');
			}

			$varTipoCI = 'required|numeric:|digits_between:1,15';
	   		$varTipoCM = 'required|numeric:|digits_between:1,8';
			if($request->Tipo_ContratoM == 4 || $request->Tipo_ContratoM == 11 || $request->Tipo_ContratoM == 17 || $request->Tipo_ContratoM == 23 || $request->Tipo_ContratoM == 24 ||
			   $request->Tipo_ContratoM == 25 || $request->Tipo_ContratoM == 26 || $request->Tipo_ContratoM == 27){
			   		$varTipoCI = 'numeric:|digits_between:1,15';
			   		$varTipoCM = 'numeric:|digits_between:1,8';
			}

    		$validator = Validator::make($request->all(), [
			   	  "Tipo_Documento_InicialM" => "required",
			   	  "Cedula_ContratistaM" => 'required'.$var,
				  "DvM" => array('required_if:Tipo_Documento_InicialM,7','numeric', 'digits:1'),
				  "Nombre_ContratistaM" => "required",
				  "Numero_ContratoM" => "required|numeric|digits_between:1,10",
				  "Tipo_ContratoM" => "required",
				  "Nombre_RepresentanteM" => array('required_if:Tipo_Documento_InicialM,7'),
				  "Tipo_Documento_RepresentanteM" => array('required_if:Tipo_Documento_InicialM,7'),
				  "Cedula_RepresentanteM" => $varRep,
				  "Objeto_ContratoM" => "required",
				  "FechaFirmaM" => "required|date",
				  "FechaInicioM" => "required|date",
				  "FechaFinM" => "required|date",
				  /*"FechaFinAnticipadoM" => "required|date",*/
				  "Meses_DuracionM" => "required|numeric:|digits_between:1,4",
				  "Dias_DuracionM" => "required|numeric:|digits_between:1,4",
				  "Otra_DuracionM" => "",
				  "Valor_InicialM" => $varTipoCI,
				  "Valor_MensualM" => $varTipoCM,
    			]);    		

	        if ($validator->fails()){
	            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
	        }else{ 
	        	$Contrato = Contrato::find($request->Id_ContratoM);
	        	$Contrato->Tipo_Documento = $request->Tipo_Documento_InicialM;
	        	$Contrato->Cedula = $request->Cedula_ContratistaM;
	        	$Contrato->Dv = $request->DvM;
	        	$Contrato->Nombre_Contratista = $request->Nombre_ContratistaM;
	        	$Contrato->Numero_Contrato = $request->Numero_ContratoM;
	        	$Contrato->Tipo_Contrato_Id = $request->Tipo_ContratoM;
	        	$Contrato->Nombre_Representante = $request->Nombre_RepresentanteM;
	        	$Contrato->Tipo_Documento_Representante = $request->Tipo_Documento_RepresentanteM;
	        	$Contrato->Cedula_Representante = $request->Cedula_RepresentanteM;
	        	$Contrato->Objeto = $request->Objeto_ContratoM;
	        	$Contrato->Fecha_Firma = $request->FechaFirmaM;
	        	$Contrato->Fecha_Inicio = $request->FechaInicioM;
	        	$Contrato->Fecha_Fin = $request->FechaFinM;
	        	$Contrato->Fecha_Terminacion_Anticipada = $request->FechaFinAnticipadoM;
	        	$Contrato->Meses_Duracion = $request->Meses_DuracionM;
	        	$Contrato->Dias_Duracion = $request->Dias_DuracionM;
	        	$Contrato->Otra_Duracion = $request->Otra_DuracionM;	        	
	        	$Contrato->Valor_Inicial = $request->Valor_InicialM;
	        	$Contrato->Valor_Mensual = $request->Valor_MensualM;

	        	if($Contrato->save()){

	        		$AdicionD = Adicion::where('Contrato_Id', $request->Id_ContratoM)->delete();
	        		$AdicionVector = json_decode($request['Adicion']);
					if(count($AdicionVector) > 0){		
						foreach($AdicionVector as $Vector){
							$Adicion = new Adicion;
							$Adicion->Contrato_Id = $Contrato->Id;
							$Adicion->Numero_Adicion = $Vector->Numero_Adicion;
							$Adicion->Valor_Adicion = $Vector->Valor_Adicion;
							$Adicion->save();
						}
					}

					$ProrrogaD = Prorroga::where('Contrato_Id', $request->Id_ContratoM)->delete();
					$ProrrogaVector = json_decode($request['Prorroga']);
					if(count($ProrrogaVector) > 0){		
						foreach($ProrrogaVector as $Vector){
							$Prorroga = new Prorroga;
							$Prorroga->Contrato_Id = $Contrato->Id;
							$Prorroga->Numero_Prorroga = $Vector->Numero_Prorroga;
							$Prorroga->Meses = $Vector->Meses_Prorroga;
							$Prorroga->Dias = $Vector->Dias_Prorroga;
							$Prorroga->Fecha_Fin = $Vector->FechaFinCtoProrroga;
							$Prorroga->save();
						}
					}  

					$SuspencionD = Suspencion::where('Contrato_Id', $request->Id_ContratoM)->delete();
					$SuspencionVector = json_decode($request['Suspencion']);
					if(count($SuspencionVector) > 0){	
						foreach($SuspencionVector as $Vector){
							$Suspencion = new Suspencion;
							$Suspencion->Contrato_Id = $Contrato->Id;
							$Suspencion->Numero_Suspencion = $Vector->Numero_Suspencion;
							//$Suspencion->Objeto_Suspension = $Vector->Objeto_Suspencion;
							$Suspencion->Meses = $Vector->Meses_Suspencion;
							$Suspencion->Dias = $Vector->Dias_Suspencion;
							$Suspencion->Fecha_Inicio = $Vector->FechaInicioSuspencion;
							$Suspencion->Fecha_Fin = $Vector->FechaFinSuspencion;
							$Suspencion->Fecha_Reinicio = $Vector->FechaReinicioSuspencion;
							$Suspencion->save();
						}
					}

					$CesionD = Cesion::where('Contrato_Id', $request->Id_ContratoM)->delete();
					$CesionVector = json_decode($request['Cesion']);
					if(count($CesionVector) > 0){			
						foreach($CesionVector as $Vector){
							$Cesion = new Cesion;
							$Cesion->Contrato_Id = $Contrato->Id;
							$Cesion->Numero_Cesion = $Vector->Numero_Cesion;
							$Cesion->Nombre_Cesionario = $Vector->Nombre_Cesionario;							
							$Cesion->Tipo_Documento_Cesionario = $Vector->Tipo_Documento_Cesionario;
							$Cesion->Cedula_Cesionario = $Vector->Cedula_Cesionario;
							$Cesion->Dv_Cesion = $Vector->Dv_Cesion;
							$Cesion->Valor_Cedido = $Vector->Valor_Cesion;
							$Cesion->Fecha_Cesion = $Vector->FechaCesion;
							$Cesion->save();
						}
					}	

					$ObligacionD = Obligacion::where('Contrato_Id', $request->Id_ContratoM)->delete();
					$ObligacionVector = json_decode($request['Obligacion']);
					if(count($ObligacionVector) > 0){			
						foreach($ObligacionVector as $Vector){
							$Obligacion = new Obligacion;
							$Obligacion->Contrato_Id = $Contrato->Id;
							$Obligacion->Numero_Obligacion = $Vector->Numero_Obligacion;
							$Obligacion->Objeto_Obligacion = $Vector->Obligacion;							
							$Obligacion->save();
						}
					}
	        	}

	        	return response()->json(array('status' => 'success', 'Mensaje' => 'El contrato ha sido modificado con éxito!'));
			}
		}else{
			return response()->json(["Sin acceso"]);
		}
	}

	public function RevisionAdicionM(Request $request){
		if ($request->ajax()) { 
    		$validator = Validator::make($request->all(), [
    			'Valor_AdicionM' => 'required|numeric',
    			]);

	        if ($validator->fails()){
	            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
	        }else{        			
	        	return response()->json(array('status' => 'success', 'OK' => 'OK'));
			}
		}else{
			return response()->json(["Sin acceso"]);
		}
	}

	public function RevisionProrrogaM(Request $request){
		if ($request->ajax()) { 
    		$validator = Validator::make($request->all(), [
    			'Meses_ProrrogaM' => 'required|numeric',
    			'Dias_ProrrogaM' => 'required|numeric',
    			'FechaFinCtoProrrogaM' => 'required|date'
    			]);

	        if ($validator->fails()){
	            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
	        }else{        			
	        	return response()->json(array('status' => 'success', 'OK' => 'OK'));
			}
		}else{
			return response()->json(["Sin acceso"]);
		}
	}

	public function RevisionSuspencionM(Request $request){
		if ($request->ajax()) { 
    		$validator = Validator::make($request->all(), [
    			//'Objeto_SuspencionM' => 'required',
    			'Meses_SuspencionM' => 'required|numeric',
    			'Dias_SuspencionM' => 'required|numeric',
    			'FechaInicioSuspencionM' => 'required|date',
    			'FechaFinSuspencionM' => 'required|date',
    			'FechaReinicioSuspencionM' => 'required|date'    			
    			]);

	        if ($validator->fails()){
	            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
	        }else{        			
	        	return response()->json(array('status' => 'success', 'OK' => 'OK'));
			}
		}else{
			return response()->json(["Sin acceso"]);
		}
	}

	public function RevisionCesionM(Request $request){
		if ($request->ajax()) { 

			$var = '';
			if($request->Tipo_Documento_CesionM == 1 || $request->Tipo_Documento_CesionM == 2 || $request->Tipo_Documento_CesionM == 3 || $request->Tipo_Documento_CesionM == 7){
				$var = '|numeric|digits_between:1,15';
			}elseif($request->Tipo_Documento_CesionM == 4 || $request->Tipo_Documento_CesionM == 5 || $request->Tipo_Documento_CesionM == 6){
				$var = '|alpha_num';
			}else{
				$var = '';
			}

    		$validator = Validator::make($request->all(), [
    			'Nombre_CesionarioM' => 'required',
    			'Tipo_Documento_CesionM' => 'required',
    			'Cedula_CesionarioM' => 'required|numeric',
    			'Dv_CesionM' => array('required_if:Tipo_Documento_Cesion,7', 'numeric'),
    			'Valor_CesionM' => 'required|numeric',
    			'FechaCesionM' => 'required|date',
    			]);

	        if ($validator->fails()){
	            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
	        }else{        			
	        	return response()->json(array('status' => 'success', 'OK' => 'OK'));
			}
		}else{
			return response()->json(["Sin acceso"]);
		}
	}

	public function RevisionObligacionM(Request $request){
		if ($request->ajax()) { 
    		$validator = Validator::make($request->all(), [
    			'ObligacionM' => 'required',
    			]);

	        if ($validator->fails()){
	            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
	        }else{        			
	        	return response()->json(array('status' => 'success', 'OK' => 'OK'));
			}
		}else{
			return response()->json(["Sin acceso"]);
		}
	}

	public function EliminarContrato(Request $request){
		if ($request->ajax()) { 
    		$validator = Validator::make($request->all(), [
			   	  "Id" => "required|numeric",
    			]);    		

	        if ($validator->fails()){
	            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
	        }else{ 	        
	        	$Contrato = Contrato::find($request->Id);
	        	$Adicion = Adicion::where('Contrato_Id', $request->Id_Contrato)->delete();
	        	$Prorroga = Prorroga::where('Contrato_Id', $request->Id_Contrato)->delete();
	        	$Suspencion = Suspencion::where('Contrato_Id', $request->Id_Contrato)->delete();
	        	$Cesion = Cesion::where('Contrato_Id', $request->Id_Contrato)->delete();
	        	$Obligacion = Obligacion::where('Contrato_Id', $request->Id_Contrato)->delete();

	        	$Contrato->delete();
	        	
	        	return response()->json(array('status' => 'success', 'Mensaje' => 'El contrato ha sido eliminado con éxito!'));
			}
		}else{
			return response()->json(["Sin acceso"]);
		}
	}
}
