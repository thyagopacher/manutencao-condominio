function excluirEquipamento(codequipamento) {
    if (typeof (codequipamento) == "undefined") {//test do parametro opcional
        codequipamento = $("#codequipamento").val();
    }
    swal({
        title: "Confirma exclusão?",
        text: "Você não poderá mais visualizar as informações dessa equipamento!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sim, exclua ele!",
        cancelButtonText: "Não",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
            if (codequipamento !== null && codequipamento !== "") {
                $.ajax({
                    url: "../control/ExcluirEquipamento.php",
                    type: "POST",
                    data: {codequipamento: codequipamento},
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        if (data.situacao === true) {
                            swal("Equipamento excluido", data.mensagem, "success");
                            procurarEquipamento(true);
                        } else if (data.situacao === false) {
                            swal("Erro ao excluir", data.mensagem, "error");
                        }
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        swal("Erro ao excluir", "Erro causado por:" + errorThrown, "error");
                    }
                });
            } else {
                swal("Campo em branco", "Por favor escolha a equipamento para excluir!", "error");
            }
        }
    });
}

function procurarEquipamento(acao) {

        $("#carregando").show();
        $.ajax({
            url: "../control/ProcurarEquipamento.php",
            type: "POST",
            data: $("#fPequipamento").serialize(),
            dataType: 'text',
            success: function (data, textStatus, jqXHR) {
                if (acao == false && data == "") {
                    swal("Atenção", "Nada encontrado de equipamento!", "error");
                }
                $("#listagemEquipamento").css("display", "");
                document.getElementById("listagemEquipamento").innerHTML = data;
                dataTablePadrao('table_equipamento');
            }, error: function (jqXHR, textStatus, errorThrown) {
                swal("Erro ao excluir", "Erro causado por:" + errorThrown, "error");
            }
        });
        $("#carregando").hide();
}

function abreTiraFoto(codigo) {
    var complementaURL = '';
    if (codigo != undefined) {
        complementaURL = '?codequipamento=' + codigo;
    }
    var oWin = window.open("TirarFotoEquipamento.php" + complementaURL, "Tirar Foto", "width=1250, height=550");
    if (oWin === null || typeof (oWin) === "undefined") {
        swal("Erro ao visualizar", "O Bloqueador de Pop-up esta ativado, desbloquei-o por favor!", "error");
    } else {
        window.close();
    }
}

function abreRelatorioEquipamento() {
    document.getElementById("tipo").value = "pdf";
    document.getElementById("fPequipamento").submit();
}

function abreRelatorioEquipamento2() {
    document.getElementById("tipo").value = "xls";
    document.getElementById("fPequipamento").submit();
}


$(function () {

    
    if($("#codpatrimonioqr").val() != ""){
        criaQRCODE();
    }
    
    $("#codpatrimonioqr").change(function(){
        criaQRCODE();
    });

    $("#btAbreFormulario").click(function () {
        $("#fequipamento").css("display", "");
        $(".count-jfilestyle").remove();
        $("#img_preview").prop("src", "./visao/recursos/img/sem_imagem.png");
        $("#listagemEquipamento").css("display", "none");
        $("#local").val("");
        $("#titulo").val("");
        $("#descricao").val("");
    });

    $("#btListaFormulario").click(function () {
        $("#fequipamento").css("display", "none");
        procurarEquipamento(false);
    });

    $("#btSalvarEquipamento").click(function () {
        if ($("#titulo").val() != "" && $("#descricao").val() != "" && $("#local").val() != "") {
            $.blockUI({
                message: '<img width="150" height="150" src="./visao/recursos/img/loading.gif" alt="carregando"/><h3>Aguarde processando...</h3>',
                timeout: 2000
            });
        }
    });
    
    var progress = $(".progress");
    var progressbar = $("#progressbar");
    var sronly = $("#sronly");    

    $("#fequipamento").submit(function () {
        progress.css("visibility", "visible");
    });

    $('#fequipamento').ajaxForm({
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
                setTimeout('location.href = "Equipamento.php"', 3000);
                window.history.pushState("", "Gestão de Equipamento", "/visao/Equipamento.php");
                procurarEquipamento(true);
            } else if (data.situacao === false) {
                swal("Erro", data.mensagem, "error");
            }
        }
    });
});
