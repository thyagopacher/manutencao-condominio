function excluirManutencao(codmanutencao) {
    if (typeof (codmanutencao) == "undefined") {//test do parametro opcional
        codmanutencao = $("#codmanutencao").val();
    }
    swal({
        title: "Confirma exclusão?",
        text: "Você não poderá mais visualizar as informações dessa manutenção!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sim, exclua ele!",
        cancelButtonText: "Não",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
            if (codmanutencao !== null && codmanutencao !== "") {
                $.ajax({
                    url: "../control/ExcluirManutencao.php",
                    type: "POST",
                    data: {codmanutencao: codmanutencao},
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        if (data.situacao === true) {
                            swal("Manutencao excluida", data.mensagem, "success");
                            procurarManutencao(true);
                        } else if (data.situacao === false) {
                            swal("Erro ao excluir", data.mensagem, "error");
                        }
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        swal("Erro ao excluir", "Erro causado por:" + errorThrown, "error");
                    }
                });
            } else {
                swal("Campo em branco", "Por favor escolha a manutencao para excluir!", "error");
            }
        }
    });
}

function finalizarManutencao(codmanutencao) {
    if (typeof (codmanutencao) == "undefined") {//test do parametro opcional
        codmanutencao = $("#codmanutencao").val();
    }
    swal({
        title: "Confirma finalizaçao?",
        text: "Você estara finalizando os serviços dessa manutenção!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sim, finalize ele!",
        cancelButtonText: "Não",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
            if (codmanutencao !== null && codmanutencao !== "") {
                $.ajax({
                    url: "../control/FinalizarManutencao.php",
                    type: "POST",
                    data: {codmanutencao: codmanutencao},
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        if (data.situacao === true) {
                            swal("Manutencao finalizada", data.mensagem, "success");
                            procurarManutencao(true);
                        } else if (data.situacao === false) {
                            swal("Erro ao finalizar", data.mensagem, "error");
                        }
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        swal("Erro ao excluir", "Erro causado por:" + errorThrown, "error");
                    }
                });
            } else {
                swal("Campo em branco", "Por favor escolha a manutencao para finalizar!", "error");
            }
        }
    });
}

function procurarManutencao(acao) {
    if (document.getElementById("listagemManutencao") != null) {
        $("#carregando").show();
        $.ajax({
            url: "../control/ProcurarManutencao.php",
            type: "POST",
            data: $("#fPmanutencao").serialize(),
            dataType: 'text',
            success: function (data, textStatus, jqXHR) {
                if (acao == false && data == "") {
                    swal("Atenção", "Nada encontrado de manutenção!", "error");
                }
                $("#listagemManutencao").css("display", "");
                document.getElementById("listagemManutencao").innerHTML = data;
                jadataTablePadrao = "s";
                dataTablePadrao('table_manutencao');
            }, error: function (jqXHR, textStatus, errorThrown) {
                swal("Erro ao excluir", "Erro causado por:" + errorThrown, "error");
            }
        });
        $("#carregando").hide();
    }
}

function fotoManutencao(acao) {
    var complementaURL = '';
    if (acao != undefined) {
        complementaURL = '?codmanutencao=' + acao;
    }
    var oWin = window.open("FotoOrdemServico.php" + complementaURL, "Tirar Foto", "width=1250, height=550");
    if (oWin === null || typeof (oWin) === "undefined") {
        swal("Erro ao visualizar", "O Bloqueador de Pop-up esta ativado, desbloquei-o por favor!", "error");
    } else {
        window.close();
    }
}

function abreRelatorioManutencao(tipo) {
    if(tipo == 1){
        document.getElementById("tipoRel").value = "pdf";
    }else{
        document.getElementById("tipoRel").value = "xls";
    }
    document.getElementById("fPmanutencao").submit();
}

$(function () {     

    var progress = $(".progress");
    var progressbar = $("#progressbar");
    var sronly = $("#sronly");

    $("#fmanutencao").submit(function () {
        progress.css("visibility", "visible");
    });


    $('#fmanutencao').ajaxForm({
        beforeSend: function () {
            progress.show();
            var percentVal = '0%';
            progressbar.width(percentVal);
            sronly.html(percentVal + ' Completo');   
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            progressbar.width(percentVal);
            sronly.html(percentVal + ' Completo');   
        },
        success: function () {
            var percentVal = '100%';
            progressbar.width(percentVal);
            sronly.html(percentVal + ' Completo');    
        },
        complete: function (xhr) {
            var data = JSON.parse(xhr.responseText);
            if (data.situacao === true) {
                swal("Cadastro", data.mensagem, "success");
                procurarManutencao(true);
                progress.hide();
            } else if (data.situacao === false) {
                swal("Erro", data.mensagem, "error");
            }
        }
    });
});
