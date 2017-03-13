$(function(){
    $.datepicker.setDefaults($.datepicker.regional["es"]);
    $('#FechaInicioDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
    $('#FechaFinDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});

    $("#GenerarReporte").on('click', function(){
        /*alert($("#FechaInicio").val());
        $.get("getReporteExpedicion/4/1", function (reporte) {
            console.log(reporte);
             
        });*/
         var formData = new FormData($("#reporteExpedicionF")[0]);      
        $.ajax({
                url: 'getReporteExpedicion',  
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(data){  
                    console.log('success');
                    console.log(data);
                },
                error: function (xhr){
                    console.log('error');
                    console.log(data);
                }
            });
        });

    /*$.get("getContratoDate/"+$(this).val(), function (ContratoDate) {
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
            });*/
}); 