<!DOCTYPE html>
<html lang="es">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="description" content="">
      <meta name="author" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />

      @section('style')
          <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
          <link rel="stylesheet" href="{{ asset('public/Css/jquery-ui.css') }}" media="screen">    
          <link rel="stylesheet" href="{{ asset('public/Css/bootstrap.min.css') }}" media="screen">   
          <link rel="stylesheet" href="{{ asset('public/Css/sticky-footer.css') }}" media="screen">    
      @show
      @section('script')
          <script src="{{ asset('public/Js/jquery.js') }}"></script>
          <script src="{{ asset('public/Js/jquery-ui.js') }}"></script>
          <script src="{{ asset('public/Js/bootstrap.min.js') }}"></script>
          <script src="{{ asset('public/Js/main.js') }}"></script>

      @show
  </head>

  <body>
    <center><h3>SOPORTE CERTIFICACIÓN DE CONTRATOS!</h3></center>
 <div class="content" id="RUD">
        <div class="content">
            <div style="text-align:center;">
                <h3>Respuesta a su solicitud</h3>
            </div>  
            <div class="panel">
                <!-- Default panel contents 
                Estimado(a) "(Nombre Solicitante)",


Cordial saludo.


De acuerdo a su solicitud No. XXXX-2017, nos permitimos dar respuesta así:

"(mensaje de respuesta)"


Atentamente,


Jared Jafet Forero Alvarez
Área de Apoyo a la contratación.-->
                <div class="panel-heading">                      </div>                 
                <ul class="list-group" id="seccion_uno" name="seccion_uno">                    
                    <li class="list-group-item">
                        <div class="panel-body">
                            <h4>Estimado(a) <?php echo $nombres; ?>,</h4>
                        </div>
                        <div class="form-group col-md-12">                            
                          Cordial saludo.
                          <br><br>
                          De acuerdo a su solicitud No. <?php echo $referencia; ?>, nos permitimos dar respuesta así:
                        </div>
                        <br>
                        <div class="row">
                          <div class="form-group col-md-12">
                            <label for="inputEmail" class="control-label" >
                              <?php echo $mensaje; ?>
                            </label>
                          </div>
                        </div>
                        <br><br>
                        <div class="row">
                          <div class="form-group col-md-12">
                            <label for="inputEmail" class="control-label" style="color:#5882FA; font-weight: 800;" >
                              <?php echo $nombreFuncionario; ?>
                              <br>
                              Área de Apoyo a la contratación.
                            </label>
                          </div>
                        </div>
                        <br>
                        <!--<div class="row">
                            <div class="form-group col-md-12">                            
                                <a href="{{ asset('public/Archivos/Resolucion.pdf') }}">
                                    <label for="inputEmail" class="control-label" id="ResolucionL" >RESOLUCIÓN VIGENTE</label>
                                </a>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <a  href="{{ asset('public/Archivos/Deberes.pdf') }}" download="Deberes">
                                    <label for="inputEmail" class="control-label" id="DeberesL">DEBERES Y OBLIGACIONES</label>
                                </a>
                            </div>
                          </div>-->
                        <br>
                    </li>
                </ul>
            </div>
        </div>
    </div>
  </body>
</html>