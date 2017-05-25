<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Idrd\Usuarios\Repo\PersonaInterface;
use Validator;
use Exception;

use Mail;

use App\Models\Soporte;
use App\Models\Persona;

class GestorSoporteController extends Controller
{
     public function __construct(PersonaInterface $repositorio_personas)
	{
		if (isset($_SESSION['Usuario']))
			$this->Usuario = $_SESSION['Usuario'];

		$this->repositorio_personas = $repositorio_personas;
	}

    public function index()
	{
		return view('DATOS/gestor_soporte');
	}

	public function GetSoportes(Request $request){
		$Soporte = Soporte::where('Estado', 1)->get();
		$html = '';
		$html .= '<table id="TablaDatos" name="TablaDatos" class="display nowrap" cellspacing="0" width="100%">'.
                    '<thead>'.
                        '<tr>'.
                            '<th>Número de soporte</th>'.
                            '<th>Nombre Solicitante</th>'.
                            '<th>Documento Solicitante</th>'.
                            '<th>Estado</th>'.
                            '<th>Fecha de Solicitud</th>'.
                            '<th>Opciones</th>'.
                        '</tr>'.
                    '</thead>'.
                    '<tbody>';

         foreach ($Soporte as $key => $value) {
         	$html .= '<tr>';
            $html .= '<td>'.$value['Id'].'</td>';
         	$html .= '<td>'.$value['Nombre_Solicitante'].'</td>';
         	$html .= '<td>'.$value['Documento_Solicitante'].'</td>';
         	if($value['Estado'] == 1){
         		$html .= '<td>Abierto</td>';
         	}elseif($value['Estado'] == 2){
         		$html .= '<td>Solucionado</td>';
         	}         	
         	$html .= '<td>'.$value['created_at'].'</td>';

         	if($value['Estado'] == 1){
         		$html .= '<td>'.
         				'<button type="button" class="btn-sm btn-warning" data-function="solucionSoporte" value="'.$value->Id.'" >
                            <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Responder soporte
                        </button>'.
                     '</td>';
         	}elseif($value['Estado'] == 2){
         		$html .= '<td>'.
         				'<button type="button" class="btn-sm btn-info" data-function="verSoporte" value="'.$value->Id.'" >
                            <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Ver soporte
                        </button>'.
                     '</td>';
         	}
         	
         	$html .= '</tr>';
         }

        $html .= '</tbody>';
        $html .= '</table>';
        return $html;
	}

	public function GetSoportesOnly(Request $request, $id_soporte){
		$Soporte = Soporte::find($id_soporte);
		return $Soporte;
	}

	public function ResponderSoporte(Request $request){
		if ($request->ajax()) { 
    		$validator = Validator::make($request->all(), [
    			'SolucionText' => 'required',
    			]);

	        if ($validator->fails()){
	            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
	        }else{
	        	$Soporte = Soporte::find($request->Soporte_Id);
	        	$Soporte->Estado = 2;
	        	$Soporte->Solucion = $request->SolucionText;
	        	if($Soporte->save()){
	        		$this->sendEmail($Soporte->Correo_Solicitante, $request->SolucionText, 'DATOS.correo', $Soporte->Descripcion_Solicitud, $Soporte->Id, $Soporte->created_at, $Soporte->Nombre_Solicitante);
	        		return response()->json(array('status' => 'success', 'Mensaje' => 'La solución  se ha almacenado correctamente!'));
	        	}else{
	        		return response()->json(array('status' => 'error2', 'Mensaje' => 'Ocurrio un error en el almacenamiento, por favor intentelo nuevamente!'));
	        	}	        	
			}
		}else{
			return response()->json(["Sin acceso"]);
		}
	}

	public function sendEmail($correo, $mensaje, $plantilla, $descripcion, $soporte_id, $fecha_solicitud, $nombres){
    	$datos[0] = $correo;
    	$datos[1] = $mensaje;
    	$datos[2] = $plantilla;
    	$datos[3] = $descripcion;
        $datos[4] = $soporte_id;
        $datos[5] = $fecha_solicitud;
        $datos[6] = $nombres;
        $datos[7] = $soporte_id.'-'.date('Y');

        $Persona = Persona::find($_SESSION['Usuario'][0]);
        $datos[8] = $Persona['Primer_Nombre'].' '.$Persona['Segundo_Nombre'].' '.$Persona['Primer_Apellido'].' '.$Persona['Segundo_Apellido'];
    	Mail::send($datos[2], ['mensaje' => $datos[1], 'descripcion' => $datos[3], "nombres" => $datos[6], "referencia" => $datos[7], "nombreFuncionario" => $datos[8]], function($message) use ($datos){			
		    $message->to($datos[0], 'IDRD')
		    		->subject('Solicitud No. '.$datos[4].'-'.date('Y').' ('.$datos[5].').');
		});
    }

     public function indexSolucionado()
    {
        return view('DATOS/gestor_soporte_solucionado');
    }

    public function GetSoportesSolucionados(Request $request){
        $Soporte = Soporte::where('Estado', 2)->get();
        $html = '';
        $html .= '<table id="TablaDatos" name="TablaDatos" class="display nowrap" cellspacing="0" width="100%">'.
                    '<thead>'.
                        '<tr>'.
                            '<th>Número de soporte</th>'.
                            '<th>Nombre Solicitante</th>'.
                            '<th>Documento Solicitante</th>'.
                            '<th>Estado</th>'.
                            '<th>Fecha de Solicitud</th>'.
                            '<th>Opciones</th>'.
                        '</tr>'.
                    '</thead>'.
                    '<tbody>';

         foreach ($Soporte as $key => $value) {
            $html .= '<tr>';
            $html .= '<td>'.$value['Id'].'</td>';
            $html .= '<td>'.$value['Nombre_Solicitante'].'</td>';
            $html .= '<td>'.$value['Documento_Solicitante'].'</td>';
            if($value['Estado'] == 1){
                $html .= '<td>Abierto</td>';
            }elseif($value['Estado'] == 2){
                $html .= '<td>Solucionado</td>';
            }           
            $html .= '<td>'.$value['created_at'].'</td>';

            if($value['Estado'] == 1){
                $html .= '<td>'.
                        '<button type="button" class="btn-sm btn-warning" data-function="solucionSoporte" value="'.$value->Id.'" >
                            <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Responder soporte
                        </button>'.
                     '</td>';
            }elseif($value['Estado'] == 2){
                $html .= '<td>'.
                        '<button type="button" class="btn-sm btn-info" data-function="verSoporte" value="'.$value->Id.'" >
                            <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Ver soporte
                        </button>'.
                     '</td>';
            }
            
            $html .= '</tr>';
         }

        $html .= '</tbody>';
        $html .= '</table>';
        return $html;
    }
}