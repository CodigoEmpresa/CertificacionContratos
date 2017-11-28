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
                <h3>Se ha registrado una nueva solicitud de certificación de contratos.</h3>
            </div>  
            <div class="panel">
                <div class="panel-heading">                      </div>                 
                <ul class="list-group" id="seccion_uno" name="seccion_uno">                    
                    <li class="list-group-item">
                        <div class="panel-body">
                            <h4>Información importante!</h4>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-12">
                          <label for="inputEmail" class="control-label" >
                            <?php echo $mensaje; ?>
                          </label>
                        </div>


                          <div class="form-group col-md-12">
                            <h4>Descripción del soporte:</h4>
                          </div>
                          <div class="form-group col-md-12">
                            <label for="inputEmail" class="control-label" >
                              <?php echo $descripcion; ?>
                            </label>
                        </div>

                        <div class="form-group col-md-12">
                            <h4>Enviado por:</h4>
                          </div>
                          <div class="form-group col-md-12">
                            <label for="inputEmail" class="control-label" >
                              <?php echo $nombre_solicitante; ?> con número de documento <?php echo $documento_solicitante; ?>
                            </label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
  </body>
</html>