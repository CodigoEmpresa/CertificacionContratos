<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Certificación contratistas - persona natural</title> 
  {!! Html::style('public/Css/pdf.css') !!}
</head>
<footer>
  <img class="PiePag" src="http://www.idrd.gov.co/SIM/CertificacionContratos/public/Img/piepaginapdf.jpg">
  </footer>
<body>
  <div class="header">
    Página <span class="pagenum"></span>.<br>
    CERTIFICADO DE EXPEDICIÓN No {{$data['Expedicion']}}
    ESTE CERTIFICADO ESTA FIRMADO DIGILTAMENTE, PARA VERIFICAR SU VALIDEZ COMUNÍQUESE CON EL IDRD.
    <br><br><br><br><br>
  </div>
  <center>
    <p>
      <img src="http://www.idrd.gov.co/SIM/CertificacionContratos/public/Img/cabecera.png">
    </p>
    <br>
    <span class="Neg Titulos">      
      EL  SUSCRITO  RESPONSABLE DEL  ÁREA  APOYO  A  LA  CONTRATACIÓN DEL INSTITUTO DISTRITAL PARA LA RECREACIÓN Y EL DEPORTE. N.I.T. - IDRD: 860.061.099 - 1
      <br><br>
      HACE CONSTAR
    </span>    
  </center>
  <br><br>
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
      <div class="TableDiv">
        <div class="table">
          <div class="table-row titulo">
            <div class="table-tit">No. Contrato</div>
            <div class="table-cell" style="background-color: #A4A4A4;"><span class="Mayus Vino">{{$data['Numero_Contrato']}}</span> de <span class="Mayus Vino">{{$data['Anio']}}</span></div>
          </div>

          <div class="table-row">
            <div class="table-cell Neg">
              OBJETO</span>
            </div>
            <div class="table-cell Vino Mayus">{{$data['Objeto']}}</div>
          </div>

          <div class="table-row">
            <div class="table-cell Neg">
              VALOR INICIAL</span>
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
            <div class="table-cell Neg">FECHA DE TERMINACIÓN INICIAL</div>
            <div class="table-cell Vino">
              {{$data['Fecha_Fin_Contrato_Inicial']}}
            </div>
          </div>

          @if($data['Fecha_Terminacion_Anticipada'] != 0)
            <div class="table-row">
              <div class="table-cell Neg">FECHA DE TERMINACIÓN ANTICIPADA</div>
              <div class="table-cell Vino">
                {{$data['Fecha_Terminacion_Anticipada']}}
              </div>
            </div>
          @endif        

          <div class="table-row">
            <div class="table-cell Neg">FECHA DE TERMINACIÓN FINAL</div>
            <div class="table-cell Vino">
              {{$data['Fecha_Fin']}}
            </div>
          </div>

          @if($data['CountAdiciones'] > 0)
            <div class="table-row">
              <div class="table-tit Neg Cesion">
                ADICIONES
              </div>

              <div class="table-cell Vino">
                <div class="tableO">
                  @foreach($data['Adiciones'] as $Adiciones)              
                <div class="table-rowO">
                  <div class="table-cellOT Neg">
                    {{ $Adiciones['Numero']}}.
                  </div>
                  <div class="table-cellO Vino">
                    {{ $Adiciones['Valor_Adicion'] }}
                  </div>
                </div>
                @endforeach
                </div>     
              </div>
            </div>
          @endif

          @if($data['CountProrrogas'] > 0)
            <div class="table-row">
              <div class="table-tit Neg Cesion">
                PRÓRROGAS
              </div>
              <div class="table-cell Vino">
                <div class="tableO">
                  @foreach($data['Prorrogas'] as $Prorrogas)              
                <div class="table-rowO">
                  <div class="table-cellOT Neg">
                    {{ $Prorrogas['Numero']}}.
                  </div>
                  <div class="table-cellO Vino">
                    {{$Prorrogas['Meses_Letra']}} ({{$Prorrogas['Meses']}}) Meses y {{$Prorrogas['Dias_Letra']}} ({{$Prorrogas['Dias']}}) Días.
                  </div>
                </div>
                @endforeach
                </div>     
              </div>
            </div>
          @endif

          @if($data['CountSuspenciones'] > 0)
            <div class="table-row">
              <div class="table-tit Neg Cesion">
                SUSPENSIONES
              </div>
              <div class="table-cell Vino">
                <div class="tableO">
                  @foreach($data['Suspenciones'] as $Suspenciones)              
                <div class="table-rowO">
                  <div class="table-cellOT Neg">
                    {{ $Suspenciones['Numero']}}.
                  </div>
                  <div class="table-cellO Vino">
                    Desde la fecha {{$Suspenciones['Fecha_Inicio']}} hasta {{$Suspenciones['Fecha_Fin']}}, con reinicio el {{$Suspenciones['Fecha_Reinicio']}}. Con duración de {{$Suspenciones['Meses_Letra']}} ({{$Suspenciones['Meses']}}) Meses y {{$Suspenciones['Dias_Letra']}} ({{$Suspenciones['Dias']}}) Días. 
                  </div>
                </div>
                @endforeach
                </div>     
              </div>
            </div>
          @endif

          @if($data['CountCesiones'] > 0)           
              @foreach($data['Cesiones'] as $Cesiones)              
                <div class="table-row">
                  <div class="table-tit Neg Cesion">FECHA DE CESIÓN</div>   
                  <div class="table-cell Vino" style="background-color: #A4A4A4;">{{$Cesiones['Fecha_Cesion']}}</div>
                </div>
                <div class="table-row">
                  <div class="table-cell Neg">VALOR CEDIDO</div>
                  <div class="table-cell Vino">${{$data['Cesiones'][0]['Valor_Cedido']}}</div>
                </div>
              @endforeach
          @endif

          <div class="table-row">
            <div class="table-cell Neg ">VALOR FINAL</div>   
            <div class="table-cell Vino">${{$data['ValorFinal']}}</div>
          </div>

        </div>
    </div>

      @if($data['CountObligaciones'] > 0)      
      <div class="TableDiv">
        <div class="table"> 
          <div class="table-row">
            <div class="table-tit Neg">
              OBLIGACIONES ESPECÍFICAS
            </div>
            <div class="table-cell Vino">
              <div class="tableO"></div>
            </div>
          </div>
        </div>
      </div>    

        @foreach($data['Obligaciones'] as $Obligaciones) 
        <div class="TableDiv">
          <!--<div class="tableOX">         -->   
              <div class="table">     
                <div class="table-row">   
                  <div class="table-titO Neg">OBLIGACIONES ESPECÍFICAS</div>
                  <div class="table-cell Vino">                     
                    <div class="table">
                      <div class="table-row">
                        <div class="table-cellOT Neg">
                          {{ $Obligaciones['Numero']}}.
                        </div>
                        <div class="table-cellO Vino">
                          {{ $Obligaciones['Obligacion'] }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>  
              </div>   
            <!--</div>-->
        </div>    
        @endforeach
        <div class="TableDiv" style="">
          <div class="table">          
            <div class="table-row">
              <div class="table-tit Neg">
              </div>
              <div class="table-cell Vino">
                <div class="tableO"></div>
              </div>
            </div>
          </div>
        </div>  
      @endif
      <br><br><br>
      <div class="TextoInicio">
        <span>
          Para constancia se expide a solicitud de la parte interesada en Bogotá, D.C., a los <span class="Minus Vino">{{$data['Dia_Actual_Letra']}}</span> (<span class="Minus Vino">{{$data['Dia_Actual']}}</span>) días del mes de <span class="Minus Vino">{{$data['Fecha_A']}}</span> de <span class="Minus Vino">{{$data['Anio_Actual']}}</span>.
        </span>
        <br><br>
        <img class="" src="http://www.idrd.gov.co/SIM/CertificacionContratos/public/Img/firma.png">
      </div>
      <br><br>
  </body>
</html>