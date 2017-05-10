$(function(){

  $("#AnioDate").datepicker( {
    format: "yyyy",
    viewMode: "years", 
    minViewMode: "years"
  }).on('changeDate', function(e){
    $(this).datepicker('hide');
  });

  $('#TablaVarios').DataTable({
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

  $("#Expedir").on('click', function(){
    $("#VariosD").hide('slow');
    var formData = new FormData($("#generarPdf")[0]);    
    $.ajax({
      url: 'getContratoExp',  
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
          $('#generarPdf .form-group').removeClass('has-error');
          if(xhr.Contrato == 'Unico'){
            if(xhr.ObligacionesCheck == 1 && xhr.ConteoObligacion == 0){
              alert('Este contrato aún no cuenta con las obligaciones específicas, si desea descargarla con las mismas, por favor diríjase al botón naranja "Realizar Solicitud", y envié un soporte para que estas sean agregadas.');
            }else{
              window.open('descargarContrato/'+xhr.Id+'/'+xhr.ObligacionesCheck,'_blank');    
            }
            
          }else if(xhr.Contrato == 'Varios'){
            $("#RegistrosVarios").empty();                            
            var t = $('#TablaVarios').DataTable();
            t.row.add(['1','1','1','1','1'] ).clear().draw( false );

            $.each(xhr.DatosContrato, function(i, e){
              t.row.add( [
                         e['Cedula'],
                         e['Nombre_Contratista'],
                         e['Numero_Contrato'],
                         e['Fecha_Firma'],
                         '<center><button type="button" class="btn btn-primary"  data-funcion="descargar" value="'+e['Id']+'" >'+
                            '<span class="glyphicon glyphicon-circle-arrow-down" aria-hidden="true"></span>'+
                         '</button></center>',
                      ] ).draw( false );               
            });
            $("#RegistrosVarios").show('slow');
            $("#VariosD").show('slow');

          }
          else if(xhr.Contrato == 'No hay'){
            $('#mensaje').html('<div class="alert alert-dismissible alert-danger" ><strong>Exito!</strong>No existen contratos con estos datos!.</div>');
            $('#mensaje').show(60);
            $('#mensaje').delay(1500).hide(600);    
          }            
        }
      },
      error: function (xhr){
        validador_errores(xhr.responseJSON);
      }
    });
  });

   var validador_errores = function(data){
      $('#generarPdf .form-group').removeClass('has-error');
      $.each(data, function(i, e){
        $("#"+i).closest('.form-group').addClass('has-error');
      });
    }

    $('#TablaVarios').delegate('button[data-funcion="descargar"]','click',function (e) {
      if (document.getElementById('ObligacionesCheck').checked) {
        m = 1;
    }
    else {
        m = null;
    }
      $.ajax({
        url: 'getContratoUnico',  
        type: 'POST',
        data: {Id: $(this).val(), ObligacionesCheck: m},          
        dataType: "json",
        success: function (xhr) {
          if(xhr.status == 'error'){
            validador_errores(xhr.errors);
          }
          else if(xhr.status == 'success'){
            $('#generarPdf .form-group').removeClass('has-error');
            if(xhr.Contrato == 'Unico'){
              if(m == 1 && xhr.ConteoObligacion == 0){
                alert('Este contrato aún no cuenta con las obligaciones específicas, si desea descargarla con las mismas, por favor diríjase al botón naranja "Realizar Solicitud", y envié un soporte para que estas sean agregadas.');
              }else{
                window.open('descargarContrato/'+xhr.Id+'/'+m,'_blank');    
              }
            }else if(xhr.Contrato == 'Varios'){
              $("#RegistrosVarios").empty();                            
              var t = $('#TablaVarios').DataTable();
              t.row.add(['1','1','1','1','1'] ).clear().draw( false );

              $.each(xhr.DatosContrato, function(i, e){
                t.row.add( [
                           e['Cedula'],
                           e['Nombre_Contratista'],
                           e['Numero_Contrato'],
                           e['Fecha_Firma'],
                           '<center><button type="button" class="btn btn-primary"  data-funcion="descargar" value="'+e['Id']+'" >'+
                              '<span class="glyphicon glyphicon-circle-arrow-down" aria-hidden="true"></span>'+
                           '</button></center>',
                        ] ).draw( false );               
              });
              $("#RegistrosVarios").show('slow');
              $("#VariosD").show('slow');

            }
            else if(xhr.Contrato == 'No hay'){
              $('#mensaje').html('<div class="alert alert-dismissible alert-danger" ><strong>Exito!</strong>No existen contratos con estos datos!.</div>');
              $('#mensaje').show(60);
              $('#mensaje').delay(1500).hide(600);    
            }              
          }
        },
        error: function (xhr){
          validador_errores(xhr.responseJSON);
        }
      });
    });

    $("#Solicitud").on('click', function(){
      $("#AgregarSolicitudD").modal('show');
    });

    $("#EnviarSolicitud").on('click', function(){
      var formData = new FormData($("#agregarSolicitudF")[0]);    
      $.ajax({
        url: 'addSolicitud',  
        type: 'POST',
        data: formData,          
        contentType: false,
        processData: false,
        dataType: "json",
        beforeSend: function(){
          $("#Esperar").show('slow');
          $("#EnviarSolicitud").hide('slow');
        },
        success: function (xhr) {
          $("#Esperar").hide('slow');
          $("#EnviarSolicitud").show('slow');
          if(xhr.status == 'error'){
            validador_errores2(xhr.errors);
          }else if(xhr.status == 'success'){
            $('#agregarSolicitudF .form-group').removeClass('has-error');
            document.getElementById("agregarSolicitudF").reset(); 
            $('#mensajeSoporte').html('<div class="alert alert-dismissible alert-success" ><strong>Exito!</strong>'+xhr.Mensaje+'</div>');
            $('#mensajeSoporte').show(60);
            $('#mensajeSoporte').delay(1500).hide(600); 
          }
          else if(xhr.status == 'ErrorS'){
            $('#mensajeSoporte').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong>'+xhr.Mensaje+'</div>');
            $('#mensajeSoporte').show(60);
            $('#mensajeSoporte').delay(1500).hide(600); 
          }
        },
        error: function (xhr){
          validador_errores2(xhr.responseJSON);
          $("#Esperar").hide('slow');
          $("#EnviarSolicitud").show('slow');
        }
      });
    });

    var validador_errores2 = function(data){
      $('#agregarSolicitudF .form-group').removeClass('has-error');
      $.each(data, function(i, e){
        $("#"+i).closest('.form-group').addClass('has-error');
      });
    }
});
