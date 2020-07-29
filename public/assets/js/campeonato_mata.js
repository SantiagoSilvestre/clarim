$(document).ready(function () {
    var id = $("#id").val();
    $.ajax({
        type: 'GET',
        url: '/campeonato/ajax?id='+id,
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
});
