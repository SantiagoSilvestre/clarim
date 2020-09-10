$(document).ready(function () {

    $( function() {
        $( "#datepicker" ).datepicker();
      } );

    idc = $("#id_cam").val();
    contador = $("#contador").val();
    fase = $("#fase").val();
    contador2 = contador;
    $.ajax({
        type: 'GET',
        url: '/clarim/campeonato/ajaxTime?id_cam='+idc,
        error: function error(data) {
            console.log(data);
        },
        success: function success(data) {
            console.log(data);
            if(data.lenght > 0) {

                while(contador > 0) {
                    data.forEach(element => {
                        $("#time1_"+contador+"").append('<option value="'+element.id+'">'+element.time+'</option>');
                        $("#time2_"+contador+"").append('<option value="'+element.id+'">'+element.time+'</option>'); 
                    });
                    contador --;
               } 
            } else {
                window.location.href = "/clarim/adm/campeonatos";
            }
        },
        dataType: 'json'
    });

    
    $("#SendCadJog").on('click', function(){
        console.log(fase);
        var times = montaArray(idc, fase);
        $.ajax({
            type: 'POST',
            url: '/clarim/adm/proc_cad_mata',
            data : { times },
            error: function error(data) {
                //console.log(data)
               //window.location.href = "/adm/campeonatos";
            },
            success: function success(data) {
               if(data == 0) {
                window.location.href = "/clarim/adm/confrontos?id="+idc;
               } else if(data == 1) {
                window.location.href = "/clarim/adm/campeonatos";
               }
            },
            dataType: 'json'
        });
    });
       
});

function montaArray(idc, fase) {
    var times = [];
    while(contador2 > 0 ) {
        var meuObj = new Object();
        var idt1 = $("#time1_"+contador2+"").val();
        var idt2 = $("#time2_"+contador2+"").val();
        meuObj =  [ idt1, idt2, idc, fase];
        times.push(meuObj);
        contador2 --;
    }

    return times;
}


