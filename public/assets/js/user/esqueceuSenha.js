$(document).ready(function () {

 $("#btn-cancelar").on('click', function() {
    window.location.href = "/clarim/adm/login";
 });

 $("#btn-confirmar").on('click', function() {
    let email = $("#email").val();
    if(email == '') {
        $("#emailVazio").dialog();
    }else {
        $.ajax({
            type: 'POST',
            url: '/clarim/UserController/ajax/solicitarSenha',
            data: {
                'email' : email
                },
            error: function error(data) {
                console.log(data);
            },
            success: function success(data) {
                if(data == true) {
                    window.location.href = "/clarim/adm/login"; 
                } else if (data == false){
                    $("#emailInvalido").dialog();
                }
                         
            },
            dataType: 'json'
        });
    }
    
 });
       
});
