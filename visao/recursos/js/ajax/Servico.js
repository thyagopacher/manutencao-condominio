function excluirServico(codservico) {
    if (typeof (codservico) == "undefined") {//test do parametro opcional
        codservico = $("#codservico").val();
    }
    swal({
        title: "Confirma exclusão?",
        text: "Você não poderá mais visualizar as informações dessa servico!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sim, exclua ele!",
        cancelButtonText: "Não",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
            if (codservico !== null && codservico !== "") {
                $.ajax({
                    url: "../control/ExcluirServico.php",
                    type: "POST",
                    data: {codservico: codservico},
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        if (data.situacao === true) {
                            swal("Servico excluido", data.mensagem, "success");
                            procurarServico(true);
                        } else if (data.situacao === false) {
                            swal("Erro ao excluir", data.mensagem, "error");
                        }
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        swal("Erro ao excluir", "Erro causado por:" + errorThrown, "error");
                    }
                });
            } else {
                swal("Campo em branco", "Por favor escolha a servico para excluir!", "error");
            }
        }
    });
}

function procurarServico(acao) {

        $("#carregando").show();
        $.ajax({
            url: "../control/ProcurarServico.php",
            type: "POST",
            data: $("#fPservico").serialize(),
            dataType: 'text',
            success: function (data, textStatus, jqXHR) {
                if (acao == false && data == "") {
                    swal("Atenção", "Nada encontrado de servico!", "error");
                }
                $("#listagemServico").css("display", "");
                document.getElementById("listagemServico").innerHTML = data;
                dataTablePadrao('table_servico');
            }, error: function (jqXHR, textStatus, errorThrown) {
                swal("Erro ao excluir", "Erro causado por:" + errorThrown, "error");
            }
        });
        $("#carregando").hide();
}

function abreTiraFoto(codigo) {
    var complementaURL = '';
    if (codigo != undefined) {
        complementaURL = '?codservico=' + codigo;
    }
    var oWin = window.open("TirarFotoServico.php" + complementaURL, "Tirar Foto", "width=1250, height=550");
    if (oWin === null || typeof (oWin) === "undefined") {
        swal("Erro ao visualizar", "O Bloqueador de Pop-up esta ativado, desbloquei-o por favor!", "error");
    } else {
        window.close();
    }
}

function abreRelatorioServico() {
    document.getElementById("tipo").value = "pdf";
    document.getElementById("fPservico").submit();
}

function abreRelatorioServico2() {
    document.getElementById("tipo").value = "xls";
    document.getElementById("fPservico").submit();
}

$(function () {

    $("#btAbreFormulario").click(function () {
        $("#fservico").css("display", "");
        $(".count-jfilestyle").remove();
        $("#img_preview").prop("src", "./visao/recursos/img/sem_imagem.png");
        $("#listagemServico").css("display", "none");
        $("#local").val("");
        $("#titulo").val("");
        $("#descricao").val("");
    });

    $("#btListaFormulario").click(function () {
        $("#fservico").css("display", "none");
        procurarServico(false);
    });

    $("#btSalvarServico").click(function () {
        if ($("#titulo").val() != "" && $("#descricao").val() != "" && $("#local").val() != "") {
            $.blockUI({
                message: '<img width="150" height="150" src="./visao/recursos/img/loading.gif" alt="carregando"/><h3>Aguarde processando...</h3>',
                timeout: 2000
            });
        }
    });

    $("#fservico").submit(function () {
        $(".progress").css("visibility", "visible");
    });

    var bar = $('.bar');
    var percent = $('.percent');
    var status = $('#status');

    $('#fservico').ajaxForm({
        beforeSend: function () {
            status.empty();
            var percentVal = '0%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal);
            percent.html(percentVal);
        },
        success: function () {
            var percentVal = '100%';
            bar.width(percentVal);
            percent.html(percentVal);
        },
        complete: function (xhr) {
            var data = JSON.parse(xhr.responseText);
            if (data.situacao === true) {
                if ($("#codservico").val() != null && $("#codservico").val() != "") {
                    swal("Alteração", data.mensagem, "success");
                } else {
                    swal("Cadastro", data.mensagem, "success");
                }
                ResetFormValues();
                procurarServico(true);
            } else if (data.situacao === false) {
                swal("Erro", data.mensagem, "error");
            }
        }
    });
});
