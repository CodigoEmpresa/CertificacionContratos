<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Certificación contratistas</title>
  <link rel="stylesheet" href="public/Css/pdf.css" media="screen">

  <style>
   
  </style>
  
</head>
<body>
  <center>
    <p>
      <img src="public/Img/cabecera.png">
    </p>
    <br>
    <span>      
      EL  SUSCRITO  RESPONSABLE DEL  ÁREA  APOYO  A  LA  CONTRATACION DEL INSTITUTO DISTRITAL PARA LA RECREACION Y EL DEPORTE. N.I.T. - IDRD: 860.061.099 - 1
      <br><br>
      HACE CONSTAR
    </span>
  </center>
  <br>
  @if($data['CountCesiones'] > 0)
        <p class="TextoInicio">
          Que revisada la documentación que reposa en los archivos de  la entidad, se establece que el IDRD suscribió EL <span class="Mayus Vino">{{$data['Tipo_Contrato']}}</span>, que se relaciona a continuación, con <span class="Mayus Vino">{{$data['Nombre_Contratista']}}</span> identificado (a) con <span class="Mayus Vino">{{$data['Tipo_Documento']}}</span> No. <span class="Mayus Vino">{{$data['Cedula']}}</span>, quien lo cede a <span class="Mayus Vino">{{$data['Cesiones'][0]['Nombre_Cesionario']}}</span> identificado (a) con <span class="Mayus Vino">{{$data['Cesiones'][0]['Tipo_Documento_Cesionario']}}</span> No. <span class="Mayus Vino">{{$data['Cesiones'][0]['Cedula_Cesionario']}}</span>, con las siguientes características:
        </p>
      @endif
      @if($data['CountCesiones'] == 0)
        <p class="TextoInicio">
          Que revisada la documentación que reposa en los archivos de  la entidad, se establece que el IDRD suscribió EL <span class="Mayus Vino">{{$data['Tipo_Contrato']}}</span>, que se relaciona a continuación, con <span class="Mayus Vino">{{$data['Nombre_Contratista']}}</span> identificado (a) con <span class="Mayus Vino">{{$data['Tipo_Documento']}}</span> No. <span class="Mayus Vino">{{$data['Cedula']}}</span>, con las siguientes características:
        </p>      
      @endif   
      <br>
      <div class="Objeto">
        OBJETO:  <span class="Mayus Vino">{{$data['Objeto']}}</span>
      </div> 
      <div class="TableDiv">
        <div class="table">
          <div class="table-row titulo">
            <div class="table-tit">Nº. <span class="Mayus Vino">{{$data['Tipo_Contrato']}}</span></div>
            <div class="table-tit"><span class="Mayus Vino">{{$data['Numero_Contrato']}}</span> de <span class="Mayus Vino">{{$data['Anio']}}</span></div>
          </div>

          <div class="table-row">
            <div class="table-cell">
              <span class="Neg">
                VALOR INICIAL DEL 
                <span class="Mayus Vino">{{$data['Tipo_Contrato']}}</span>
              </span>
            </div>
            <div class="table-cell Vino">${{$data['Valor_Inicial']}}</div>
          </div>

          <div class="table-row">
            <div class="table-cell Neg">
              VALOR MENSUAL
            </div>
            <div class="table-cell Vino">
              ${{$data['Valor_Mensual']}}
            </div>
          </div>

          <div class="table-row">
            <div class="table-cell Neg">
              FECHA DE ACTA DE  INICIO
            </div>
            <div class="table-cell Vino">
              {{$data['Fecha_Inicio']}}
            </div>
          </div>

          <div class="table-row">
            <div class="table-cell Neg">
              PLAZO
            </div>
            <div class="table-cell Mayus Vino">
              {{$data['Meses_Letra']}} ({{$data['Meses_Duracion']}}) Meses y {{$data['Dias_Letra']}} ({{$data['Dias_Duracion']}}) Días - CONTADOS A PARTIR DEL ACTA DE INICIO
            </div>
          </div>

          <div class="table-row">
            <div class="table-cell Neg">
              FECHA DE TERMINACION DEL <span class="Mayus Vino">{{$data['Tipo_Contrato']}}</span>
            </div>
            <div class="table-cell Vino">
              {{$data['Fecha_Fin']}}
            </div>
          </div>

          @if($data['CountCesiones'] > 0)           
              @foreach($data['Cesiones'] as $Cesiones)              
                <div class="table-row">
                  <div class="table-tit Neg Cesion">FECHA DE CESIÓN</div>   
                  <div class="table-tit Neg Vino">{{$Cesiones['Fecha_Cesion']}}</div>
                </div>
                <div class="table-row">
                  <div class="table-cell Neg">VALOR CEDIDO</div>
                  <div class="table-cell Vino">${{$data['Cesiones'][0]['Valor_Cedido']}}</div>
                </div>
              @endforeach
          @endif

          <div class="table-row">
            <div class="table-cell Neg">
              OBLIGACIONES ESPECIFICAS
            </div>
            <div class="table-cell Vino">
              <div class="table">
                @foreach($data['Obligaciones'] as $Obligaciones)              
                <div class="table-row">
                  <div class="table-cell Neg">
                    {{ $Obligaciones['Numero']}}.
                  </div>
                  <div class="table-cell Vino">
                    {{ $Obligaciones['Obligacion'] }}.
                  </div>
                </div>
                @endforeach
              </div>            
            </div>
          </div>
        </div>
      </div>  

      <div class="TextoInicio">
        <p>
          Para constancia se expide a solicitud de la parte interesada en Bogotá, D.C., a los <span class="Minus Vino">{{$data['Dia_Actual_Letra']}}</span> (<span class="Minus Vino">{{$data['Dia_Actual']}}</span>) días del mes de <span class="Minus Vino">{{$data['Fecha_A']}}</span> de <span class="Minus Vino">{{$data['Anio_Actual']}}</span>.
        </p>
        <br><br>
        <img src="public/Img/firma.png">
      </div>
      <br><br>
      <div class="footer">
        <img src="public/Img/piepaginapdf.jpg">
      </div>   
  </body>
</html>