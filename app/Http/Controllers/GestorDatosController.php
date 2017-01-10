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
		$Contrato = Contrato::all();
		$TipoContrato = TipoContrato::all();
		return view('DATOS/gestor')
				->with(compact('Contrato'))
				->with(compact('TipoContrato'))
				;
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
    			'Objeto_Suspencion' => 'required',
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
    		$validator = Validator::make($request->all(), [
    			'Nombre_Cesionario' => 'required',
    			'Cedula_Cesionario' => 'required|numeric',
    			'Dv_Cesion' => 'required|numeric',
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
    		$validator = Validator::make($request->all(), [
			   	  "Cedula_Contratista" => "required|numeric|digits_between:1,15",
				  "Dv" => "required|numeric|digits:1",
				  "Nombre_Contratista" => "required",
				  "Numero_Contrato" => "required|numeric|digits_between:1,10",
				  "Tipo_Contrato" => "required",
				  "Nombre_Representante" => "required",
				  "Cedula_Representante" => "required|numeric|digits_between:1,15",
				  "Objeto_Contrato" => "required|between:1,100",
				  "FechaFirma" => "required|date",
				  "FechaInicio" => "required|date",
				  "FechaFin" => "required|date",
				  "FechaFinAnticipado" => "required|date",
				  "FechaFinContrato" => 'required|date',
				  "Meses_Duracion" => "required|numeric:|digits_between:1,4",
				  "Dias_Duracion" => "required|numeric:|digits_between:1,4",
				  "Otra_Duracion" => "required",
				  "Valor_Inicial" => "required|numeric:|digits_between:1,15",
				  "Valor_Mensual" => "required|numeric:|digits_between:1,8",				  
    			]);    		

	        if ($validator->fails()){
	            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
	        }else{ 

	        	$Contrato = new Contrato;
	        	$Contrato->Cedula = $request->Cedula_Contratista;
	        	$Contrato->Dv = $request->Dv;
	        	$Contrato->Nombre_Contratista = $request->Nombre_Contratista;
	        	$Contrato->Numero_Contrato = $request->Numero_Contrato;
	        	$Contrato->Tipo_Contrato_Id = $request->Tipo_Contrato;
	        	$Contrato->Nombre_Representante = $request->Nombre_Representante;
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
	        	$Contrato->fecha_Final_CTO = $request->FechaFinContrato;

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
							$i+1;
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
							$i+1;
						}
					}

					$SuspencionVector = json_decode($request['Suspencion']);
					if(count($SuspencionVector) > 0){	
						$i = 1;					
						foreach($SuspencionVector as $Vector){
							$Suspencion = new Suspencion;
							$Suspencion->Contrato_Id = $Contrato->Id;
							$Suspencion->Numero_Suspencion = $i;
							$Suspencion->Objeto_Suspension = $Vector->Objeto_Suspencion;
							$Suspencion->Meses = $Vector->Meses_Suspencion;
							$Suspencion->Dias = $Vector->Dias_Suspencion;
							$Suspencion->Fecha_Inicio = $Vector->FechaInicioSuspencion;
							$Suspencion->Fecha_Fin = $Vector->FechaFinSuspencion;
							$Suspencion->Fecha_Reinicio = $Vector->FechaReinicioSuspencion;
							$Suspencion->save();
							$i+1;
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
							$Cesion->Cedula_Cesionario = $Vector->Cedula_Cesionario;
							$Cesion->Dv_Cesion = $Vector->Dv_Cesion;
							$Cesion->Valor_Cedido = $Vector->Valor_Cesion;
							$Cesion->Fecha_Cesion = $Vector->FechaCesion;
							$Cesion->save();
							$i+1;
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
							$i+1;
						}
					}
	        	}

	        	return response()->json(array('status' => 'success', 'Mensaje' => 'El contrato ha sido agregado con éxito!'));
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
		$Contrato = Contrato::with('Tipocontrato', 'Adicion', 'Prorroga', 'Suspencion', 'Cesion', 'Obligacion')->find($id_contrato);
		return $Contrato;
	}

	public function ModificarContrato(Request $request){
		//dd($request->all());
		if ($request->ajax()) { 
    		$validator = Validator::make($request->all(), [
			   	  "Cedula_ContratistaM" => "required|numeric|digits_between:1,15",
				  "DvM" => "required|numeric|digits:1",
				  "Nombre_ContratistaM" => "required",
				  "Numero_ContratoM" => "required|numeric|digits_between:1,10",
				  "Tipo_ContratoM" => "required",
				  "Nombre_RepresentanteM" => "required",
				  "Cedula_RepresentanteM" => "required|numeric|digits_between:1,15",
				  "Objeto_ContratoM" => "required|between:1,100",
				  "FechaFirmaM" => "required|date",
				  "FechaInicioM" => "required|date",
				  "FechaFinM" => "required|date",
				  "FechaFinAnticipadoM" => "required|date",
				  "FechaFinContratoM" => 'required|date',
				  "Meses_DuracionM" => "required|numeric:|digits_between:1,4",
				  "Dias_DuracionM" => "required|numeric:|digits_between:1,4",
				  "Otra_DuracionM" => "required",
				  "Valor_InicialM" => "required|numeric:|digits_between:1,15",
				  "Valor_MensualM" => "required|numeric:|digits_between:1,8",			  
    			]);    		

	        if ($validator->fails()){
	            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
	        }else{ 
	        	$Contrato = Contrato::find($request->Id_ContratoM);
	        	$Contrato->Cedula = $request->Cedula_ContratistaM;
	        	$Contrato->Dv = $request->DvM;
	        	$Contrato->Nombre_Contratista = $request->Nombre_ContratistaM;
	        	$Contrato->Numero_Contrato = $request->Numero_ContratoM;
	        	$Contrato->Tipo_Contrato_Id = $request->Tipo_ContratoM;
	        	$Contrato->Nombre_Representante = $request->Nombre_RepresentanteM;
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
	        	$Contrato->fecha_Final_CTO = $request->FechaFinContratoM;

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
							$Suspencion->Objeto_Suspension = $Vector->Objeto_Suspencion;
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
    			'Objeto_SuspencionM' => 'required',
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
    		$validator = Validator::make($request->all(), [
    			'Nombre_CesionarioM' => 'required',
    			'Cedula_CesionarioM' => 'required|numeric',
    			'Dv_CesionM' => 'required|numeric',
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
	        	$Adicion = Adicion::where('Contrato_Id', $request->Id_ContratoM)->delete();
	        	$Prorroga = Prorroga::where('Contrato_Id', $request->Id_ContratoM)->delete();
	        	$Suspencion = Suspencion::where('Contrato_Id', $request->Id_ContratoM)->delete();
	        	$Cesion = Cesion::where('Contrato_Id', $request->Id_ContratoM)->delete();
	        	$Obligacion = Obligacion::where('Contrato_Id', $request->Id_ContratoM)->delete();
	        	$Contrato->delete();
	        	
	        	return response()->json(array('status' => 'success', 'Mensaje' => 'El contrato ha sido eliminado con éxito!'));
			}
		}else{
			return response()->json(["Sin acceso"]);
		}
	}
}
