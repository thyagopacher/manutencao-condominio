function login() {
    if ($("#email").val() != null && $("#email").val() != ""
            && $("#senha").val() != null && $("#senha").val() != "") {
        $.ajax({
            url: "../control/Login.php",
            type: "POST",
            data: {email: $("#email").val(), senha: $("#senha").val()},
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {
                if (data.situacao == true) {
                    location.href = "/home";
                } else if (data.situacao === false) {
                    swal("Erro", data.mensagem, "error");
                }
            }, error: function (jqXHR, textStatus, errorThrown) {
                swal("Erro ao cadastrar", "Erro causado por:" + errorThrown, "error");
            }
        });
    } else if ($("#email").val() == null || $("#email").val() == "") {
        swal("Atenção", "E-mail é obrigatório!", "info");
    } else if ($("#senha").val() == null || $("#senha").val() == "") {
        swal("Atenção", "Senha é obrigatório!", "info");
    }
}

function esqueceuSenha() {
    if ($("#email").val() != null && $("#email").val() != "") {
        $.ajax({
            url: "../control/EsqueceuSenha.php",
            type: "POST",
            data: {email: $("#email").val()},
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {
                if (data.situacao === true) {
                    swal("Atenção", data.mensagem, "success");
                } else if (data.situacao === false) {
                    swal("Erro", data.mensagem, "error");
                }
            }, error: function (jqXHR, textStatus, errorThrown) {
                swal("Erro", "Erro causado por:" + errorThrown, "error");
            }
        });
    } else {
        swal("Atenção", "E-mail é obrigatório!", "info");
    }
}

$(function () {
    $("#btlogin").click(function () {
        login();
    });
    
    $("#cadastro").click(function () {
        cadastrarUsuario();
    });
});