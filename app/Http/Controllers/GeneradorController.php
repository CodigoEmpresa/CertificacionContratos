<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Idrd\Usuarios\Repo\PersonaInterface;
use Validator;
use Exception;

//use Vsmoraes\Pdf\Pdf;
use Barryvdh\DomPDF\Facade as PDF;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Models\TipoDocumento;
use App\Models\Contrato;
use App\Models\ExpedicionContrato;

class GeneradorController extends Controller
{

	private $pdf;

    /*public function __construct(Pdf $pdf)
    {
        $this->pdf = $pdf;
    }*/

    public function index()
	{
		$TipoDocumento = TipoDocumento::all();
		return view('DATOS/generadorPdf')
			   ->with(compact('TipoDocumento'))
				;
	}

	public function GetContratoExp(Request $request){		
		if ($request->ajax()) { 
			$var = 'required';
			if($request->Tipo_Documento == 1 || $request->Tipo_Documento == 2 || $request->Tipo_Documento == 3 || $request->Tipo_Documento == 7){
				$var = 'required|numeric|digits_between:1,15';
			}elseif($request->Tipo_Documento == 4 || $request->Tipo_Documento == 5 || $request->Tipo_Documento == 6){
				$var = 'required|alpha_num';
			}else{
				$var = 'required';
			}

    		$validator = Validator::make($request->all(), [
    			'Tipo_Documento' => 'required',
    			'Documento' => $var,
    			'Anio' => 'required'
    			]);

	        if ($validator->fails()){
	            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
	        }else{        			
	        	$Contrato = Contrato::where('Tipo_Documento', $request->Tipo_Documento)
	        						->where('Cedula', $request->Documento)
	        						->whereYear('Fecha_Firma','=', $request->Anio)
	        						->get();
				if(count($Contrato) == 0){
					return response()->json(array('status' => 'success', "Contrato" => "No hay"));
				}else if(count($Contrato) == 1){
					return response()->json(array('status' => 'success', "Contrato" => "Unico", "Id" => $Contrato[0]->Id));
				}else if(count($Contrato) > 1){
					return response()->json(array('status' => 'success', "Contrato" => "Varios", "DatosContrato" => $Contrato));
				}				
			}
		}else{
			return response()->json(["Sin acceso"]);
		}
	}

	public function GetContratoUnico(Request $request){	
		if ($request->ajax()) { 
    		$validator = Validator::make($request->all(), [    			
    			]);

	        if ($validator->fails()){
	            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
	        }else{        			
	        	$Contrato = Contrato::find($request['Id']);
				return response()->json(array('status' => 'success', "Contrato" => "Unico", "Id" => $Contrato->Id));				
			}
		}else{
			return response()->json(["Sin acceso"]);
		}
	}

	public function DescargarContrato(Request $request, $Contrato_Id){
		$data = $this->getData($Contrato_Id);	
		$Contrato = Contrato::find($Contrato_Id);	

        if($Contrato['Tipo_Documento'] == 7){
        	//Juridico
        	//$html =  \View::make('DATOS.juridico', compact('data'))->render();
        	//return $this->pdf->load($html)->show();
            $pdf = PDF::loadView('DATOS.juridico', compact('data'));
            return $pdf->download('CertificadoPersonaJuridica.pdf');
        }else {
        	//Natural
        	/*$html =  \View::make('DATOS.natural', compact('data'))->render();
        	return $this->pdf->load($html)->show();*/
            $pdf = PDF::loadView('DATOS.natural', compact('data'));
            return $pdf->download('CertificadoPersonaNatural.pdf');
        }
        
	}

	public function getData($Contrato_Id){
		$Contrato = Contrato::with('TipoDocumento', 'Tipocontrato', 'Adicion', 'Prorroga', 'Suspencion', 'Cesion', 'Obligacion')->find($Contrato_Id);
		$lista = explode('-', $Contrato['Fecha_Firma']);
		$Anio = $lista[0];
		$conversor = new ConvertirClass();

		$Meses_Letra = $conversor->to_word($Contrato['Meses_Duracion']);
		$Dias_Letra = $conversor->to_word($Contrato['Dias_Duracion']);

		setlocale(LC_ALL,"es_ES");
		$Fecha_Actual = date("F-d-m-Y");
		$listaFecha = explode('-', $Fecha_Actual);

		if($listaFecha[0] == 'January'){$Fecha_A = 'Enero';}
		if($listaFecha[0] == 'February'){$Fecha_A = 'Febrero';}
		if($listaFecha[0] == 'March'){$Fecha_A = 'Marzo';}
		if($listaFecha[0] == 'April'){$Fecha_A = 'Abril';}
		if($listaFecha[0] == 'May'){$Fecha_A = 'Mayo';}
		if($listaFecha[0] == 'June'){$Fecha_A = 'Junio';}
		if($listaFecha[0] == 'July'){$Fecha_A = 'Julio';}
		if($listaFecha[0] == 'August'){$Fecha_A = 'Agosto';}
		if($listaFecha[0] == 'September'){$Fecha_A = 'Septiembre';}
		if($listaFecha[0] == 'October'){$Fecha_A = 'Octubre';}
		if($listaFecha[0] == 'November'){$Fecha_A = 'Noviembre';}
		if($listaFecha[0] == 'December'){$Fecha_A = 'Diciembre';}

		$Dia_Actual_Letra = $conversor->to_word($listaFecha[1]);

        $valorAdiciones = 0;

        /************ADICIONES**************/
        $Adiciones = array();
        if(count($Contrato->Adicion) > 0){            
            foreach ($Contrato->Adicion as $key => $Adicion) {
                array_push($Adiciones, array("Numero"=>$Adicion['Numero_Adicion'], "Valor_Adicion"=>'$ '.number_format( $Adicion['Valor_Adicion'], 0, '.', '.' )));
                $valorAdiciones = $valorAdiciones+$Adicion['Valor_Adicion'];
            }
        }
        /**********************************/

        /************PRORROGAS**************/
        $Prorrogas = array();
        $Fecha_Fin_Prorroga = '0000-00-00';
        if(count($Contrato->Prorroga) > 0){            
            foreach ($Contrato->Prorroga as $key => $Prorroga) {
                array_push($Prorrogas, array("Numero"=>$Prorroga['Numero_Prorroga'], 
                                             "Meses"=>$Prorroga['Meses'], 
                                             "Meses_Letra" => ($conversor->to_word($Prorroga['Meses'])), 
                                             "Dias"=>$Prorroga['Dias'],
                                             "Dias_Letra"=>($conversor->to_word($Prorroga['Dias']))
                                            ));
            }
            $Fecha_Fin_Prorroga = $Prorroga['Fecha_Fin'];
        }
        /**********************************/

        /************SUSPENCIONES**************/
        $Suspenciones = array();
        $Fecha_Fin_Suspencion = '0000-00-00';
        if(count($Contrato->Suspencion) > 0){            
            foreach ($Contrato->Suspencion as $key => $Suspencion) {
                array_push($Suspenciones, array("Numero"=>$Suspencion['Numero_Suspencion'], 
                                                "Meses"=>$Suspencion['Meses'], 
                                                "Meses_Letra"=>($conversor->to_word($Suspencion['Meses'])), 
                                                "Dias"=>$Suspencion['Dias'], 
                                                "Dias_Letra"=>($conversor->to_word($Suspencion['Dias'])),                                              
                                                "Fecha_Inicio"=>$Suspencion['Fecha_Inicio'], 
                                                "Fecha_Fin"=>$Suspencion['Fecha_Fin'], 
                                                "Fecha_Reinicio"=>$Suspencion['Fecha_Reinicio'], 
                                            ));
                $Fecha_Fin_Suspencion = $Suspencion['Fecha_Fin'];

            }
        }
        /**********************************/
        $Obligaciones = array();
		if(count($Contrato->Obligacion) > 0){			
			foreach ($Contrato->Obligacion as $key => $Obligacion) {
				array_push($Obligaciones, array("Numero"=>$Obligacion['Numero_Obligacion'], "Obligacion"=>$Obligacion['Objeto_Obligacion']));
			}
		}

		if(count($Contrato->Cesion) > 0){
			$Cesiones = array();			
			$CesionesUlt =  $Contrato->Cesion->last();
			array_push($Cesiones, array("Numero" => $CesionesUlt['Numero_Cesion'], 
				                        "Nombre_Cesionario" => $CesionesUlt['Nombre_Cesionario'],
										"Tipo_Documento_Cesionario" => $CesionesUlt->TipoDocumento['Descripcion_TipoDocumento'],
										"Cedula_Cesionario" => number_format( $CesionesUlt['Cedula_Cesionario'], 0, '.', '.' ),
										"Dv_Cesion" => $CesionesUlt['Nombre_Cesionario'],
										"Valor_Cedido" => number_format( $CesionesUlt['Valor_Cedido'], 0, '.', '.' ),
										"Dias" => $CesionesUlt['Dias'],
										"Fecha_Cesion" => $CesionesUlt['Fecha_Cesion']));

            //$Fecha_Fin_Cesion =$CesionesUlt['Fec'];
		}else{
			$Cesiones = array();
		}

		if($Contrato['Tipo_Documento_Representante'] != ''){
			$TipoDocumento = TipoDocumento::find($Contrato['Tipo_Documento_Representante']);
			$Tipo_Documento_Representante = $TipoDocumento->Descripcion_TipoDocumento;	
		}else{
			$Tipo_Documento_Representante = 'No hay';
		}

        if($Contrato['Fecha_Terminacion_Anticipada'] == '0000-00-00'){
            $Fecha_Terminacion_Anticipada = 0;
            $Fecha_Fin_Contrato = $Contrato['Fecha_Fin'];
        }else{
            $Fecha_Terminacion_Anticipada = $Contrato['Fecha_Terminacion_Anticipada'];
            $Fecha_Fin_Contrato = $Contrato['Fecha_Terminacion_Anticipada'];
        }		

        if($Fecha_Fin_Contrato > $Fecha_Fin_Prorroga){
            $F1 = $Fecha_Fin_Contrato;
        }else{
            $F1 = $Fecha_Fin_Prorroga;
        }

        if($F1 > $Fecha_Fin_Suspencion){
            $F2 = $F1;
        }else{
            $F2 = $Fecha_Fin_Suspencion;
        }

        $ConteoExpedicion = (count(ExpedicionContrato::where('Contrato_Id', $Contrato_Id)->get()))+1;
        $ExpedicionContrato = new ExpedicionContrato;
        $ExpedicionContrato->Contrato_Id = $Contrato->Id;
        $ExpedicionContrato->Nombre_Expedicion = $Contrato->Id.'-'.$Contrato->Numero_Contrato.'-'.$ConteoExpedicion;
        $ExpedicionContrato->Conteo = $ConteoExpedicion;
        $ExpedicionContrato->save();

        if(is_numeric($Contrato['Valor_Mensual'])){
            $valorMensual = number_format( $Contrato['Valor_Mensual'], 0, '.', '.' );
        }else{
            $valorMensual = $Contrato['Valor_Mensual'];
        };

		$data =  [
            'Tipo_Contrato'      => $Contrato->TipoContrato['Nombre_Tipo_Contrato'] ,
            'Cedula'   => number_format( $Contrato['Cedula'], 0, '.', '.' ),
            'Nombre_Contratista'     =>$Contrato['Nombre_Contratista'],
            'Objeto'     =>$Contrato['Objeto'],
            'Numero_Contrato'     =>$Contrato['Numero_Contrato'],
            'Anio'     =>$Anio,
            'Tipo_Documento'     =>$Contrato->TipoDocumento['Descripcion_TipoDocumento'],
            'Fecha_Firma'     =>$Contrato['Fecha_Firma'],
            'Valor_Inicial'     =>number_format( $Contrato['Valor_Inicial'], 0, '.', '.' ),
            'Valor_Mensual'     => $valorMensual,
            'Fecha_Inicio'     =>$Contrato['Fecha_Inicio'],
            'Meses_Duracion'     =>$Contrato['Meses_Duracion'],
            'Meses_Letra'     =>$Meses_Letra,
            'Dias_Duracion'     =>$Contrato['Dias_Duracion'],
            'Dias_Letra'     =>$Dias_Letra,
            'Fecha_Fin'     =>$F2,
            'Dia_Actual_Letra' => $Dia_Actual_Letra,
            'Anio_Actual' => $listaFecha[3],
            'Dia_Actual' => $listaFecha[1],
            'Fecha_A' => $Fecha_A,
            'Obligaciones' => $Obligaciones,
            'CountObligaciones' => count($Obligaciones),
            'Cesiones' => $Cesiones,
            'CountCesiones' => count($Cesiones),
            'Nombre_Representante' => $Contrato['Nombre_Representante'],
            'Cedula_Representante' => $Contrato['Cedula_Representante'],
            'Tipo_Documento_Representante' => $Tipo_Documento_Representante,
            'Dv' => $Contrato['Dv'],
            'Fecha_Terminacion_Anticipada' => $Fecha_Terminacion_Anticipada,
            'Adiciones' => $Adiciones,
            'CountAdiciones' => count($Adiciones),
            'Prorrogas' => $Prorrogas,
            'CountProrrogas' => count($Prorrogas),
            'Suspenciones' => $Suspenciones,
            'CountSuspenciones' => count($Suspenciones),
            'ValorFinal' => number_format( ($valorAdiciones + $Contrato['Valor_Inicial']), 0, '.', '.' ),
            'Expedicion' => $ExpedicionContrato->Nombre_Expedicion,
        ];

        //dd($data);
        return $data;
	}
}

class ConvertirClass 
{      
 	private $UNIDADES = array(     '',
        'UN ',
        'DOS ',
        'TRES ',
        'CUATRO ',
        'CINCO ',
        'SEIS ',
        'SIETE ',
        'OCHO ',
        'NUEVE ',
        'DIEZ ',
        'ONCE ',
        'DOCE ',
        'TRECE ',
        'CATORCE ',
        'QUINCE ',
        'DIECISEIS ',
        'DIECISIETE ',
        'DIECIOCHO ',
        'DIECINUEVE ',
        'VEINTE '
  );
  private $DECENAS = array(
        'VENTI',
        'TREINTA ',
        'CUARENTA ',
        'CINCUENTA ',
        'SESENTA ',
        'SETENTA ',
        'OCHENTA ',
        'NOVENTA ',
        'CIEN '
  );
  private $CENTENAS = array(
        'CIENTO ',
        'DOSCIENTOS ',
        'TRESCIENTOS ',
        'CUATROCIENTOS ',
        'QUINIENTOS ',
        'SEISCIENTOS ',
        'SETECIENTOS ',
        'OCHOCIENTOS ',
        'NOVECIENTOS '
  );
  private $MONEDAS = array(
    array('country' => 'Colombia', 'currency' => 'COP', 'singular' => 'PESO COLOMBIANO', 'plural' => 'PESOS COLOMBIANOS', 'symbol', '$'),
    array('country' => 'Estados Unidos', 'currency' => 'USD', 'singular' => 'DÓLAR', 'plural' => 'DÓLARES', 'symbol', 'US$'),
    array('country' => 'Europa', 'currency' => 'EUR', 'singular' => 'EURO', 'plural' => 'EUROS', 'symbol', '€'),
    array('country' => 'México', 'currency' => 'MXN', 'singular' => 'PESO MEXICANO', 'plural' => 'PESOS MEXICANOS', 'symbol', '$'),
    array('country' => 'Perú', 'currency' => 'PEN', 'singular' => 'NUEVO SOL', 'plural' => 'NUEVOS SOLES', 'symbol', 'S/'),
    array('country' => 'Reino Unido', 'currency' => 'GBP', 'singular' => 'LIBRA', 'plural' => 'LIBRAS', 'symbol', '£'),
    array('country' => 'Argentina', 'currency' => 'ARS', 'singular' => 'PESO', 'plural' => 'PESOS', 'symbol', '$')
  );
    private $separator = '.';
    private $decimal_mark = ',';
    private $glue = ' CON ';
    /**
     * Evalua si el número contiene separadores o decimales
     * formatea y ejecuta la función conversora
     * @param $number número a convertir
     * @param $miMoneda clave de la moneda
     * @return string completo
     */
    public function to_word($number, $miMoneda = null) {
        if (strpos($number, $this->decimal_mark) === FALSE) {
          $convertedNumber = array(
            $this->convertNumber($number, $miMoneda, 'entero')
          );
        } else {
          $number = explode($this->decimal_mark, str_replace($this->separator, '', trim($number)));
          $convertedNumber = array(
            $this->convertNumber($number[0], $miMoneda, 'entero'),
            $this->convertNumber($number[1], $miMoneda, 'decimal'),
          );
        }
        return implode($this->glue, array_filter($convertedNumber));
    }
    /**
     * Convierte número a letras
     * @param $number
     * @param $miMoneda
     * @param $type tipo de dígito (entero/decimal)
     * @return $converted string convertido
     */
    private function convertNumber($number, $miMoneda = null, $type) {   
        
        $converted = '';
        if ($miMoneda !== null) {
            try {
                
                $moneda = array_filter($this->MONEDAS, function($m) use ($miMoneda) {
                    return ($m['currency'] == $miMoneda);
                });
                $moneda = array_values($moneda);
                if (count($moneda) <= 0) {
                    throw new Exception("Tipo de moneda inválido");
                    return;
                }
                ($number < 2 ? $moneda = $moneda[0]['singular'] : $moneda = $moneda[0]['plural']);
            } catch (Exception $e) {
                echo $e->getMessage();
                return;
            }
        }else{
            $moneda = '';
        }
        if (($number < 0) || ($number > 999999999)) {
            return false;
        }
        $numberStr = (string) $number;
        $numberStrFill = str_pad($numberStr, 9, '0', STR_PAD_LEFT);
        $millones = substr($numberStrFill, 0, 3);
        $miles = substr($numberStrFill, 3, 3);
        $cientos = substr($numberStrFill, 6);
        if (intval($millones) > 0) {
            if ($millones == '001') {
                $converted .= 'UN MILLON ';
            } else if (intval($millones) > 0) {
                $converted .= sprintf('%sMILLONES ', $this->convertGroup($millones));
            }
        }
        
        if (intval($miles) > 0) {
            if ($miles == '001') {
                $converted .= 'MIL ';
            } else if (intval($miles) > 0) {
                $converted .= sprintf('%sMIL ', $this->convertGroup($miles));
            }
        }
        if (intval($cientos) > 0) {
            if ($cientos == '001') {
                $converted .= 'UN ';
            } else if (intval($cientos) > 0) {
                $converted .= sprintf('%s ', $this->convertGroup($cientos));
            }
        }
        $converted .= $moneda;
        return $converted;
    }
    /**
     * Define el tipo de representación decimal (centenas/millares/millones)
     * @param $n
     * @return $output
     */
    private function convertGroup($n) {
        $output = '';
        if ($n == '100') {
            $output = "CIEN ";
        } else if ($n[0] !== '0') {
            $output = $this->CENTENAS[$n[0] - 1];   
        }
        $k = intval(substr($n,1));
        if ($k <= 20) {
            $output .= $this->UNIDADES[$k];
        } else {
            if(($k > 30) && ($n[2] !== '0')) {
                $output .= sprintf('%sY %s', $this->DECENAS[intval($n[1]) - 2], $this->UNIDADES[intval($n[2])]);
            } else {
                $output .= sprintf('%s%s', $this->DECENAS[intval($n[1]) - 2], $this->UNIDADES[intval($n[2])]);
            }
        }
        return $output;
    }
}