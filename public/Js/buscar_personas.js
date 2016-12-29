var html;

$(function(e){   
    
    var $personas_actuales = $('#personas').html();    
    
    function reset(e){        
        $('input[name="buscador"]').val('');

        if($(this).data('buscador', 'buscar-rud')){
          Reset_campos(e);
        }
        
        $('#buscar span').removeClass('glyphicon-refresh glyphicon-refresh-animate').addClass('glyphicon-search');
        $('#buscar span').empty();
        
        
        document.getElementById("buscar").disabled = false;
        document.getElementById("buscador").disabled = false;
    };    
    

      
    $('#buscar').on('click', function(e){
        $("#mensajeIncorrectoB").empty();
        $("#mensaje-incorrectoB").fadeOut();
        $("#buscador").css({ 'border-color': '#CCCCCC' });    
        $("#buscar").css({ 'border-color': '#CCCCCC' });    
        var key = $('input[name="buscador"]').val();
        if(!key && $(this).data('role') == 'buscar'){
            $("#buscador").css({ 'border-color': '#B94A48' });
            $("#buscar").css({ 'border-color': '#B94A48' });
            var texto = $("#mensajeIncorrectoB").html();

            $("#mensajeIncorrectoB").html(texto + '<br>' + 'Debe ingresar un parámetro para realizar la búsqueda.');
            $("#mensaje-incorrectoB").fadeIn();
            $('#mensaje-incorrectoB').focus();            
            return false;
        }        
        var role = $(this).data('role');               
        
        switch(role){
            case 'buscar':                
                $('#buscar span').removeClass('glyphicon-search').addClass('glyphicon-refresh glyphicon-refresh-animate');
                document.getElementById("buscar").disabled = true;
                document.getElementById("buscador").disabled = true;
                $(this).data('role', 'reset');

                if($(this).data('buscador', 'buscar-rud')){
                  Buscar(e);
              }
            break;
            case 'reset':                 
                $('#buscar span').removeClass('glyphicon-remove').addClass('glyphicon-refresh glyphicon-refresh-animate');
                document.getElementById("buscar").disabled = true;
                document.getElementById("buscador").disabled = true;
                $(this).data('role', 'buscar');
                reset(e);
            break;
        }
    }); 


    $("#seccion_uno_ver").on('click', function(e){
        var role = $(this).data('role');               
        if(role == 'ver'){
            $("#seccion_uno").show("slow");
            $(this).data('role', 'ocultar');
            $('#seccion_uno_ver').removeClass('glyphicon-resize-full').addClass('glyphicon-resize-small');
        }else if(role == 'ocultar'){
            $("#seccion_uno").hide("slow");
            $(this).data('role', 'ver');
            $('#seccion_uno_ver').removeClass('glyphicon-resize-small').addClass('glyphicon-resize-full');
        }
    }); 

    $("#seccion_dos_ver").on('click', function(e){
        var role = $(this).data('role');               
        if(role == 'ver'){
            $("#seccion_dos").show("slow");
            $(this).data('role', 'ocultar');
            $('#seccion_dos_ver').removeClass('glyphicon-resize-full').addClass('glyphicon-resize-small');
        }else if(role == 'ocultar'){
            $("#seccion_dos").hide("slow");
            $(this).data('role', 'ver');
            $('#seccion_dos_ver').removeClass('glyphicon-resize-small').addClass('glyphicon-resize-full');
        }               
    });

    $("#seccion_tres_ver").on('click', function(e){
        var role = $(this).data('role');               
        if(role == 'ver'){
            $("#seccion_tres").show("slow");
            $(this).data('role', 'ocultar');
            $('#seccion_tres_ver').removeClass('glyphicon-resize-full').addClass('glyphicon-resize-small');
        }else if(role == 'ocultar'){
            $("#seccion_tres").hide("slow");
            $(this).data('role', 'ver');
            $('#seccion_tres_ver').removeClass('glyphicon-resize-small').addClass('glyphicon-resize-full');
        }               
    });

    $("#seccion_cuatro_ver").on('click', function(e){
        var role = $(this).data('role');               
        if(role == 'ver'){
            $("#seccion_cuatro").show("slow");
            $(this).data('role', 'ocultar');
            $('#seccion_cuatro_ver').removeClass('glyphicon-resize-full').addClass('glyphicon-resize-small');
        }else if(role == 'ocultar'){
            $("#seccion_cuatro").hide("slow");
            $(this).data('role', 'ver');
            $('#seccion_cuatro_ver').removeClass('glyphicon-resize-small').addClass('glyphicon-resize-full');
        }               
    });

    $("#seccion_cinco_ver").on('click', function(e){
        var role = $(this).data('role');               
        if(role == 'ver'){
            $("#seccion_cinco").show("slow");
            $(this).data('role', 'ocultar');
            $('#seccion_cinco_ver').removeClass('glyphicon-resize-full').addClass('glyphicon-resize-small');
        }else if(role == 'ocultar'){
            $("#seccion_cinco").hide("slow");
            $(this).data('role', 'ver');
            $('#seccion_cinco_ver').removeClass('glyphicon-resize-small').addClass('glyphicon-resize-full');
        }               
    });

    $("#seccion_seis_ver").on('click', function(e){
        var role = $(this).data('role');               
        if(role == 'ver'){
            $("#seccion_seis").show("slow");
            $(this).data('role', 'ocultar');
            $('#seccion_seis_ver').removeClass('glyphicon-resize-full').addClass('glyphicon-resize-small');
        }else if(role == 'ocultar'){
            $("#seccion_seis").hide("slow");
            $(this).data('role', 'ver');
            $('#seccion_seis_ver').removeClass('glyphicon-resize-small').addClass('glyphicon-resize-full');
        }               
    });

    $("#seccion_siete_ver").on('click', function(e){
        var role = $(this).data('role');               
        if(role == 'ver'){
            $("#seccion_siete").show("slow");
            $(this).data('role', 'ocultar');
            $('#seccion_siete_ver').removeClass('glyphicon-resize-full').addClass('glyphicon-resize-small');
        }else if(role == 'ocultar'){
            $("#seccion_siete").hide("slow");
            $(this).data('role', 'ver');
            $('#seccion_siete_ver').removeClass('glyphicon-resize-small').addClass('glyphicon-resize-full');
        }               
    });

    $("#seccion_ocho_ver").on('click', function(e){
        var role = $(this).data('role');               
        if(role == 'ver'){
            $("#seccion_ocho").show("slow");
            $(this).data('role', 'ocultar');
            $('#seccion_ocho_ver').removeClass('glyphicon-resize-full').addClass('glyphicon-resize-small');
        }else if(role == 'ocultar'){
            $("#seccion_ocho").hide("slow");
            $(this).data('role', 'ver');
            $('#seccion_ocho_ver').removeClass('glyphicon-resize-small').addClass('glyphicon-resize-full');
        }               
    });

    $("#seccion_nueve_ver").on('click', function(e){
        var role = $(this).data('role');               
        if(role == 'ver'){
            $("#seccion_nueve").show("slow");
            $(this).data('role', 'ocultar');
            $('#seccion_nueve_ver').removeClass('glyphicon-resize-full').addClass('glyphicon-resize-small');
        }else if(role == 'ocultar'){
            $("#seccion_nueve").hide("slow");
            $(this).data('role', 'ver');
            $('#seccion_nueve_ver').removeClass('glyphicon-resize-small').addClass('glyphicon-resize-full');
        }               
    });

    $("#seccion_diez_ver").on('click', function(e){
        var role = $(this).data('role');               
        if(role == 'ver'){
            $("#seccion_diez").show("slow");
            $(this).data('role', 'ocultar');
            $('#seccion_diez_ver').removeClass('glyphicon-resize-full').addClass('glyphicon-resize-small');
        }else if(role == 'ocultar'){
            $("#seccion_diez").hide("slow");
            $(this).data('role', 'ver');
            $('#seccion_diez_ver').removeClass('glyphicon-resize-small').addClass('glyphicon-resize-full');
        }               
    });

    $("#seccion_once_ver").on('click', function(e){
        var role = $(this).data('role');               
        if(role == 'ver'){
            $("#seccion_once").show("slow");
            $(this).data('role', 'ocultar');
            $('#seccion_once_ver').removeClass('glyphicon-resize-full').addClass('glyphicon-resize-small');
        }else if(role == 'ocultar'){
            $("#seccion_once").hide("slow");
            $(this).data('role', 'ver');
            $('#seccion_once_ver').removeClass('glyphicon-resize-small').addClass('glyphicon-resize-full');
        }               
    });

    $("#seccion_doce_ver").on('click', function(e){
        var role = $(this).data('role');               
        if(role == 'ver'){
            $("#seccion_doce").show("slow");
            $(this).data('role', 'ocultar');
            $('#seccion_doce_ver').removeClass('glyphicon-resize-full').addClass('glyphicon-resize-small');
        }else if(role == 'ocultar'){
            $("#seccion_doce").hide("slow");
            $(this).data('role', 'ver');
            $('#seccion_doce_ver').removeClass('glyphicon-resize-small').addClass('glyphicon-resize-full');
        }               
    });

    $("#seccion_trece_ver").on('click', function(e){
        var role = $(this).data('role');               
        if(role == 'ver'){
            $("#seccion_trece").show("slow");
            $(this).data('role', 'ocultar');
            $('#seccion_trece_ver').removeClass('glyphicon-resize-full').addClass('glyphicon-resize-small');
        }else if(role == 'ocultar'){
            $("#seccion_trece").hide("slow");
            $(this).data('role', 'ver');
            $('#seccion_trece_ver').removeClass('glyphicon-resize-small').addClass('glyphicon-resize-full');
        }               
    });

});
function ValidaCampo(e){
    tecla = (document.all) ? e.keyCode : e.which;
     if (tecla==8) return true;
     patron =/[A-Za-z0-9\s]/;
     te = String.fromCharCode(tecla);
     return patron.test(te);
 }