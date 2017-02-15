$(function(){
      $('#AnioConsulta').on('change', function(){            
          if($(this).val() != ''){
            $('#TablaDat').hide('slow');
            $('#Esperar').show('slow');
            $.get("getContratoDate/"+$(this).val(), function (ContratoDate) {
              $('#TablaDat').html(ContratoDate);
               $('#datosTabla').DataTable({
                  retrieve: true,
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    dom: 'Bfrtip',
                    select: true,
                    "responsive": true,
                    "ordering": true,
                    "info": true,
                    "pageLength": 10,
                    "language": {
                        url: 'public/DataTables/Spanish.json',
                        searchPlaceholder: "Buscar"
                    }
                });
            }).done(function(){
              $('#TablaDat').show('slow');
              $('#Esperar').hide('slow');   
            });
          }
      });
        
      var table = $('#datosTabla').DataTable();
   
      $('#datosTabla tbody').on( 'click', 'tr', function () {
          if ( $(this).hasClass('selected') ) {
              $(this).removeClass('selected');
          }
          else {
              table.$('tr.selected').removeClass('selected');
              $(this).addClass('selected');
          }
      } );
   
  
    var Adicion = new Array();
    var Prorroga = new Array();
    var Suspencion = new Array();
    var Cesion = new Array();
    var Obligacion = new Array();

  $.datepicker.setDefaults($.datepicker.regional["es"]);
  $('#FechaFirmaDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
  $('#FechaInicioDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
  $('#FechaFinAnticipadoDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
  $('#FechaFinDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
  $('#FechaFinDateAnticipadoDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
  $('#FechaFinContratoDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});  
  $('#FechaFinCtoProrrogaDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
  $('#FechaInicioSuspencionDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
  $('#FechaFinSuspencionDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
  $('#FechaReinicioSuspencionDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
  $('#FechaCesionDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});



  $('#FechaFinCtoProrrogaDateM').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
  $('#FechaInicioSuspencionDateM').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
  $('#FechaFinSuspencionDateM').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
  $('#FechaReinicioSuspencionDateM').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
  $('#FechaCesionDateM').datepicker({format: 'yyyy-mm-dd', autoclose: true,});

  $('#FechaFirmaDateM').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
  $('#FechaInicioDateM').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
  $('#FechaFinAnticipadoDateM').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
  $('#FechaFinDateM').datepicker({format: 'yyyy-mm-dd', autoclose: true,});


    $("#Agregar_Contrato").on('click', function(){
        $("#AgregarContratoD").modal('show');
        $('#agregarContratoF .form-group').removeClass('has-error');
        Adicion = new Array();
        Prorroga = new Array();
        Suspencion = new Array();
        Cesion = new Array();
        Obligacion = new Array();
        $("#NuevaAdicionD").hide('slow');
        $("#RegistrosAdicion").empty();
        $("#TablaAdicion").hide('slow');

        $("#NuevaProrrogaD").hide('slow');
        $("#RegistrosProrroga").empty();
        $("#TablaProrroga").hide('slow');

        $("#NuevaSuspencionD").hide('slow');
        $("#RegistrosSuspencion").empty();
        $("#TablaSuspencion").hide('slow');

        $("#NuevaCesionD").hide('slow');
        $("#RegistrosCesion").empty();
        $("#TablaCesion").hide('slow');

        $("#NuevaObligacionD").hide('slow');
        $("#RegistrosObligacion").empty();
        $("#TablaObligacion").hide('slow');
    });

    $("#NuevaAdicion").on('click', function(){
        $("#NuevaAdicionD").show('slow');
    });

    $("#NuevaProrroga").on('click', function(){
        $("#NuevaProrrogaD").show('slow');
    });

    $("#NuevaSuspencion").on('click', function(){
        $("#NuevaSuspencionD").show('slow');
    });

    $("#NuevaCesion").on('click', function(){
        $("#NuevaCesionD").show('slow');
    });

    $("#NuevaObligacion").on('click', function(){
        $("#NuevaObligacionD").show('slow');
    });

    $("#AgregarAdicion").on('click', function(){
        var formData = new FormData($("#agregarContratoF")[0]);    
        $.ajax({
          url: 'revAdicion',  
          type: 'POST',
          data: formData,          
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (xhr) {
            if(xhr.status == 'error'){
              validador_errores(xhr.errors);
            }
            else if(xhr.status == 'success'){
                $('#agregarContratoF .form-group').removeClass('has-error');
                Adicion.push({ "Valor_Adicion": $("input[name=Valor_Adicion]").val()});

                $("input[name=Valor_Adicion]").val('');

                var html = '';
                $.each(Adicion, function(i, e){
                  html += '<tr><td>'+(i+1)+'</td><td>'+e['Valor_Adicion']+'</td></tr>';                
                });

                $("#RegistrosAdicion").empty();
                $("#RegistrosAdicion").html(html);
                $("#TablaAdicion").show('slow');
            }
          },
          error: function (xhr){
            validador_errores(xhr.responseJSON);
          }
        });
    });

    $("#AgregarProrroga").on('click', function(){
        var formData = new FormData($("#agregarContratoF")[0]);   
        $.ajax({
          url: 'revProrroga',  
          type: 'POST',
          data: formData,          
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (xhr) {
            if(xhr.status == 'error'){
              validador_errores(xhr.errors);
            }
            else if(xhr.status == 'success'){
                $('#agregarContratoF .form-group').removeClass('has-error');
                Prorroga.push({"Meses_Prorroga" : $("input[name=Meses_Prorroga]").val(),
                               "Dias_Prorroga" : $("input[name=Dias_Prorroga]").val(),
                               "FechaFinCtoProrroga" : $("input[name=FechaFinCtoProrroga]").val(),
                              });

                $("input[name=Meses_Prorroga]").val('');
                $("input[name=Dias_Prorroga]").val('');
                $("input[name=FechaFinCtoProrroga]").val('');

                var html = '';
                $.each(Prorroga, function(i, e){
                  html += '<tr>'+
                            '<td>'+(i+1)+'</td>'+
                            '<td>'+e['Meses_Prorroga']+'</td>'+
                            '<td>'+e['Dias_Prorroga']+'</td>'+
                            '<td>'+e['FechaFinCtoProrroga']+'</td>'+
                          '</tr>';                
                });

                $("#RegistrosProrroga").empty();
                $("#RegistrosProrroga").html(html);
                $("#TablaProrroga").show('slow');
            }
          },
          error: function (xhr){
            validador_errores(xhr.responseJSON);
          }
        });
    });

    $("#AgregarSuspencion").on('click', function(){
        var formData = new FormData($("#agregarContratoF")[0]);          
        $.ajax({
          url: 'revSuspencion',  
          type: 'POST',
          data: formData,          
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (xhr) {
            if(xhr.status == 'error'){
              validador_errores(xhr.errors);
            }
            else if(xhr.status == 'success'){
                $('#agregarContratoF .form-group').removeClass('has-error');
                Suspencion.push({/*"Objeto_Suspencion" : $("textarea[name=Objeto_Suspencion]").val(),*/
                               "Meses_Suspencion" : $("input[name=Meses_Suspencion]").val(),
                               "Dias_Suspencion" : $("input[name=Dias_Suspencion]").val(),
                               "FechaInicioSuspencion" : $("input[name=FechaInicioSuspencion]").val(),
                               "FechaFinSuspencion" : $("input[name=FechaFinSuspencion]").val(),
                               "FechaReinicioSuspencion" : $("input[name=FechaReinicioSuspencion]").val(),
                              });

                //$("textarea[name=Objeto_Suspencion]").val('');
                $("input[name=Meses_Suspencion]").val('');
                $("input[name=Dias_Suspencion]").val('');
                $("input[name=FechaInicioSuspencion]").val('');
                $("input[name=FechaFinSuspencion]").val('');
                $("input[name=FechaReinicioSuspencion]").val('');

                var html = '';
                $.each(Suspencion, function(i, e){
                  html += '<tr>'+
                            '<td>'+(i+1)+'</td>'+
                            //'<td>'+e['Objeto_Suspencion']+'</td>'+
                            '<td>'+e['Meses_Suspencion']+'</td>'+
                            '<td>'+e['Dias_Suspencion']+'</td>'+
                            '<td>'+e['FechaInicioSuspencion']+'</td>'+
                            '<td>'+e['FechaFinSuspencion']+'</td>'+
                            '<td>'+e['FechaReinicioSuspencion']+'</td>'+
                          '</tr>';                
                });

                $("#RegistrosSuspencion").empty();
                $("#RegistrosSuspencion").html(html);
                $("#TablaSuspencion").show('slow');
            }
          },
          error: function (xhr){
            validador_errores(xhr.responseJSON);
          }
        });
    });

    $("#AgregarCesion").on('click', function(){
        var formData = new FormData($("#agregarContratoF")[0]);
        $.ajax({
          url: 'revCesion',  
          type: 'POST',
          data: formData,          
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (xhr) {
            if(xhr.status == 'error'){
              validador_errores(xhr.errors);
            }
            else if(xhr.status == 'success'){
                $('#agregarContratoF .form-group').removeClass('has-error');
                Cesion.push({"Nombre_Cesionario" : $("input[name=Nombre_Cesionario]").val(),
                               "Tipo_Documento_Cesionario" : $("#Tipo_Documento_Cesion").val(),
                               "Cedula_Cesionario" : $("input[name=Cedula_Cesionario]").val(),
                               "Dv_Cesion" : $("input[name=Dv_Cesion]").val(),
                               "Valor_Cesion" : $("input[name=Valor_Cesion]").val(),
                               "FechaCesion" : $("input[name=FechaCesion]").val()
                              });

                $("input[name=Nombre_Cesionario]").val('');
                $("input[name=Tipo_Documento_Cesion]").val('');
                $("input[name=Cedula_Cesionario]").val('');
                $("input[name=Dv_Cesion]").val('');
                $("input[name=Valor_Cesion]").val('');
                $("input[name=FechaCesion]").val('');

                var html = '';
                $.each(Cesion, function(i, e){
                  html += '<tr>'+
                            '<td>'+(i+1)+'</td>'+
                            '<td>'+e['Nombre_Cesionario']+'</td>'+
                            '<td>'+e['Cedula_Cesionario']+'</td>'+
                            '<td>'+e['Dv_Cesion']+'</td>'+
                            '<td>'+e['Valor_Cesion']+'</td>'+
                            '<td>'+e['FechaCesion']+'</td>'+
                          '</tr>';                
                });

                $("#RegistrosCesion").empty();
                $("#RegistrosCesion").html(html);
                $("#TablaCesion").show('slow');
            }
          },
          error: function (xhr){
            validador_errores(xhr.responseJSON);
          }
        });
    });

    $("#AgregarObligacion").on('click', function(){
        var formData = new FormData($("#agregarContratoF")[0]);          
        $.ajax({
          url: 'revObligacion',  
          type: 'POST',
          data: formData,          
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (xhr) {
            if(xhr.status == 'error'){
              validador_errores(xhr.errors);
            }
            else if(xhr.status == 'success'){
                $('#agregarContratoF .form-group').removeClass('has-error');
                Obligacion.push({"Obligacion" : $("textarea[name=Obligacion]").val()});

                $("textarea[name=Obligacion]").val('');

                var html = '';
                $.each(Obligacion, function(i, e){
                  html += '<tr>'+
                            '<td>'+(i+1)+'</td>'+
                            '<td>'+e['Obligacion']+'</td>'+
                          '</tr>';                
                });

                $("#RegistrosObligacion").empty();
                $("#RegistrosObligacion").html(html);
                $("#TablaObligacion").show('slow');
            }
          },
          error: function (xhr){
            validador_errores(xhr.responseJSON);
          }
        });
    });

      $("#AgregarContrato").on('click', function(){
        var formData = new FormData($("#agregarContratoF")[0]);   
        var json_vector_adicion = JSON.stringify(Adicion);
        formData.append("Adicion",json_vector_adicion);

        var json_vector_prorroga = JSON.stringify(Prorroga);
        formData.append("Prorroga",json_vector_prorroga);

        var json_vector_suspencion = JSON.stringify(Suspencion);
        formData.append("Suspencion",json_vector_suspencion);

        var json_vector_cesion = JSON.stringify(Cesion);
        formData.append("Cesion",json_vector_cesion);

        var json_vector_obligacion = JSON.stringify(Obligacion);
        formData.append("Obligacion",json_vector_obligacion);

        $.ajax({
          url: 'AddContrato',  
          type: 'POST',
          data: formData,          
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (xhr) {
            if(xhr.status == 'error'){
              validador_errores(xhr.errors);
            }
            else if(xhr.status == 'success'){
                $('#agregarContratoF .form-group').removeClass('has-error');     
                $('#mensaje').html('<div class="alert alert-dismissible alert-success" ><strong>Exito!</strong>'+xhr.Mensaje+'</div>');
                $('#mensaje').show(60);
                $('#mensaje').delay(1500).hide(600);    
                setTimeout(function(){
                  $("#AgregarContratoD").modal('hide');
                }, 2000);
                var t = $('#datosTabla').DataTable();
                 t.row.add( [
                            xhr.Cedula,
                            xhr.Nombre,
                            xhr.Numero,
                            xhr.Fecha,
                            '<button type="button" class="btn btn-info" data-funcion="verContrato" value="'+xhr.Id+'" >'+
                                '<span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>'+
                            '</button>'+
                            '<button type="button" class="btn btn-primary" data-funcion="modificarContrato" value="'+xhr.Id+'" >'+
                                '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'+
                            '</button>'+
                            '<button type="button" class="btn btn-danger"  data-funcion="eliminarContrato" value="'+xhr.Id+'" >'+
                                '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'+
                            '</button>',
                        ] ).draw( false );
                /*$.get("getContrato", function (ContratosDatos) { 
                    var t = $('#datosTabla').DataTable();
                    t.row.add(['1','1','1','1','1'] ).clear().draw( false );
                    $.each(ContratosDatos, function(i, e){
                        t.row.add( [
                            e['Cedula'],                        
                            e['Nombre_Contratista'],                            
                            e['Numero_Contrato'],
                            e['Fecha_Inicio'],
                            '<button type="button" class="btn btn-info" data-funcion="verContrato" value="'+e['Id']+'" >'+
                                '<span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>'+
                            '</button>'+
                            '<button type="button" class="btn btn-primary" data-funcion="modificarContrato" value="'+e['Id']+'" >'+
                                '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'+
                            '</button>'+
                            '<button type="button" class="btn btn-danger"  data-funcion="eliminarContrato" value="'+e['Id']+'" >'+
                                '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'+
                            '</button>',
                        ] ).draw( false );
                    });
                });*/
            }            
          },
          error: function (xhr){
            validador_errores(xhr.responseJSON);
          }
        });
    });

    var validador_errores = function(data){
      $('#agregarContratoF .form-group').removeClass('has-error');
      $.each(data, function(i, e){
        $("#"+i).closest('.form-group').addClass('has-error');
      });
    }

    $('body').delegate('button[data-funcion="verContrato"]','click',function (e) { 
      $("#RegistrosAdicionV").empty();
      $("#RegistrosProrrogaV").empty();
      $("#RegistrosSuspensionV").empty();
      $("#RegistrosCesionV").empty();
      $("#RegistrosObligacionV").empty();

      $("#TablaAdicionV").hide('slow');
      $("#TablaProrrogaV").hide('slow');
      $("#TablaSuspencionV").hide('slow');
      $("#TablaCesionV").hide('slow');
      $("#TablaObligacionV").hide('slow');

      $.get("getContratoOne/"+$(this).val(), function (Contrato) { 
        if(Contrato){
          $("#VerContratoD").modal('show');
          $("#Tipo_Documento_InicialV").val(Contrato['Tipo_Documento']).change();
          $("#Cedula_ContratistaV").val(Contrato['Cedula']);
          $("#DvV").val(Contrato['Dv']);
          $("#Tipo_Documento_RepresentanteV").val(Contrato['Tipo_Documento_Representante']).change();
          $("#Cedula_RepresentanteV").val(Contrato['Cedula_Representante']);
          $("#Dias_DuracionV").val(Contrato['Dias_Duracion']);
          $("#FechaFinV").val(Contrato['Fecha_Fin']);
          $("#FechaFirmaV").val(Contrato['Fecha_Firma']);
          $("#FechaInicioV").val(Contrato['Fecha_Inicio']);
          $("#FechaFinAnticipadoV").val(Contrato['Fecha_Terminacion_Anticipada']);
          $("#Meses_DuracionV").val(Contrato['Meses_Duracion']);
          $("#Nombre_ContratistaV").val(Contrato['Nombre_Contratista']);
          $("#Nombre_RepresentanteV").val(Contrato['Nombre_Representante']);
          $("#Numero_ContratoV").val(Contrato['Numero_Contrato']);
          $("#Objeto_ContratoV").val(Contrato['Objeto']);
          $("#Otra_DuracionV").val(Contrato['Otra_Duracion']);          
          $("#Tipo_ContratoV").val(Contrato.tipocontrato['Nombre_Tipo_Contrato']);
          $("#Valor_InicialV").val(Contrato['Valor_Inicial']);
          $("#Valor_MensualV").val(Contrato['Valor_Mensual']);
          $("#FechaFinContratoV").val(Contrato['fecha_Final_CTO']);
          if(Contrato.adicion.length > 0){
            $("#NuevaAdicionDV").show('slow');
             var html = '';
              $.each(Contrato.adicion, function(i, e){
                html += '<tr><td>'+e['Numero_Adicion']+'</td><td>'+e['Valor_Adicion']+'</td></tr>';                
              });
              $("#RegistrosAdicionV").empty();
              $("#RegistrosAdicionV").html(html);
              $("#TablaAdicionV").show('slow');
          }

          if(Contrato.prorroga.length > 0){
            $("#NuevaProrrogaDV").show('slow');
            var html = '';
            $.each(Contrato.prorroga, function(i, e){
                html += '<tr>'+
                          '<td>'+e['Numero_Prorroga']+'</td>'+
                          '<td>'+e['Meses']+'</td>'+
                          '<td>'+e['Dias']+'</td>'+
                          '<td>'+e['Fecha_Fin']+'</td>'+
                        '</tr>';                
              });

              $("#RegistrosProrrogaV").empty();
              $("#RegistrosProrrogaV").html(html);
              $("#TablaProrrogaV").show('slow');
          }

          if(Contrato.suspencion.length > 0){
            $("#NuevaSuspencionDV").show('slow');
            var html = '';
            $.each(Contrato.suspencion, function(i, e){
                html += '<tr>'+
                          '<td>'+e['Numero_Suspencion']+'</td>'+
                          //'<td>'+e['Objeto_Suspension']+'</td>'+
                          '<td>'+e['Meses']+'</td>'+
                          '<td>'+e['Dias']+'</td>'+
                          '<td>'+e['Fecha_Inicio']+'</td>'+
                          '<td>'+e['Fecha_Fin']+'</td>'+
                          '<td>'+e['Fecha_Reinicio']+'</td>'+
                        '</tr>';                
              });

              $("#RegistrosSuspencionV").empty();
              $("#RegistrosSuspencionV").html(html);
              $("#TablaSuspencionV").show('slow');
          }

          if(Contrato.cesion.length > 0){
            $("#NuevaCesionDV").show('slow');
            var html = '';
            $.each(Contrato.cesion, function(i, e){
                  html += '<tr>'+
                            '<td>'+e['Numero_Cesion']+'</td>'+
                            '<td>'+e['Nombre_Cesionario']+'</td>'+
                            '<td>'+e['Cedula_Cesionario']+'</td>'+
                            '<td>'+e['Dv_Cesion']+'</td>'+
                            '<td>'+e['Valor_Cedido']+'</td>'+
                            '<td>'+e['Fecha_Cesion']+'</td>'+
                          '</tr>';                
                });

                $("#RegistrosCesionV").empty();
                $("#RegistrosCesionV").html(html);
                $("#TablaCesionV").show('slow');
          }

          if(Contrato.obligacion.length > 0){
            $("#NuevaObligacionDV").show('slow');
            var html = '';
            $.each(Contrato.obligacion, function(i, e){
                  html += '<tr>'+
                            '<td>'+e['Numero_Obligacion']+'</td>'+
                            '<td>'+e['Objeto_Obligacion']+'</td>'+
                          '</tr>';                
                });

                $("#RegistrosObligacionV").empty();
                $("#RegistrosObligacionV").html(html);
                $("#TablaObligacionV").show('slow');
          }
        }
      });
    }); 

  $('body').delegate('button[data-funcion="modificarContrato"]','click',function (e) {  
    Adicion = new Array();
    Prorroga = new Array();
    Suspencion = new Array();
    Cesion = new Array();
    Obligacion = new Array();

    $("#RegistrosAdicionM").empty();
    $("#RegistrosProrrogaM").empty();
    $("#RegistrosSuspencionM").empty();
    $("#RegistrosCesionM").empty();
    $("#RegistrosObligacionM").empty();

    $("#TablaAdicionM").show('slow');
    $("#TablaProrrogaM").show('slow');
    $("#TablaSuspencionM").show('slow');
    $("#TablaCesionM").show('slow');
    $("#TablaObligacionM").show('slow');

    $("#ModificarContratoD").modal('show');
    $.get("getContratoOne/"+$(this).val(), function (Contrato) { 
      if(Contrato){
        $("#Id_ContratoM").val(Contrato['Id']);
        $("#Tipo_Documento_InicialM").val(Contrato['Tipo_Documento']).change();
        $("#Cedula_ContratistaM").val(Contrato['Cedula']);
        $("#DvM").val(Contrato['Dv']);
        $("#Tipo_Documento_RepresentanteM").val(Contrato['Tipo_Documento_Representante']);
        $("#Cedula_RepresentanteM").val(Contrato['Cedula_Representante']);
        $("#Dias_DuracionM").val(Contrato['Dias_Duracion']);
        $("#FechaFinM").val(Contrato['Fecha_Fin']);
        $("#FechaFirmaM").val(Contrato['Fecha_Firma']);
        $("#FechaInicioM").val(Contrato['Fecha_Inicio']);
        $("#FechaFinAnticipadoM").val(Contrato['Fecha_Terminacion_Anticipada']);
        $("#Meses_DuracionM").val(Contrato['Meses_Duracion']);
        $("#Nombre_ContratistaM").val(Contrato['Nombre_Contratista']);
        $("#Nombre_RepresentanteM").val(Contrato['Nombre_Representante']);
        $("#Numero_ContratoM").val(Contrato['Numero_Contrato']);
        $("#Objeto_ContratoM").val(Contrato['Objeto']);
        $("#Otra_DuracionM").val(Contrato['Otra_Duracion']);          
        $("#Tipo_ContratoM").val(Contrato['Tipo_Contrato_Id']);
        $("#Valor_InicialM").val(Contrato['Valor_Inicial']);
        $("#Valor_MensualM").val(Contrato['Valor_Mensual']);
        $("#FechaFinContratoM").val(Contrato['fecha_Final_CTO']);

        if(Contrato.adicion.length > 0){
          $("#NuevaAdicionDM").show('slow');
           var html = '';
            $.each(Contrato.adicion, function(i, e){
              Adicion.push({"Numero_Adicion": e['Numero_Adicion'], "Valor_Adicion": e['Valor_Adicion']});
              html += '<tr>'+
                            '<td>'+e['Numero_Adicion']+'</td>'+
                            '<td>'+e['Valor_Adicion']+'</td>'+
                            '<td><button type="button" data-funcion="EliminarAdicion" class="btn btn-danger" value="'+i+'">Eliminar</button></td>'+
                          '</tr>';
            });
            $("#RegistrosAdicionM").empty();
            $("#RegistrosAdicionM").html(html);
            $("#TablaAdicionM").show('slow');
        }

        if(Contrato.prorroga.length > 0){
            $("#NuevaProrrogaDM").show('slow');
            var html = '';
            $.each(Contrato.prorroga, function(i, e){
              Prorroga.push({"Numero_Prorroga" : e['Numero_Prorroga'],
                            "Meses_Prorroga" : e['Meses'],
                            "Dias_Prorroga" : e['Dias'],
                            "FechaFinCtoProrroga" : e['Fecha_Fin'],
                          });
              html += '<tr>'+
                        '<td>'+e['Numero_Prorroga']+'</td>'+
                        '<td>'+e['Meses']+'</td>'+
                        '<td>'+e['Dias']+'</td>'+
                        '<td>'+e['Fecha_Fin']+'</td>'+
                        '<td><button type="button" data-funcion="EliminarProrroga" class="btn btn-danger" value="'+i+'">Eliminar</button></td>'+
                      '</tr>';                
              });

              $("#RegistrosProrrogaM").empty();
              $("#RegistrosProrrogaM").html(html);
              $("#TablaProrrogaM").show('slow');
          }

          if(Contrato.suspencion.length > 0){
            $("#NuevaSuspencionDM").show('slow');
            var html = '';
            $.each(Contrato.suspencion, function(i, e){
              Suspencion.push({"Numero_Suspencion" : e['Numero_Suspencion'],
                              //"Objeto_Suspencion" : e['Objeto_Suspension'],
                              "Meses_Suspencion" : e['Meses'],
                              "Dias_Suspencion" : e['Dias'],
                              "FechaInicioSuspencion" : e['Fecha_Inicio'],
                              "FechaFinSuspencion" : e['Fecha_Fin'],
                              "FechaReinicioSuspencion" : e['Fecha_Reinicio'],
                            });
                html += '<tr>'+
                          '<td>'+e['Numero_Suspencion']+'</td>'+
                          //'<td>'+e['Objeto_Suspension']+'</td>'+
                          '<td>'+e['Meses']+'</td>'+
                          '<td>'+e['Dias']+'</td>'+
                          '<td>'+e['Fecha_Inicio']+'</td>'+
                          '<td>'+e['Fecha_Fin']+'</td>'+
                          '<td>'+e['Fecha_Reinicio']+'</td>'+
                          '<td><button type="button" data-funcion="EliminarSuspencion" class="btn btn-danger" value="'+i+'">Eliminar</button></td>'+
                        '</tr>';                
              });

              $("#RegistrosSuspencionM").empty();
              $("#RegistrosSuspencionM").html(html);
              $("#TablaSuspencionM").show('slow');
          }

          if(Contrato.cesion.length > 0){
            $("#NuevaCesionDM").show('slow');
            var html = '';
            $.each(Contrato.cesion, function(i, e){
              Cesion.push({"Numero_Cesion" : e['Numero_Cesion'],
                         "Nombre_Cesionario" : e['Nombre_Cesionario'],
                         "Tipo_Documento_Cesionario" : e['Tipo_Documento_Cesionario'],
                         "Cedula_Cesionario" : e['Cedula_Cesionario'],
                         "Dv_Cesion" : e['Dv_Cesion'],
                         "Valor_Cesion" : e['Valor_Cedido'],
                         "FechaCesion" : e['Fecha_Cesion']
                        });
                  html += '<tr>'+
                            '<td>'+e['Numero_Cesion']+'</td>'+
                            '<td>'+e['Nombre_Cesionario']+'</td>'+
                            '<td>'+e['Cedula_Cesionario']+'</td>'+
                            '<td>'+e['Dv_Cesion']+'</td>'+
                            '<td>'+e['Valor_Cedido']+'</td>'+
                            '<td>'+e['Fecha_Cesion']+'</td>'+
                            '<td><button type="button" data-funcion="EliminarCesion" class="btn btn-danger" value="'+i+'">Eliminar</button></td>'+
                          '</tr>';                
                });

                $("#RegistrosCesionM").empty();
                $("#RegistrosCesionM").html(html);
                $("#TablaCesionM").show('slow');
          }

          if(Contrato.obligacion.length > 0){
            $("#NuevaObligacionDM").show('slow');
            var html = '';
            $.each(Contrato.obligacion, function(i, e){
              Obligacion.push({"Numero_Obligacion" : e['Numero_Obligacion'], "Obligacion" : e['Objeto_Obligacion']});
              html += '<tr>'+
                        '<td>'+e['Numero_Obligacion']+'</td>'+
                        '<td>'+e['Objeto_Obligacion']+'</td>'+
                        '<td><button type="button" data-funcion="EliminarObligacion" class="btn btn-danger" value="'+i+'">Eliminar</button></td>'+
                      '</tr>';                
                });

                $("#RegistrosObligacionM").empty();
                $("#RegistrosObligacionM").html(html);
                $("#TablaObligacionM").show('slow');
          }
      }
    });
  });

    $("#NuevaAdicionM").on('click', function(){
        $("#NuevaAdicionDM").show('slow');
    });

    $("#NuevaProrrogaM").on('click', function(){
        $("#NuevaProrrogaDM").show('slow');
    });

    $("#NuevaSuspencionM").on('click', function(){
        $("#NuevaSuspencionDM").show('slow');
    });

    $("#NuevaCesionM").on('click', function(){
        $("#NuevaCesionDM").show('slow');
    });

    $("#NuevaObligacionM").on('click', function(){
        $("#NuevaObligacionDM").show('slow');
    });

    $("#AgregarAdicionM").on('click', function(){
        var formData = new FormData($("#modificarContratoF")[0]);    
        $.ajax({
          url: 'revAdicionM',  
          type: 'POST',
          data: formData,          
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (xhr) {
            if(xhr.status == 'error'){
              validador_erroresM(xhr.errors);
            }
            else if(xhr.status == 'success'){
                $('#modificarContratoF .form-group').removeClass('has-error');
                Adicion.push({"Numero_Adicion":(Adicion.length)+1,  "Valor_Adicion": $("input[name=Valor_AdicionM]").val()});

                $("input[name=Valor_AdicionM]").val('');

                var html = '';
                $.each(Adicion, function(i, e){
                  html += '<tr>'+
                            '<td>'+e['Numero_Adicion']+'</td>'+
                            '<td>'+e['Valor_Adicion']+'</td>'+
                            '<td><button type="button" data-funcion="EliminarAdicion" class="btn btn-danger" value="'+i+'">Eliminar</button></td>'+
                          '</tr>';
                });

                $("#RegistrosAdicionM").empty();
                $("#RegistrosAdicionM").html(html);
                $("#TablaAdicionM").show('slow');
                validador_erroresM(xhr.responseJSON);
            }
          },
          error: function (xhr){
            validador_erroresM(xhr.responseJSON);
          }
        });
    });

    $("#AgregarProrrogaM").on('click', function(){
        var formData = new FormData($("#modificarContratoF")[0]);   
        $.ajax({
          url: 'revProrrogaM',  
          type: 'POST',
          data: formData,          
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (xhr) {
            if(xhr.status == 'error'){
              validador_erroresM(xhr.errors);
            }
            else if(xhr.status == 'success'){
                $('#modificarContratoF .form-group').removeClass('has-error');
                Prorroga.push({"Numero_Prorroga":(Prorroga.length)+1,
                               "Meses_Prorroga" : $("input[name=Meses_ProrrogaM]").val(),
                               "Dias_Prorroga" : $("input[name=Dias_ProrrogaM]").val(),
                               "FechaFinCtoProrroga" : $("input[name=FechaFinCtoProrrogaM]").val(),
                              });

                $("input[name=Meses_ProrrogaM]").val('');
                $("input[name=Dias_ProrrogaM]").val('');
                $("input[name=FechaFinCtoProrrogaM]").val('');

                var html = '';
                $.each(Prorroga, function(i, e){
                  html += '<tr>'+
                        '<td>'+e['Numero_Prorroga']+'</td>'+
                        '<td>'+e['Meses_Prorroga']+'</td>'+
                        '<td>'+e['Dias_Prorroga']+'</td>'+
                        '<td>'+e['FechaFinCtoProrroga']+'</td>'+
                        '<td><button type="button" data-funcion="EliminarProrroga" class="btn btn-danger" value="'+i+'">Eliminar</button></td>'+
                      '</tr>';                 
                });

                $("#RegistrosProrrogaM").empty();
                $("#RegistrosProrrogaM").html(html);
                $("#TablaProrrogaM").show('slow');
            }
          },
          error: function (xhr){
            validador_erroresM(xhr.responseJSON);
          }
        });
    });

    $("#AgregarSuspencionM").on('click', function(){
        var formData = new FormData($("#modificarContratoF")[0]);          
        $.ajax({
          url: 'revSuspencionM',  
          type: 'POST',
          data: formData,          
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (xhr) {
            if(xhr.status == 'error'){
              validador_erroresM(xhr.errors);
            }
            else if(xhr.status == 'success'){
                $('#modificarContratoF .form-group').removeClass('has-error');
                Suspencion.push({"Numero_Suspencion": (Suspencion.length)+1,
                               //"Objeto_Suspencion" : $("textarea[name=Objeto_SuspencionM]").val(),
                               "Meses_Suspencion" : $("input[name=Meses_SuspencionM]").val(),
                               "Dias_Suspencion" : $("input[name=Dias_SuspencionM]").val(),
                               "FechaInicioSuspencion" : $("input[name=FechaInicioSuspencionM]").val(),
                               "FechaFinSuspencion" : $("input[name=FechaFinSuspencionM]").val(),
                               "FechaReinicioSuspencion" : $("input[name=FechaReinicioSuspencionM]").val(),
                              });

                //$("textarea[name=Objeto_SuspencionM]").val('');
                $("input[name=Meses_SuspencionM]").val('');
                $("input[name=Dias_SuspencionM]").val('');
                $("input[name=FechaInicioSuspencionM]").val('');
                $("input[name=FechaFinSuspencionM]").val('');
                $("input[name=FechaReinicioSuspencionM]").val('');

                var html = '';
                $.each(Suspencion, function(i, e){
                  html += '<tr>'+
                            '<td>'+e['Numero_Suspencion']+'</td>'+
                            //'<td>'+e['Objeto_Suspencion']+'</td>'+
                            '<td>'+e['Meses_Suspencion']+'</td>'+
                            '<td>'+e['Dias_Suspencion']+'</td>'+
                            '<td>'+e['FechaInicioSuspencion']+'</td>'+
                            '<td>'+e['FechaFinSuspencion']+'</td>'+
                            '<td>'+e['FechaReinicioSuspencion']+'</td>'+
                            '<td><button type="button" data-funcion="EliminarSuspencion" class="btn btn-danger" value="'+i+'">Eliminar</button></td>'+
                          '</tr>';                
                });

                $("#RegistrosSuspencionM").empty();
                $("#RegistrosSuspencionM").html(html);
                $("#TablaSuspencionM").show('slow');
            }
          },
          error: function (xhr){
            validador_erroresM(xhr.responseJSON);
          }
        });
    });

$("#AgregarCesionM").on('click', function(){
        var formData = new FormData($("#modificarContratoF")[0]);
        $.ajax({
          url: 'revCesionM',  
          type: 'POST',
          data: formData,          
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (xhr) {
            if(xhr.status == 'error'){
              validador_erroresM(xhr.errors);
            }
            else if(xhr.status == 'success'){
                $('#modificarContratoF .form-group').removeClass('has-error');
                Cesion.push({"Numero_Cesion":(Cesion.length)+1,
                             "Nombre_Cesionario" : $("input[name=Nombre_CesionarioM]").val(),
                             "Tipo_Documento_Cesionario" : $("#Tipo_Documento_CesionM").val(),
                             "Cedula_Cesionario" : $("input[name=Cedula_CesionarioM]").val(),
                             "Dv_Cesion" : $("input[name=Dv_CesionM]").val(),
                             "Valor_Cesion" : $("input[name=Valor_CesionM]").val(),
                             "FechaCesion" : $("input[name=FechaCesionM]").val()
                            });

                $("input[name=Nombre_CesionarioM]").val('');
                $("input[name=Cedula_CesionarioM]").val('');
                $("input[name=Tipo_Documento_CesionM]").val('');
                $("input[name=Dv_CesionM]").val('');
                $("input[name=Valor_CesionM]").val('');
                $("input[name=FechaCesionM]").val('');

                var html = '';
                $.each(Cesion, function(i, e){
                  html += '<tr>'+
                            '<td>'+e['Numero_Cesion']+'</td>'+
                            '<td>'+e['Nombre_Cesionario']+'</td>'+
                            '<td>'+e['Cedula_Cesionario']+'</td>'+
                            '<td>'+e['Dv_Cesion']+'</td>'+
                            '<td>'+e['Valor_Cesion']+'</td>'+
                            '<td>'+e['FechaCesion']+'</td>'+
                            '<td><button type="button" data-funcion="EliminarCesion" class="btn btn-danger" value="'+i+'">Eliminar</button></td>'+
                          '</tr>';                
                });

                $("#RegistrosCesionM").empty();
                $("#RegistrosCesionM").html(html);
                $("#TablaCesionM").show('slow');
            }
          },
          error: function (xhr){
            validador_erroresM(xhr.responseJSON);
          }
        });
    });

 $("#AgregarObligacionM").on('click', function(){
        var formData = new FormData($("#modificarContratoF")[0]);          
        $.ajax({
          url: 'revObligacionM',  
          type: 'POST',
          data: formData,          
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (xhr) {
            if(xhr.status == 'error'){
              validador_errores(xhr.errors);
            }
            else if(xhr.status == 'success'){
                $('#modificarContratoF .form-group').removeClass('has-error');
                Obligacion.push({"Numero_Obligacion":(Obligacion.length)+1,"Obligacion" : $("textarea[name=ObligacionM]").val()});

                $("textarea[name=ObligacionM]").val('');

                var html = '';
                $.each(Obligacion, function(i, e){
                  html += '<tr>'+
                            '<td>'+e['Numero_Obligacion']+'</td>'+
                            '<td>'+e['Obligacion']+'</td>'+
                            '<td><button type="button" data-funcion="EliminarObligacion" class="btn btn-danger" value="'+i+'">Eliminar</button></td>'+
                          '</tr>';                
                });

                $("#RegistrosObligacionM").empty();
                $("#RegistrosObligacionM").html(html);
                $("#TablaObligacionM").show('slow');
            }
          },
          error: function (xhr){
            validador_errores(xhr.responseJSON);
          }
        });
    });

    $("#Modificar").on('click', function(){
        var formData = new FormData($("#modificarContratoF")[0]);   
        var json_vector_adicion = JSON.stringify(Adicion);
        formData.append("Adicion",json_vector_adicion);

        var json_vector_prorroga = JSON.stringify(Prorroga);
        formData.append("Prorroga",json_vector_prorroga);

        var json_vector_suspencion = JSON.stringify(Suspencion);
        formData.append("Suspencion",json_vector_suspencion);

        var json_vector_cesion = JSON.stringify(Cesion);
        formData.append("Cesion",json_vector_cesion);

        var json_vector_obligacion = JSON.stringify(Obligacion);
        formData.append("Obligacion",json_vector_obligacion);

        $.ajax({
          url: 'EditContrato',  
          type: 'POST',
          data: formData,          
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (xhr) {
            if(xhr.status == 'error'){
              validador_erroresM(xhr.errors);
            }
            else if(xhr.status == 'success'){
                $('#modificarContratoF .form-group').removeClass('has-error');     
                $('#mensajeEdit').html('<div class="alert alert-dismissible alert-success" ><strong>Exito!</strong>'+xhr.Mensaje+'</div>');
                $('#mensajeEdit').show(60);
                $('#mensajeEdit').delay(1500).hide(600);    
                setTimeout(function(){
                  $("#ModificarContratoD").modal('hide');
                }, 2000);
               /* $.get("getContrato", function (ContratosDatos) { 
                    var t = $('#datosTabla').DataTable();
                    t.row.add(['1','1','1','1','1'] ).clear().draw( false );
                    $.each(ContratosDatos, function(i, e){
                        t.row.add( [
                            e['Cedula'],                        
                            e['Nombre_Contratista'],                            
                            e['Numero_Contrato'],
                            e['Fecha_Inicio'],
                            '<button type="button" class="btn btn-info" data-funcion="verContrato" value="'+e['Id']+'" >'+
                                '<span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>'+
                            '</button>'+
                            '<button type="button" class="btn btn-primary" data-funcion="modificarContrato" value="'+e['Id']+'" >'+
                                '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'+
                            '</button>'+
                            '<button type="button" class="btn btn-danger" data-funcion="eliminarContrato" value="'+e['Id']+'" >'+
                                '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'+
                            '</button>',
                        ] ).draw( false );
                    });
                });*/
            }            
          },
          error: function (xhr){
            validador_erroresM(xhr.responseJSON);
          }
        });
    });
  var validador_erroresM = function(data){
      $('#modificarContratoF .form-group').removeClass('has-error');
      $.each(data, function(i, e){
        $("#"+i).closest('.form-group').addClass('has-error');
      });
    }

  $('#RegistrosAdicionM').delegate('button[data-funcion="EliminarAdicion"]','click',function (e) {  
      Adicion.splice(($(this).val()), 1);
      var html = '';
      $.each(Adicion, function(i, e){
        html += '<tr>'+
                  '<td>'+e['Numero_Adicion']+'</td>'+
                  '<td>'+e['Valor_Adicion']+'</td>'+
                  '<td><button type="button" data-funcion="EliminarAdicion" class="btn btn-danger" value="'+i+')">Eliminar</button></td>'+
                '</tr>';
      });

      $("#RegistrosAdicionM").empty();
      $("#RegistrosAdicionM").html(html);
      $("#TablaAdicionM").show('slow');
  });

  $('#RegistrosProrrogaM').delegate('button[data-funcion="EliminarProrroga"]','click',function (e) {  
      Prorroga.splice(($(this).val()), 1);
      var html = '';
      $.each(Prorroga, function(i, e){
        html += '<tr>'+
              '<td>'+e['Numero_Prorroga']+'</td>'+
              '<td>'+e['Meses_Prorroga']+'</td>'+
              '<td>'+e['Dias_Prorroga']+'</td>'+
              '<td>'+e['FechaFinCtoProrroga']+'</td>'+
              '<td><button type="button" data-funcion="EliminarProrroga" class="btn btn-danger" value="'+i+'">Eliminar</button></td>'+
            '</tr>';                 
      });

      $("#RegistrosProrrogaM").empty();
      $("#RegistrosProrrogaM").html(html);
      $("#TablaProrrogaM").show('slow');
  });

  $('#RegistrosSuspencionM').delegate('button[data-funcion="EliminarSuspencion"]','click',function (e) {  
      Suspencion.splice(($(this).val()), 1);
      var html = '';
      $.each(Suspencion, function(i, e){
        html += '<tr>'+
                  '<td>'+e['Numero_Suspencion']+'</td>'+
                  //'<td>'+e['Objeto_Suspencion']+'</td>'+
                  '<td>'+e['Meses_Suspencion']+'</td>'+
                  '<td>'+e['Dias_Suspencion']+'</td>'+
                  '<td>'+e['FechaInicioSuspencion']+'</td>'+
                  '<td>'+e['FechaFinSuspencion']+'</td>'+
                  '<td>'+e['FechaReinicioSuspencion']+'</td>'+
                  '<td><button type="button" data-funcion="EliminarSuspencion" class="btn btn-danger" value="'+i+'">Eliminar</button></td>'+
                '</tr>';                
      });

      $("#RegistrosSuspencionM").empty();
      $("#RegistrosSuspencionM").html(html);
      $("#TablaSuspencionM").show('slow');
  });

  $('#RegistrosCesionM').delegate('button[data-funcion="EliminarCesion"]','click',function (e) {  
      Cesion.splice(($(this).val()), 1);
      var html = '';
      $.each(Cesion, function(i, e){
        html += '<tr>'+
                  '<td>'+e['Numero_Cesion']+'</td>'+
                  '<td>'+e['Nombre_Cesionario']+'</td>'+
                  '<td>'+e['Cedula_Cesionario']+'</td>'+
                  '<td>'+e['Dv_Cesion']+'</td>'+
                  '<td>'+e['Valor_Cesion']+'</td>'+
                  '<td>'+e['FechaCesion']+'</td>'+
                  '<td><button type="button" data-funcion="EliminarCesion" class="btn btn-danger" value="'+i+'">Eliminar</button></td>'+
                '</tr>';                
      });

      $("#RegistrosCesionM").empty();
      $("#RegistrosCesionM").html(html);
      $("#TablaCesionM").show('slow');
  });

  $('#RegistrosObligacionM').delegate('button[data-funcion="EliminarObligacion"]','click',function (e) {  
      Obligacion.splice(($(this).val()), 1);
      var html = '';
      $.each(Obligacion, function(i, e){
        html += '<tr>'+
                  '<td>'+e['Numero_Obligacion']+'</td>'+
                  '<td>'+e['Obligacion']+'</td>'+
                  '<td><button type="button" data-funcion="EliminarObligacion" class="btn btn-danger" value="'+i+'">Eliminar</button></td>'+
                '</tr>';                
      });

      $("#RegistrosObligacionM").empty();
      $("#RegistrosObligacionM").html(html);
      $("#TablaObligacionM").show('slow');
  });

  $('body').delegate('button[data-funcion="eliminarContrato"]','click',function (e) {      
    var datos = {Id:$(this).val()};
    $.ajax({
      url: 'DeleteContrato',  
      type: 'POST',
      data: datos,          
      dataType: "json",
      success: function (xhr) {
        if(xhr.status == 'error'){
          validador_errores(xhr.errors);
        }
        else if(xhr.status == 'success'){
            $("#EliminarContratoD").modal('show');
            $('#modificarContratoF .form-group').removeClass('has-error');     
            $('#mensajeDelete').html('<div class="alert alert-dismissible alert-success" ><strong>Exito!</strong>'+xhr.Mensaje+'</div>');
            $('#mensajeDelete').show(60);
            $('#mensajeDelete').delay(1500).hide(600);    
            setTimeout(function(){
              $("#EliminarContratoD").modal('hide');
            }, 2000);

            table.row('.selected').remove().draw( false );
            
           /* $.get("getContrato", function (ContratosDatos) { 
                var t = $('#datosTabla').DataTable();
                t.row.add(['1','1','1','1','1'] ).clear().draw( false );
                $.each(ContratosDatos, function(i, e){
                    t.row.add( [
                        e['Cedula'],                        
                        e['Nombre_Contratista'],                            
                        e['Numero_Contrato'],
                            e['Fecha_Inicio'],
                        '<button type="button" class="btn btn-info" data-funcion="verContrato" value="'+e['Id']+'" >'+
                            '<span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>'+
                        '</button>'+
                        '<button type="button" class="btn btn-primary" data-funcion="modificarContrato" value="'+e['Id']+'" >'+
                            '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'+
                        '</button>'+
                        '<button type="button" class="btn btn-danger" data-funcion="eliminarContrato" value="'+e['Id']+'" >'+
                            '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'+
                        '</button>',
                    ] ).draw( false );
                });
            });*/
        }            
      },
      error: function (xhr){
        validador_errores(xhr.responseJSON);
      }
    });
  });

  $("#Tipo_Documento_Inicial").on('change', function(){    
    $("#Dv_Inicial").hide('slow');
    $("#RepresentanteDiv").hide('slow');
    
    $("#Numero_Cedula_Inicial").empty();

    if($(this).val() == 1){
      $("#Numero_Cedula_Inicial").append('Número de cédula');  
    }
    if($(this).val() == 2){
      $("#Numero_Cedula_Inicial").append('Número de tarjeta de identidad');  
    }
    if($(this).val() == 3){
      $("#Numero_Cedula_Inicial").append('Número de registro civil');  
    }
    if($(this).val() == 4){
      $("#Numero_Cedula_Inicial").append('Número de cédula de extranjería');  
    }
    if($(this).val() == 5){
      $("#Numero_Cedula_Inicial").append('Número de D.N.I');  
    }
    if($(this).val() == 6){
      $("#Numero_Cedula_Inicial").append();  
    }
    if($(this).val() == 7){
      $("#Numero_Cedula_Inicial").append('Número de NIT');  
      $("#Dv_Inicial").show('slow');
      $("#RepresentanteDiv").show('slow');
    }    
  });

  $("#Tipo_Documento_InicialV").on('change', function(){    
    $("#Dv_InicialV").hide('slow');
    $("#RepresentanteDivV").hide('slow');
    
    $("#Numero_Cedula_InicialV").empty();

    if($(this).val() == 1){
      $("#Numero_Cedula_InicialV").append('Número de cédula');  
    }
    if($(this).val() == 2){
      $("#Numero_Cedula_InicialV").append('Número de tarjeta de identidad');  
    }
    if($(this).val() == 3){
      $("#Numero_Cedula_InicialV").append('Número de registro civil');  
    }
    if($(this).val() == 4){
      $("#Numero_Cedula_InicialV").append('Número de cédula de extranjería');  
    }
    if($(this).val() == 5){
      $("#Numero_Cedula_InicialV").append('Número de D.N.I');  
    }
    if($(this).val() == 6){
      $("#Numero_Cedula_InicialV").append();  
    }
    if($(this).val() == 7){
      $("#Numero_Cedula_InicialV").append('Número de NIT');  
      $("#Dv_InicialV").show('slow');
      $("#RepresentanteDivV").show('slow');
    }    
  });

  $("#Tipo_Documento_InicialM").on('change', function(){    
    $("#Dv_InicialM").hide('slow');
    $("#RepresentanteDivM").hide('slow');
    
    $("#Numero_Cedula_InicialM").empty();

    if($(this).val() == 1){
      $("#Numero_Cedula_InicialM").append('Número de cédula');  
    }
    if($(this).val() == 2){
      $("#Numero_Cedula_InicialM").append('Número de tarjeta de identidad');  
    }
    if($(this).val() == 3){
      $("#Numero_Cedula_InicialM").append('Número de registro civil');  
    }
    if($(this).val() == 4){
      $("#Numero_Cedula_InicialM").append('Número de cédula de extranjería');  
    }
    if($(this).val() == 5){
      $("#Numero_Cedula_InicialM").append('Número de D.N.I');  
    }
    if($(this).val() == 6){
      $("#Numero_Cedula_InicialM").append();  
    }
    if($(this).val() == 7){
      $("#Numero_Cedula_InicialM").append('Número de NIT');  
      $("#Dv_InicialM").show('slow');
      $("#RepresentanteDivM").show('slow');
    }    
  });

  $("#Tipo_Documento_Cesion").on('change', function(){    
    $("#Dv_Cesion").hide('slow');

    if($(this).val() == 7){
      $("#Dv_Cesion").show('slow');
    }    
  });

  $("#Tipo_Documento_CesionM").on('change', function(){    
    $("#Dv_CesionM").hide('slow');
        
    if($(this).val() == 7){
      $("#Dv_CesionM").show('slow');
    }    
  });

  
});