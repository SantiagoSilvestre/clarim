$(document).ready(function () {
    var id = $("#id").val();
    $.ajax({
        type: 'GET',
        url: '/clarim/campeonato/ajax?id='+id,
        error: function error(data) {
            console.log(data);
        },
        success: function success(data) {
            console.log(data);
            let qtd = data.qtd_times;
            let input = qtd / 2;
            while(input > 0) {
                $('#chave1').append('');
               
                input --;
            }
            
        },
        dataType: 'json'
    });

    $("#id-fase").on('change', function () {
        var idFase = $("#id-fase").val();
        var idCamp = $("#id").val();
        $.ajax({
            type: 'POST',
            url: '/clarim/campeonato/ajax/buscaFase',
            data: {
                'id_fase' : idFase,
                'id_camp' : idCamp
                },
            error: function error(data) {
                console.log(data);
            },
            success: function success(data) {
                console.log(data[0]);
                $("#html-aqui").html('');
                if(data[0].id_time1) {
                    data.forEach(element => {
                        $("#html-aqui").append('<div class="container col-md-5"><div class="row"><div class="form-group col-md-12"><label>Time:</label><select class="custom-select" readonly ><option value="'+element.id_time1+'" selected> '+element.time1+' </option></select></div></div></div><div class="container col-md-2"><div class="row"><div class="form-group col-md-12">  <label>Vencedor:</label><select class="custom-select" readonly ><option value="'+element.resultado+'" selected>'+element.vencedor+'</option></select></div></div></div><div class="container col-md-5"><div class="row"><div class="form-group col-md-12"><label>Time:</label><select class="custom-select" readonly ><option value="'+element.id_time2+'" selected>'+element.time2+'</option></select></div></div></div>');   
                    });
                } else {
                   var qtd = data[0].qtd_jogos;
                   while(qtd > 0) {
                       $("#html-aqui").append('<div class="container col-md-5"><div class="row"><div class="form-group col-md-12"><label>Time:</label><select class="custom-select" disabled ><option selected>Time x </option></select></div></div></div><div class="container col-md-2"><div class="row"><div class="form-group col-md-12">  <label>Vencedor:</label><select class="custom-select" disabled ><option  selected> Vencedor </option></select></div></div></div><div class="container col-md-5"><div class="row"><div class="form-group col-md-12"><label>Time:</label><select class="custom-select" disabled ><option selected>Time Z</option></select></div></div></div>');
                       qtd --;
                   }
                }               
            },
            dataType: 'json'
        });
    });

});
