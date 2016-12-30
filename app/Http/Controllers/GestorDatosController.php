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
}
