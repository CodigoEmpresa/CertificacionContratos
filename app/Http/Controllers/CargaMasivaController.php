<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Idrd\Usuarios\Repo\PersonaInterface;
use Validator;
use Exception;
use Excel;
use Carbon\Carbon;

use App\Models\Contrato;
use App\Models\Adicion;
use App\Models\Prorroga;
use App\Models\Suspencion;
use App\Models\Cesion;
use App\Models\Obligacion;
use App\Models\Integrante;


class CargaMasivaController extends Controller
{
    public function __construct(PersonaInterface $repositorio_personas)
	{
		if (isset($_SESSION['Usuario']))
			$this->Usuario = $_SESSION['Usuario'];

		$this->repositorio_personas = $repositorio_personas;
	}

    public function index()
	{
		return view('DATOS/carga');
	}
	public function CargaArchivo(Request $request){

		/*$dbhost = 'http://www.idrd.gov.co';
		$dbname = 'idrdgov_simgeneral_prueba';
		$dbuser = 'idrdgov_dep2016';
		$dbpass = 'W_L[[c)_J*xp';
		 
		$backup_file = $dbname. "-" .date("Y-m-d-H-i-s"). ".sql";
		 
		// comandos a ejecutar
		$commands = array(
		        "mysqldump --opt -h $dbhost -u $dbuser -p$dbpass -v $dbname > $backup_file",
		      "bzip2 $backup_file"
		);
		 
		// ejecución y salida de éxito o errores
		foreach ( $commands as $command ) {
		        system($command,$output);
		        var_dump($commands);
		        echo $output;
		}*/

		$validator = Validator::make($request->all(),
            [                
                'ArchivoCM' => 'required|mimes:xls',
            ]
        );

        if ($validator->fails()){
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
        }else{
        	$DatosArchivos = Excel::load($request->ArchivoCM, function($reader) {})->get();

        	if($DatosArchivos->count() == 0){
        		return response()->json(array('status' => 'errorCarga', 'mensaje' => 'No existen registros para realizar la carga de información!'));           
        	}

        	$resultadoContratoSI = '';
        	$resultadoContrato = '';

        	$ListaErrorContrato = '';
        	$ListaErrorAdicion = '';


        	foreach ($DatosArchivos as $key => $DatosArchivo) {        		
        		try {        			
        			 $ContratoEx = Contrato::where('Cedula', $DatosArchivo->cedula)->where('Numero_Contrato', $DatosArchivo->n0_contrato)->get();        		

        			 if(count($ContratoEx) == 0){
		        		$Contrato = new Contrato;
		        		$Contrato->Tipo_Documento = $DatosArchivo->tipo_doc;	
			        	$Contrato->Cedula = $DatosArchivo->cedula;
			        	$Contrato->Dv = $DatosArchivo->dv;
			        	$Contrato->Nombre_Contratista = $DatosArchivo->contratista;
			        	$Contrato->Numero_Contrato = $DatosArchivo->n0_contrato;
			        	$Contrato->Tipo_Contrato_Id = (int)$DatosArchivo->tipo_contrato;
			        	$Contrato->Nombre_Representante = $DatosArchivo->representante_legal;
			        	$Contrato->Tipo_Documento_Representante = $DatosArchivo->tipo_doc_rep_legal;
			        	$Contrato->Cedula_Representante = $DatosArchivo->cedula_representante;
			        	$Contrato->Objeto = $DatosArchivo->objeto;
			        	$Contrato->Fecha_Firma = $DatosArchivo->fecha_firma_del_contrato;
			        	$Contrato->Fecha_Inicio = $DatosArchivo->fecha_inicio;
			        	$Contrato->Fecha_Fin = $DatosArchivo->fecha_final;
			        	$Contrato->Fecha_Terminacion_Anticipada = $DatosArchivo->fecha_terminacion_anticipada;
			        	$Contrato->Meses_Duracion = $DatosArchivo->meses_duracion;
			        	$Contrato->Dias_Duracion = $DatosArchivo->dias_duracion;
			        	$Contrato->Otra_Duracion = $DatosArchivo->otra_forma_de_duracion_equivalente;
			        	$Contrato->Valor_Inicial = $DatosArchivo->valor_inicial_contrato;
			        	$Contrato->Valor_Mensual = $DatosArchivo->valor_mensual;

			        	if($Contrato->save()){
			        		$resultadoContratoSI .= 'El contrato número '. $DatosArchivo->n0_contrato. ' SI pudo ser registrado';		        			

			        		$j = 0;	
			        		while($j<=5){
				        		$j++;
				        		try {			        			
				        			$variable = 'adicion'.$j;
				        			if($DatosArchivo->$variable != '' || $DatosArchivo->$variable != 0){
				        				if(is_numeric($DatosArchivo->$variable)) {
						        			$Adicion = new Adicion;
											$Adicion->Contrato_Id = $Contrato->Id;
											$Adicion->Numero_Adicion = $j;
											$Adicion->Valor_Adicion = $DatosArchivo->$variable;		
											$Adicion->save();
										}else{
											$ListaErrorAdicion .= 'Cesion contrato # '.$DatosArchivo->n0_contrato;
										}
					        		}
				        		} catch (\Illuminate\Database\QueryException $e) {
				        			$ListaErrorAdicion .= 'Cesion contrato # '.$DatosArchivo->n0_contrato;
					        		continue;
					        	}
				        	}	

				        	$VarI = 0;	
			        		while($VarI<=5){
				        		$VarI++;
				        		try {	
				        			$Nombre_Integrante = 'nombre_integrante'.$VarI;
				        			$Tipo_Doc_Integrante = 'tipo_doc_integrante'.$VarI;
				        			$Documento_Integrante = 'documento_integrante'.$VarI;
				        			$Porcentaje_Integrante = 'porcentaje_integrante'.$VarI;

				        			$Integrante = new Integrante;
				        			$Integrante->Contrato_Id = $Contrato->Id;
									$Integrante->Nombre_Integrante = $DatosArchivo->$Nombre_Integrante;
									$Integrante->Tipo_Documento_Integrante_Id = $DatosArchivo->$Tipo_Doc_Integrante;
									$Integrante->Documento_Integrante = $DatosArchivo->$Documento_Integrante;
									$Integrante->Porcentaje_Integrante = $DatosArchivo->$Porcentaje_Integrante;
									$Integrante->save();		        			
				        			
				        		} catch (\Illuminate\Database\QueryException $e) {
				        			
					        		continue;
					        	}
				        	}	
							
				        	$VarS = 0;       		        		
			        		while($VarS<=5){
				        		$VarS++;
				        		try{
				        			$variableMesesSusp = 'susp'.$VarS.'_meses';
				        			$variableDiasSusp = 'susp'.$VarS.'_dias';
				        			$variableFechaInicioSusp = 'fecha_inicio_s'.$VarS;
				        			$variableFechaFinSusp = 'fecha_fin_s'.$VarS;
				        			$variableFechaReinicioSusp = 'reinicio'.$VarS;
				        			$variableFechaCTOSusp = 'fecha_fin_cto_s'.$VarS;			        			

				        			if($DatosArchivo->$variableMesesSusp != '' || $DatosArchivo->$variableMesesSusp != null){
		        						if($DatosArchivo->$variableDiasSusp != '' || $DatosArchivo->$variableDiasSusp != null){
		        							$Suspencion = new Suspencion;
											$Suspencion->Contrato_Id = $Contrato->Id;
											$Suspencion->Numero_Suspencion = $VarS;
											$Suspencion->Meses = $DatosArchivo->$variableMesesSusp;
											$Suspencion->Dias = $DatosArchivo->$variableDiasSusp;
											$Suspencion->Fecha_Inicio = $DatosArchivo->$variableFechaInicioSusp;
											$Suspencion->Fecha_Fin = $DatosArchivo->$variableFechaFinSusp;
											$Suspencion->Fecha_Reinicio = $DatosArchivo->$variableFechaReinicioSusp;
											$Suspencion->Fecha_Fin_CTO = $DatosArchivo->$variableFechaCTOSusp;		
						        			
										}else{
				        					$Suspencion = new Suspencion;
											$Suspencion->Contrato_Id = $Contrato->Id;
											$Suspencion->Numero_Suspencion = $VarS;
											$Suspencion->Meses = $DatosArchivo->$variableMesesSusp;
											$Suspencion->Dias = 0;
											$Suspencion->Fecha_Inicio = $DatosArchivo->$variableFechaInicioSusp;
											$Suspencion->Fecha_Fin = $DatosArchivo->$variableFechaFinSusp;
											$Suspencion->Fecha_Reinicio = $DatosArchivo->$variableFechaReinicioSusp;
											$Suspencion->Fecha_Fin_CTO = $DatosArchivo->$variableFechaCTOSusp;
					        			}								        			
				        			}else{
			        					$Suspencion = new Suspencion;
										$Suspencion->Contrato_Id = $Contrato->Id;
										$Suspencion->Numero_Suspencion = $VarS;
										$Suspencion->Meses = 0;
										$Suspencion->Dias = $DatosArchivo->$variableDiasSusp;
										$Suspencion->Fecha_Inicio = $DatosArchivo->$variableFechaInicioSusp;
										$Suspencion->Fecha_Fin = $DatosArchivo->$variableFechaFinSusp;
										$Suspencion->Fecha_Reinicio = $DatosArchivo->$variableFechaReinicioSusp;
										$Suspencion->Fecha_Fin_CTO = $DatosArchivo->$variableFechaCTOSusp;
				        			}
				        			if($Suspencion->save()){
				        			}else{

				        			}
			        			} catch (\Illuminate\Database\QueryException $e) {		        				
					        		continue;
					        	}
			        		}
				        	
				        	$k = 0;	
			        		while($k<=5){
				        		$k++;	
				        		try{
				        			$variableMeses = 'prorroga'.$k.'_meses';
				        			$variableDias = 'prorroga'.$k.'_dias';
				        			$variableFecha = 'fecha_fin_cto_p'.$k;
				        			
		        					if($DatosArchivo->$variableMeses != '' || $DatosArchivo->$variableMeses != null){
		        						if($DatosArchivo->$variableDias != '' || $DatosArchivo->$variableDias != null){
		        							$Prorroga = new Prorroga;
											$Prorroga->Contrato_Id = $Contrato->Id;
											$Prorroga->Numero_Prorroga = $k;
											$Prorroga->Meses = $DatosArchivo->$variableMeses;
											$Prorroga->Dias = $DatosArchivo->$variableDias;
											$Prorroga->Fecha_Fin = $DatosArchivo->$variableFecha;
						        			
										}else{
				        					$Prorroga = new Prorroga;
											$Prorroga->Contrato_Id = $Contrato->Id;
											$Prorroga->Numero_Prorroga = $k;
											$Prorroga->Meses = $DatosArchivo->$variableMeses;
											$Prorroga->Dias = 0;
											$Prorroga->Fecha_Fin = $DatosArchivo->$variableFecha;
					        			}								        			
				        			}else{
			        					$Prorroga = new Prorroga;
										$Prorroga->Contrato_Id = $Contrato->Id;
										$Prorroga->Numero_Prorroga = $k;
										$Prorroga->Meses = 0;
										$Prorroga->Dias = $DatosArchivo->$variableDias;
										$Prorroga->Fecha_Fin = $DatosArchivo->$variableFecha;
				        			}
				        			$Prorroga->save();
			        			} catch (\Illuminate\Database\QueryException $e) {
			        				//$ListaErrorProrroga .= '-Prorroga del Contrato-numero'.$k.'-'.$DatosArchivo->n0_contrato;
					        		continue;
					        	}	
							}	

							$VarO = 0;	
			        		while($VarO<=40){
				        		$VarO++;	
				        		try{
				        			$VarObligacion = 'obligacion'.$VarO;	
				        			if($DatosArchivo->$VarObligacion != '' || $DatosArchivo->$VarObligacion != null){
					        			$Obligacion =  new Obligacion;
					        			$Obligacion->Contrato_Id = $Contrato->Id;
										$Obligacion->Numero_Obligacion = $VarO;
										$Obligacion->Objeto_Obligacion = $DatosArchivo->$VarObligacion;
										$Obligacion->save();        			
									}
		        					
			        			} catch (\Illuminate\Database\QueryException $e) {
			        				//$ListaErrorObligacion .= '-Obligacion del Contrato-numero'.$VarO.'-'.$DatosArchivo->n0_contrato;
					        		continue;
					        	}			        	
							}	

							try{
			        			$Cesion = new Cesion;
								$Cesion->Contrato_Id = $Contrato->Id;
								$Cesion->Numero_Cesion = 1;
								$Cesion->Nombre_Cesionario = $DatosArchivo->nombre_cesionario;			
								$Cesion->Tipo_Documento_Cesionario = $DatosArchivo->tipo_doc_cesion;
								$Cesion->Cedula_Cesionario = $DatosArchivo->cedula_cesionario;
								$Cesion->Dv_Cesion = $DatosArchivo->dv_cesion;
								$Cesion->Valor_Cedido = $DatosArchivo->valor_cedido;
								$Cesion->Fecha_Cesion = $DatosArchivo->fecha_cesion;
								$Cesion->save();		        			

		        			} catch (\Illuminate\Database\QueryException $e) {
		        				//$ListaErrorCesion .= '-Cesion del Contrato'.$DatosArchivo->n0_contrato;
				        		continue;
				        	}
								        	
			        	}else{
			        		//$resultadoContrato .= 'El contrato número '. $DatosArchivo->n0_contrato. ' no pudo ser registrado';
			        	}

        			 }else{
        			 	if($DatosArchivo->n0_contrato == ''){
			        		$N_Contrato = 'NO EXISTE';
			        	}else{
			        		$N_Contrato = $DatosArchivo->n0_contrato;
			        	}

			        	if($DatosArchivo->cedula == ''){
			        		$N_Cedula = 'NO EXISTE';
			        	}else{
			        		$N_Cedula = $DatosArchivo->cedula;
			        	}

			        	if($DatosArchivo->contratista == ''){
			        		$N_Contratista = 'NO EXISTE';
			        	}else{
			        		$N_Contratista = $DatosArchivo->contratista;
			        	}
        			 	$ListaErrorContrato .= '-El contrato número: '.$N_Contrato.' con documento de contratista número: '.$N_Cedula.', con el contratista: '.$N_Contratista.', Ya se encuentra en la base de datos.<br>';
        			 }

		        } catch (\Illuminate\Database\QueryException $e) {
		        	if($DatosArchivo->n0_contrato == ''){
		        		$N_Contrato = 'NO EXISTE';
		        	}else{
		        		$N_Contrato = $DatosArchivo->n0_contrato;
		        	}

		        	if($DatosArchivo->cedula == ''){
		        		$N_Cedula = 'NO EXISTE';
		        	}else{
		        		$N_Cedula = $DatosArchivo->cedula;
		        	}

		        	if($DatosArchivo->contratista == ''){
		        		$N_Contratista = 'NO EXISTE';
		        	}else{
		        		$N_Contratista = $DatosArchivo->contratista;
		        	}
		        	$ListaErrorContrato .= '-El contrato número: '.$N_Contrato.' con documento de contratista número: '.$N_Cedula.', con el contratista: '.$N_Contratista.'<br>';
		        	continue;
		        }	

	        }	        
	        if($ListaErrorContrato != ''){
	        	return response()->json(array('status' => 'errorCarga', 'mensaje' => $ListaErrorContrato));           
	        }else{	        
        		return response()->json(array('status' => 'ok', 'mensaje' => 'No hay'));           
        	}          
        }
	}
}
