$(function(){
    $.datepicker.setDefaults($.datepicker.regional["es"]);
    $('#FechaInicioDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
    $('#FechaFinDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});

    $("#GenerarReporte").on('click', function(){
        $('#VariosD').hide('slow');
        $('#mensaje').hide('slow');
        $('#reporteExpedicionF .form-group').removeClass('has-error');
         var formData = new FormData($("#reporteExpedicionF")[0]);      
        $.ajax({
                url: 'getReporteExpedicion',  
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(data){  
                    if(data.status == 'error'){
                        validador_errores(data.errors);
                        $('#mensaje').html('<div class="alert alert-dismissible alert-danger" ><strong>Error:</strong><br>Error en los campos de fechas.</div>');
                        $('#mensaje').show('slow');

                    }else if(data.status == 'success'){
                        $('#mensaje').hide('slow');                        
                        $('#VariosD').html(data.datos);
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
                        $('#VariosD').show('slow');
                        
                    }else if(data.status == 'No hay datos'){
                        $('#mensaje').html('<div class="alert alert-dismissible alert-success" ><strong>Mensaje:</strong><br>No hay datos de las fechas seleccionadas.</div>');
                        $('#mensaje').show('slow');
                    }
                },
                error: function (xhr){
                }
            });
        });

    var validador_errores = function(data){
    $('#reporteExpedicionF .form-group').removeClass('has-error');
    $.each(data, function(i, e){
      $("#"+i).closest('.form-group').addClass('has-error');
    });
  }
}); 