$(function(){
    var Adicion = new Array();

	$.datepicker.setDefaults($.datepicker.regional["es"]);
	$('#FechaFirmaDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
    $('#FechaInicioDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
	$('#FechaFinDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
    $('#FechaFinDateAnticipadoDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
    $('#FechaFinCtoProrrogaDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
    $('#FechaInicioSuspencionDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
    $('#FechaFinSuspencionDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
    $('#FechaReinicioSuspencionDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
    $('#FechaCesionDate').datepicker({format: 'yyyy-mm-dd', autoclose: true,});
    

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

    $("#Agregar_Contrato").on('click', function(){
        $("#AgregarContratoD").modal('show');
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
                //Adicion.push({ "Valor_Adicion": $("input[name=Valor_Adicion]").val()});
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

    /* $("#Add_Riesgo").on('click', function(){
    $("input[name=Factor]").css({ 'border-color': '#CCCCCC' });
    $("input[name=Objetivo]").css({ 'border-color': '#CCCCCC' });
    $("input[name=Intervencion]").css({ 'border-color': '#CCCCCC' });
    $("input[name=Fecha_Inicio]").css({ 'border-color': '#CCCCCC' });
    $("input[name=Fecha_Fin]").css({ 'border-color': '#CCCCCC' });
    $("input[name=Responsable]").css({ 'border-color': '#CCCCCC' });
    $("input[name=Autorizada]").css({ 'border-color': '#CCCCCC' });
    $("input[name=Seguimiento]").css({ 'border-color': '#CCCCCC' });
    $("textarea[name=Observacion]").css({ 'border-color': '#CCCCCC' });

    Factor = $("input[name=Factor]").val();
    Objetivo = $("input[name=Objetivo]").val();
    Intervencion = $("input[name=Intervencion]").val();
    Fecha_Inicio = $("input[name=Fecha_Inicio]").val();
    Fecha_Fin = $("input[name=Fecha_Fin]").val();
    Responsable = $("input[name=Responsable]").val();
    Autorizada = $("input[name=Autorizada]").val();
    Seguimiento = $("input[name=Seguimiento]").val();
    Observacion = $("textarea[name=Observacion]").val();

    if(Factor == '' || Objetivo == '' || Intervencion == '' || Fecha_Inicio == '' || Fecha_Fin == '' || Responsable == '' || Autorizada == '' || Seguimiento == '' || Observacion == ''){
      if(Factor == ''){ $("#Factor").css({ 'border-color': '#B94A48' });}
      if(Objetivo == ''){ $("#Objetivo").css({ 'border-color': '#B94A48' });}
      if(Intervencion == ''){ $("#Intervencion").css({ 'border-color': '#B94A48' });}
      if(Fecha_Inicio == ''){ $("#Fecha_Inicio").css({ 'border-color': '#B94A48' });}
      if(Fecha_Fin == ''){ $("#Fecha_Fin").css({ 'border-color': '#B94A48' });}
      if(Responsable == ''){ $("#Responsable").css({ 'border-color': '#B94A48' });}
      if(Autorizada == ''){ $("#Autorizada").css({ 'border-color': '#B94A48' });}
      if(Seguimiento == ''){ $("#Seguimiento").css({ 'border-color': '#B94A48' });}
      if(Observacion == ''){ $("textarea[name=Observacion]").css({ 'border-color': '#B94A48' });}
      return false;
    }
    riesgo.push({ "Factor": Factor, "Objetivo": Objetivo, "Intervencion": Intervencion, "Fecha_Inicio": Fecha_Inicio, 
                 "Fecha_Fin": Fecha_Fin, "Responsable": Responsable,  "Autorizada": Autorizada,  "Seguimiento": Seguimiento, "Observacion": Observacion});

    $('#alert_riesgo').html('<div class="alert alert-dismissible alert-success" ><strong>Exito!</strong>Riesgo agregado con éxito!</div>');
    $('#mensaje_riesgo').show(60);
    $('#mensaje_riesgo').delay(1000).hide(400);     
    $("input[name=Factor]").val('');
    $("input[name=Objetivo]").val('');
    $("input[name=Intervencion]").val('');
    $("input[name=Fecha_Inicio]").val('');
    $("input[name=Fecha_Fin]").val('');
    $("input[name=Responsable]").val('');
    $("input[name=Autorizada]").val('');
    $("input[name=Seguimiento]").val('');
    $("textarea[name=Observacion]").val('');

    $("#RiesgoT").empty();
    tabla = '<table class="table table-bordered" style="background-color:#E8F8FC; border-color:#CEECF5;">'+
                '<th>Factor de riesgo <br>psicosocial</th>'+
                '<th>Objetivo</th>'+
                '<th>Intervención</th>'+
                '<th>Fecha <br>inicio</th>'+
                '<th>Fecha<br>terminación</th>'+
                '<th>Responsable <br>intervención</th>'+
                '<th>Autorizada por</th>'+
                '<th>Seguimiento</th>'+
                '<th>Observaciones</th>';

    $.each(riesgo, function(i, e){      
      tabla += '<tr>'+
                  '<td>'+e.Factor+'</td>'+
                  '<td>'+e.Objetivo+'</td>'+                  
                  '<td>'+e.Intervencion+'</td>'+
                  '<td>'+e.Fecha_Inicio+'</td>'+
                  '<td>'+e.Fecha_Fin+'</td>'+
                  '<td>'+e.Responsable+'</td>'+                  
                  '<td>'+e.Autorizada+'</td>'+
                  '<td>'+e.Seguimiento+'</td>'+
                  '<td>'+e.Observacion+'</td>'+
                '</tr>';                

    });
    tabla += '</table>';
    $("#RiesgoT").append(tabla);
  });*/
    
});