$(function(){
  
CargaInicial();
  function CargaInicial(){
  	$.get("getSoportes", function (Soportes) {
	    $("#DatosDiv").empty();
	    $("#DatosDiv").append(Soportes);
	    $('#TablaDatos').DataTable({
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
	  });
  }


	$("body").delegate('button[data-function="solucionSoporte"]','click',function (e) { 
		  $.get("getSoporteOnly/"+$(this).val(), function (SoporteOnly) {
		  	$("#Peticion").empty();
		  	html = '<div class="form-group col-md-2">'+
              			'<label for="inputEmail" class="control-label">Petición</label>'+
                    '</div>'+
                    '<div class="form-group col-md-6">'+SoporteOnly['created_at']+'</div><br></div>'+
                    '<div class="form-group col-md-12">'+
              			SoporteOnly['Descripcion_Solicitud']+
                    '</div>';
		  	$("#Peticion").append(html);
		  	$("#Soporte_Id").val(SoporteOnly['Id']);
		  }).done(function(){
		  	$("#SolucionarD").modal('show');
		  	$("#SolucionarB").show('slow');
		  });
  	});

  	$("#SolucionarB").on('click', function(){
  		var formData = new FormData($("#respondeSoporteF")[0]);    
  		$.ajax({
        url: 'resSoporte',  
        type: 'POST',
        data: formData,          
        contentType: false,
        processData: false,
        dataType: "json",
        beforeSend: function(){
        	$("#Esperar").show('slow');
        	$("#SolucionarB").hide('slow');
        },
        success: function (xhr) {        	
          $("#Esperar").hide('slow');
          if(xhr.status == 'error'){
          	$("#SolucionarB").show('slow');
            validador_errores(xhr.errors);
          }
          else if(xhr.status == 'success'){
          	$('#respondeSoporteF').removeClass('has-error');
          	document.getElementById("respondeSoporteF").reset();
          	$('#MensajeSoporte').html('<div class="alert alert-dismissible alert-success" ><strong>Exito!</strong>'+xhr.Mensaje+'</div>');
            $('#MensajeSoporte').show(60);
            $('#MensajeSoporte').delay(1500).hide(600);
            CargaInicial();
            setTimeout(function(){ 
            	$("#SolucionarD").modal('hide');
            }, 1800);    
          }else if(xhr.status == 'error2'){
          	$("#SolucionarB").show('slow');
          	$('#MensajeSoporte').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong>'+xhr.Mensaje+'</div>');
            $('#MensajeSoporte').show(60);
            $('#MensajeSoporte').delay(1500).hide(600);    
          }
             
        },
        error: function (xhr){
        	$("#Esperar").hide('slow');
        	$("#SolucionarB").show('slow');
          validador_errores(xhr.responseJSON);
        }
      });
  	});

  	var validador_errores = function(data){
      $('#respondeSoporteF .form-group').removeClass('has-error');
      $.each(data, function(i, e){
        $("#"+i).closest('.form-group').addClass('has-error');
      });
    }

    $("body").delegate('button[data-function="verSoporte"]','click',function (e) { 
    	$.get("getSoporteOnly/"+$(this).val(), function (SoporteOnly) {
    		$("#FechaV").val(SoporteOnly['created_at']);
    		if(SoporteOnly['Estado'] == 1){
    			$("#EstadoV").val('Abierto');
    		}else if(SoporteOnly['Estado'] == 2){
    			$("#EstadoV").val('Solucionado');
    		}    		
    		$("#NombreV").val(SoporteOnly['Nombre_Solicitante']);
    		$("#DocumentoV").val(SoporteOnly['Documento_Solicitante']);
    		$("#CorreoV").val(SoporteOnly['Correo_Solicitante']);
    		$("#DescripcionV").val(SoporteOnly['Descripcion_Solicitud']);
    		$("#SolucionV").val(SoporteOnly['Solucion']);
		  }).done(function(){
		  	$("#VerSolucionarD").modal('show');
		  });
    });
});