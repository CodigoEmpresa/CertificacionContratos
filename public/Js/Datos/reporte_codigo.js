$(function(){
    $("#GenerarReporte").on('click', function(){
        $('#VariosD').hide('slow');
        $('#VariosD').empty();
        var formData = new FormData($("#reporteCodigoF")[0]);    
        $.ajax({
          url: 'getReporteCodigo',  
          type: 'POST',
          data: formData,          
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (xhr) {
            console.log(xhr);
            if(xhr.status == 'error'){
              validador_errores(xhr.errors);
            }
            else if(xhr.status == 'success'){
                $('#reporteCodigoF .form-group').removeClass('has-error');
                $('#VariosD').html(xhr.datosContrato);
                $('#VariosD').show('slow');

            }else if(xhr.status == 'Error'){
                $('#VariosD').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong>'+xhr.Mensaje+'</div>');
                $('#VariosD').show(60);
                $('#VariosD').delay(1500).hide(600);    
            }
          },
          error: function (xhr){
            console.log('err');
            console.log(xhr);
            validador_errores(xhr.responseJSON);
          }
        });
    });

    var validador_errores = function(data){
      $('#reporteCodigoF .form-group').removeClass('has-error');
      $.each(data, function(i, e){
        $("#"+i).closest('.form-group').addClass('has-error');
      });
    }
}); 