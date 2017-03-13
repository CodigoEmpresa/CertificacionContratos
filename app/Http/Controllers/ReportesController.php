<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Idrd\Usuarios\Repo\PersonaInterface;
use Validator;
use Exception;

use App\Models\ExpedicionContrato;
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
	        	$ExpedicionContrato = ExpedicionContrato::with('contrato')->whereBetween('created_at', array($request->FechaInicio, $request->FechaFin))->get();
	        	if(count($ExpedicionContrato) > 0){
	        		foreach ($ExpedicionContrato as $key => $Datos) {
	        			$html .= '<tr>
	        						<td>'.$Datos->contrato->Cedula.'</td>
	        						<td>'.$Datos->Nombre_Expedicion.'</td>
	        						<td>'.$Datos->created_at.'</td>
	        					</tr>';
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
}