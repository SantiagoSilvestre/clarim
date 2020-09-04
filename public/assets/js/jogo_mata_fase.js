$(document).ready(function () {

    var id  = $("#jogo").val();
    $("#form-jogo").css("display", "none");

    $("#jogo").change(function() {
        var id_current  = $("#jogo").val();
        $.ajax({
            type: 'GET',
            url: '/clarim/campeonato/jogo/buscar?id='+id_current,
            error: function error(data) {
                console.log(data);
                //window.location.href = "/adm/campeonatos";
            },
            success: function success(data) {
                console.log(data);
                if(data) {
                    $("#form-jogo").css("display", "block");
                    $("#time1").val(data.id_time1);
                    $("#time1").prop( "disabled", true );
                    $("#time2").val(data.id_time2);
                    $("#time2").prop( "disabled", true );
                } 
            },
            dataType: 'json'
        });
    });

    $("#SendCadJog").on('click', function(){
        var id_current  = $("#jogo").val();
        var gol1 = $("#gol1").val();
        var gol2 = $("#gol2").val();
        var time1 = $("#time1").val();
        var time2 = $("#time2").val();
        var camp = $("#id").val();
        var resultado;
        if(gol1 > gol2) {
            resultado = time1;
        } else if (gol2 > gol1) {
            resultado = time2;
        } else {
            resultado = 0;
        }
        $.ajax({
            type: 'POST',
            url: '/clarim/adm/jogo/cad_mata',
            data : { 'id' : id_current,
                      'resul' : resultado,
                      'id_camp' :camp                 },
            error: function error(data) {
                console.log(data)
               //window.location.href = "/adm/campeonatos";
            },
            success: function success(data) {
               if(data == 1) {
                window.location.href = "/clarim/adm/campeonatos";
               } else if (data == 0) {
                window.location.href = "/clarim/adm/campaonato/jogo?id="+camp;
               }
            },
            dataType: 'json'
        });
    });
   
       
});
