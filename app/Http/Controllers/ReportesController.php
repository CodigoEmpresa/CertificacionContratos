<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Idrd\Usuarios\Repo\PersonaInterface;
use Validator;
use Exception;

use App\Models\ExpedicionContrato;
use App\Models\Contrato;

class ReportesController extends Controller
{
	public function __construct(PersonaInterface $repositorio_personas)
	{
		if (isset($_SESSION['Usuario']))
			$this->Usuario = $_SESSION['Usuario'];

		$this->repositorio_personas = $repositorio_personas;
	}

    public function index()
	{
		return view('DATOS/reporte_expedicion')
				;
	}

	public function ReporteExpedicion(Request $request){
		if ($request->ajax()) { 
			$validator = Validator::make($request->all(), [
    			'FechaInicio' => 'required|date',
    			'FechaFin' => 'required|date|after:FechaInicio',
    			]);

			$html = '';

	        if ($validator->fails()){
	            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
	        }else{        		
	        	$ExpedicionContrato = ExpedicionContrato::with('contrato')->whereBetween('created_at', array($request->FechaInicio.' 00:00:00', $request->FechaFin.' 23:59:59'))->get();
	        	if(count($ExpedicionContrato) > 0){
	        		foreach ($ExpedicionContrato as $key => $Datos) {

	        			if(isset($Datos->contrato->Cedula)){
	        				$html .= '<tr>
	        						<td>'.$Datos->contrato->Cedula.'</td>
	        						<td>'.$Datos->Nombre_Expedicion.'</td>
	        						<td>'.$Datos->created_at.'</td>
	        					</tr>';
	        			}
	        		}
	        		$Resultado = "<table id='datosTabla' name='datosTabla'>
			        <thead>
			            <tr>
							<th>CÉDULA</th>                        
	                        <th>CÓDIGO</th>
	                        <th>FECHA DE DESCARGA</th>
						</tr>
					</thead>
						<tbody>".$html."</tbody></table>";
	        		return response()->json(array('status' => 'success', 'datos' => $Resultado));	
	        	}else{
	        		return response()->json(array('status' => 'No hay datos', 'datos' => 'No hay datos'));
	        	}
			}
		}else{
			return response()->json(["Sin acceso"]);
		}
	}

	public function indexCodigo(Request $request){
		return view('DATOS/reporte_codigo');
	}

	public function GetReporteCodigo (Request $request){
		if ($request->ajax()) { 
			$validator = Validator::make($request->all(), [
    			'Codigo1' => 'required|numeric',
    			'Codigo2' => 'required|numeric',
    			'Codigo3' => 'required|numeric',
    			]);
			$html = '';
	        if ($validator->fails()){
	            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
	        }else{
	        	$ExpedicionContrato = ExpedicionContrato::where('Nombre_Expedicion', $request->Codigo1.'-'.$request->Codigo2.'-'.$request->Codigo3)->get();
	        	if(count($ExpedicionContrato) >= 1){
	        		$Contrato = Contrato::find($ExpedicionContrato[0]->Contrato_Id);
	        		$html = 
	        		'<div class="panel panel-primary">
		                <div class="panel-heading">
		                  <h3 class="panel-title">Detalle de la expedición de contrato</h3>
		                </div>
		                <div class="panel-body">'.
			        		'<div class="row">'.
			        			'<div class="form-group col-md-2">'.
		                            '<label for="inputEmail" class="control-label">Número de contrato:</label>'.
		                        '</div>'.
		                        '<div class="form-group col-md-4">'.
		                            '<label>'.$Contrato['Numero_Contrato'].'</label>'.
		                        '</div> '.
		                        '<div class="form-group col-md-2">'.
		                            '<label for="inputEmail" class="control-label">Nombre contratista:</label>'.
		                        '</div>'.
		                        '<div class="form-group col-md-4">'.
		                            '<label>'.$Contrato['Nombre_Contratista'].'</label>'.
		                        '</div> '.
		                    '</div>'.
		                    '<div class="row">'.
		                        '<div class="form-group col-md-2">'.
		                            '<label for="inputEmail" class="control-label">Número documento:</label>'.
		                        '</div>'.
		                        '<div class="form-group col-md-4">'.
		                            '<label>'.$Contrato['Cedula'].'</label>'.
		                        '</div> '.                        
		                        '<div class="form-group col-md-2">'.
		                            '<label for="inputEmail" class="control-label">Fecha inicio:</label>'.
		                        '</div>'.
		                        '<div class="form-group col-md-4">'.
		                            '<label>'.$Contrato['Fecha_Inicio'].'</label>'.
		                        '</div> '.      
		                    '</div>'.
		                    '<div class="row">'.                  
		                        '<div class="form-group col-md-2">'.
		                            '<label for="inputEmail" class="control-label">Fecha generación de descarga:</label>'.
		                        '</div>'.
		                        '<div class="form-group col-md-4">'.
		                            '<label>'.$ExpedicionContrato[0]->created_at.'</label>'.
		                        '</div> '.
		                    '</div>'.
	                    '</div> '.
                    '</div> ';
	        		return response()->json(array('status' => 'success', 'datosExpedicionContrato' => $ExpedicionContrato[0], 'datosContrato' => $html));
	        	}else{
	        		return response()->json(array('status' => 'Error', 'Mensaje' => 'No se encontraron descargas con el código digato, por favor intentelo nuevamente!'));
	        	}
			}
		}else{
			return response()->json(["Sin acceso"]);
		}
	}
}