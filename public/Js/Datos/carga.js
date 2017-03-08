$(function(){
  $("#agregarArchivo").on('click', function(){
    var formData = new FormData($("#CargaMasivaF")[0]);
    $("#Esperar").show('slow');
    $('#mensaje_carga').hide('slow');
    $("#agregarArchivo").hide('slow');
    $("#ArchivoCM").hide('slow');
    $('#CargaMasivaF .form-group').removeClass('has-error');
    $.ajax({
            url: 'CargaArchivo',  
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(data){                  
       
              if(data.status == 'errorCarga'){
                $("#agregarArchivo").show('slow');
                $("#ArchivoCM").show('slow');
                $('#mensaje_carga').html('<div class="alert alert-dismissible alert-danger" ><strong>Registros que presentan error:</strong><br>'+data.mensaje+'</div>');
                $('#mensaje_carga').show('slow');
                $("#NuevaCarga").hide('slow');
              }
              else if(data.status == 'ok'){
                $('#mensaje_carga').html('<div class="alert alert-dismissible alert-success" ><strong>Éxito:</strong><br>La carga de datos se ha realizado de forma exitosa.</div>');
                $('#mensaje_carga').show('slow');
                $("#NuevaCarga").show('slow');
              }else  if(data.status == 'error'){                
                validador_errores(data.errors);
                $("#agregarArchivo").show('slow');
                $("#ArchivoCM").show('slow');
                $("#NuevaCarga").hide('slow');
                $('#mensaje_carga').html('<div class="alert alert-dismissible alert-danger" ><strong>Error:</strong><br>debe seleccionar una archivo con extensión xls para continuar con la carga masiva.</div>');
                $('#mensaje_carga').show(60);
                $('#mensaje_carga').delay(1500).hide(1500);    
              }
            }

        }).done(function(){
          $("#Esperar").hide('slow');          
        });
  });

  var validador_errores = function(data){
    $('#CargaMasivaF .form-group').removeClass('has-error');
    $.each(data, function(i, e){
      $("#"+i).closest('.form-group').addClass('has-error');
    });
  }

  $("#NuevaCarga").on('click', function(){
    $("#ArchivoCM").val('');
    $("#NuevaCarga").hide('slow');
    $("#agregarArchivo").show('slow');
    $("#ArchivoCM").show('slow');
    $('#mensaje_carga').empty();
    $('#mensaje_carga').hide('slow');
  });

});
