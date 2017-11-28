<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Idrd\Usuarios\Repo\PersonaInterface;
use Illuminate\Http\Request;

class MainController extends Controller {

    protected $Usuario;
    protected $repositorio_personas;

    public function __construct(PersonaInterface $repositorio_personas)
    {
        if (isset($_SESSION['Usuario']))
            $this->Usuario = $_SESSION['Usuario'];

        $this->repositorio_personas = $repositorio_personas;
    }

    public function welcome()
    {
        $data['seccion'] = '';
        return view('welcome', $data);
    }

    public function index(Request $request)
    {
        if ($request->has('vector_modulo'))
        {   
            $vector = urldecode($request->input('vector_modulo'));
            $user_array = unserialize($vector);

        
            $_SESSION['Usuario'] = $user_array;
            $persona = $this->repositorio_personas->obtener($_SESSION['Usuario'][0]);
            $_SESSION['Usuario']['Persona'] = $persona;
            $this->Usuario = $_SESSION['Usuario'];
        } else {
            if(!isset($_SESSION['Usuario']))
                $_SESSION['Usuario'] = '';
        }
        
        if ($_SESSION['Usuario'] == '')
            return redirect()->away('http://www.idrd.gov.co/SIM/Presentacion/');


            $deportista = $_SESSION['Usuario']['Persona'];

            $vector = urldecode($vector);

            //$vectorArreglaso="a%3A10%3A%7Bi%3A0%3Bs%3A4%3A%221046%22%3Bi%3A1%3Bs%3A1%3A%221%22%3Bi%3A2%3Bs%3A1%3A%221%22%3Bi%3A3%3Bs%3A1%3A%221%22%3Bi%3A4%3Bs%3A1%3A%221%22%3Bi%3A5%3Bs%3A1%3A%221%22%3Bi%3A6%3Bs%3A1%3A%221%22%3Bi%3A7%3Bs%3A1%3A%221%22%3Bi%3A8%3Bs%3A1%3A%221%22%3Bi%3A9%3Bs%3A1%3A%221%22%3B%7D";
            //$vectorArreglaso = "a%3A9%3A%7Bi%3A0%3Bs%3A4%3A%221307%22%3Bi%3A1%3Bs%3A1%3A%221%22%3Bi%3A2%3Bs%3A1%3A%221%22%3Bi%3A3%3Bs%3A1%3A%221%22%3Bi%3A4%3Bs%3A1%3A%221%22%3Bi%3A5%3Bs%3A1%3A%221%22%3Bi%3A6%3Bs%3A1%3A%221%22%3Bi%3A7%3Bs%3A1%3A%221%22%3Bi%3A8%3Bs%3A1%3A%221%22%3B%7D";

            
            $user_array = unserialize($vector);       
            $_SESSION['Usuario'] = $user_array;
            
            $persona = $this->repositorio_personas->obtener($_SESSION['Usuario'][0]);
            $_SESSION['Usuario']['Persona'] = $persona;
          

            return view('welcome');

    }



    public function logout()

    {

        $_SESSION['Usuario'] = '';

        Session::set('Usuario', ''); 



        return redirect()->to('/');

    }

}