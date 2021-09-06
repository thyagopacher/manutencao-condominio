function excluirExecutor(codexecutor) {
    if (typeof (codexecutor) == "undefined") {//test do parametro opcional
        codexecutor = $("#codexecutor").val();
    }
    swal({
        title: "Confirma exclusão?",
        text: "Você não poderá mais visualizar as informações dessa executor!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sim, exclua ele!",
        cancelButtonText: "Não",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
            if (codexecutor !== null && codexecutor !== "") {
                $.ajax({
                    url: "../control/ExcluirExecutor.php",
                    type: "POST",
                    data: {codexecutor: codexecutor},
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        if (data.situacao === true) {
                            swal("Executor excluido", data.mensagem, "success");
                            procurarExecutor(true);
                        } else if (data.situacao === false) {
                            swal("Erro ao excluir", data.mensagem, "error");
                        }
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        swal("Erro ao excluir", "Erro causado por:" + errorThrown, "error");
                    }
                });
            } else {
                swal("Campo em branco", "Por favor escolha a executor para excluir!", "error");
            }
        }
    });
}

function procurarExecutor(acao) {

    $("#carregando").show();
    $.ajax({
        url: "../control/ProcurarExecutor.php",
        type: "POST",
        data: $("#fPexecutor").serialize(),
        dataType: 'text',
        success: function (data, textStatus, jqXHR) {
            if (acao == false && data == "") {
                swal("Atenção", "Nada encontrado de executor!", "error");
            }
            $("#listagemExecutor").css("display", "");
            document.getElementById("listagemExecutor").innerHTML = data;
            dataTablePadrao('table_executor');
        }, error: function (jqXHR, textStatus, errorThrown) {
            swal("Erro ao excluir", "Erro causado por:" + errorThrown, "error");
        }
    });
    $("#carregando").hide();
}

function abreTiraFoto(codigo) {
    var complementaURL = '';
    if (codigo != undefined) {
        complementaURL = '?codexecutor=' + codigo;
    }
    var oWin = window.open("TirarFotoExecutor.php" + complementaURL, "Tirar Foto", "width=1250, height=550");
    if (oWin === null || typeof (oWin) === "undefined") {
        swal("Erro ao visualizar", "O Bloqueador de Pop-up esta ativado, desbloquei-o por favor!", "error");
    } else {
        window.close();
    }
}

function abreRelatorioExecutor() {
    document.getElementById("tipoRel").value = "pdf";
    document.getElementById("fPexecutor").submit();
}

function abreRelatorioExecutor2() {
    document.getElementById("tipoRel").value = "xls";
    document.getElementById("fPexecutor").submit();
}

function escolheTipoCampos() {
    if ($("#tipo option:selected").val() == "p" || $("#tipo option:selected").val() == "f") {
        $(".profissional").show();
        $("#nome").attr("required", true);
        $(".empresa").hide();
        $("#razao").attr("required", false);
        $("#cep").attr("required", false);
        $("#tipologradouro").attr("required", false);
        $("#logradouro").attr("required", false);
        $("#numero").attr("required", false);
        $("#bairro").attr("required", false);
        $("#cidade").attr("required", false);
        $("#estado").attr("required", false);
        $("#telefone1").attr("required", false);
        $("#siteurl").attr("required", false);        
        $("#cnpj").attr("required", false);        
    } else {
        $(".profissional").hide();
        $("#nome").attr("required", false);
        $(".empresa").show();
        $("#razao").attr("required", true);
        $("#cep").attr("required", true);
        $("#tipologradouro").attr("required", true);
        $("#logradouro").attr("required", true);
        $("#numero").attr("required", true);
        $("#bairro").attr("required", true);
        $("#cidade").attr("required", true);
        $("#estado").attr("required", true);        
        $("#telefone1").attr("required", true);        
        $("#siteurl").attr("required", true);        
        $("#cnpj").attr("required", true); 
    }
    if ($("#tipo option:selected").val() == "f") {
        $(".funcionario").hide();
    } else {
        $(".funcionario").show();
    }    
}

$(function () {

    if($("#tipo").val() != ""){
        escolheTipoCampos();
    }

    $("#tipo").change(function () {
        escolheTipoCampos();
    });

    $("#btAbreFormulario").click(function () {
        $("#fexecutor").css("display", "");
        $(".count-jfilestyle").remove();
        $("#img_preview").prop("src", "./visao/recursos/img/sem_imagem.png");
        $("#listagemExecutor").css("display", "none");
        $("#local").val("");
        $("#titulo").val("");
        $("#descricao").val("");
    });

    $("#btListaFormulario").click(function () {
        $("#fexecutor").css("display", "none");
        procurarExecutor(false);
    });

    $("#btSalvarExecutor").click(function () {
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
    $("#fexecutor").submit(function () {
        progress.css("visibility", "visible");
    });

    var bar = $('.bar');
    var percent = $('.percent');
    var status = $('#status');

    $('#fexecutor').ajaxForm({
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
                if ($("#codexecutor").val() != null && $("#codexecutor").val() != "") {
                    swal("Alteração", data.mensagem, "success");
                } else {
                    swal("Cadastro", data.mensagem, "success");
                }
                ResetFormValues();
                window.history.pushState("", "Gerencia Executor", "Executor.php");
                procurarExecutor(true);
                progressbar.hide();
            } else if (data.situacao === false) {
                swal("Erro", data.mensagem, "error");
            }
        }
    });
});
