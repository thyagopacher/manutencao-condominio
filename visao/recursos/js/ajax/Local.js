function excluirLocal(codlocal) {
    if (typeof (codlocal) == "undefined") {//test do parametro opcional
        codlocal = $("#codlocal").val();
    }
    swal({
        title: "Confirma exclusão?",
        text: "Você não poderá mais visualizar as informações desse local!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sim, exclua ele!",
        cancelButtonText: "Não",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
            if (codlocal !== null && codlocal !== "") {
                $.ajax({
                    url: "../control/ExcluirLocalEquipamento.php",
                    type: "POST",
                    data: {codlocal: codlocal},
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        if (data.situacao === true) {
                            swal("Local excluido", data.mensagem, "success");
                            procurarLocal(true);
                        } else if (data.situacao === false) {
                            swal("Erro ao excluir", data.mensagem, "error");
                        }
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        swal("Erro ao excluir", "Erro causado por:" + errorThrown, "error");
                    }
                });
            } else {
                swal("Campo em branco", "Por favor escolha a local para excluir!", "error");
            }
        }
    });
}

function procurarLocal(acao) {

        $("#carregando").show();
        $.ajax({
            url: "../control/ProcurarLocalEquipamento.php",
            type: "POST",
            data: $("#fPlocal").serialize(),
            dataType: 'text',
            success: function (data, textStatus, jqXHR) {
                if (acao == false && data == "") {
                    swal("Atenção", "Nada encontrado de local!", "error");
                }
                $("#listagemLocal").css("display", "");
                document.getElementById("listagemLocal").innerHTML = data;
                dataTablePadrao('table_local');
            }, error: function (jqXHR, textStatus, errorThrown) {
                swal("Erro ao excluir", "Erro causado por:" + errorThrown, "error");
            }
        });
        $("#carregando").hide();
}

function abreRelatorioLocal(tipo) {
    if(tipo == 1){
        document.getElementById("tipo").value = "pdf";
    }else{
        document.getElementById("tipo").value = "xls";
    }
    document.getElementById("fPlocal").submit();
}


$(function () {

    $("#btAbreFormulario").click(function () {
        $("#flocal").css("display", "");
        $(".count-jfilestyle").remove();
        $("#img_preview").prop("src", "./visao/recursos/img/sem_imagem.png");
        $("#listagemLocal").css("display", "none");
        $("#local").val("");
        $("#titulo").val("");
        $("#descricao").val("");
    });

    $("#btListaFormulario").click(function () {
        $("#fPlocal").css("display", "none");
        procurarLocal(false);
    });

    $("#btSalvarLocal").click(function () {
        if ($("#titulo").val() != "" && $("#descricao").val() != "" && $("#local").val() != "") {
            $.blockUI({
                message: '<img width="150" height="150" src="./visao/recursos/img/loading.gif" alt="carregando"/><h3>Aguarde processando...</h3>',
                timeout: 2000
            });
        }
    });

    $("#flocal").submit(function () {
        $(".progress").css("visibility", "visible");
    });

    var bar = $('.bar');
    var percent = $('.percent');
    var status = $('#status');

    $('#flocal').ajaxForm({
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
                if ($("#codlocal").val() !== null && $("#codlocal").val() !== "") {
                    swal("Alteração", data.mensagem, "success");
                } else {
                    swal("Cadastro", data.mensagem, "success");
                }
                ResetFormValues(); 
                $("#tabs").tabs({active: 1});
                procurarLocal(true);
//                $("#btSalvarLocal").unblockUI();
            } else if (data.situacao === false) {
                swal("Erro", data.mensagem, "error");
            }
        }
    });
});
