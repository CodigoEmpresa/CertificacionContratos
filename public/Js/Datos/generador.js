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
            window.open(
              'descargarContrato/'+xhr.Id,
              '_blank'
            );  
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
      $.ajax({
        url: 'getContratoUnico',  
        type: 'POST',
        data: {Id: $(this).val()},          
        dataType: "json",
        success: function (xhr) {
          if(xhr.status == 'error'){
            validador_errores(xhr.errors);
          }
          else if(xhr.status == 'success'){
            $('#generarPdf .form-group').removeClass('has-error');
            if(xhr.Contrato == 'Unico'){
              window.open(
                'descargarContrato/'+xhr.Id,
                '_blank'
              );  
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
});