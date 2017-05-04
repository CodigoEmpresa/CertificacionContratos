$(function(){
    $("#GenerarReporte").on('click', function(){
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