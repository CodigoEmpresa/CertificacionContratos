<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Idrd\Usuarios\Repo\PersonaInterface;
use Validator;
use Exception;

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

	        if ($validator->fails()){
	            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
	        }else{        			
	        	return response()->json(array('status' => 'success', 'OK' => 'OK'));
			}
		}else{
			return response()->json(["Sin acceso"]);
		}
	}
}
