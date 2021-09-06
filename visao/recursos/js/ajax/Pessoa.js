function btNovoPessoa(){
    document.fpessoa.codnivel.value = '';
    document.fpessoa.codpessoa.value = '';
    document.fpessoa.nome.value = '';
    document.fpessoa.email.value = '';
    document.fpessoa.senha.value = '';
    document.fpessoa.imagem.value = '';
    window.history.pushState("", "Gestão de Pessoas", "/visao/Pessoa.php");
}

function reenviarLogin(codpessoa) {
    $.ajax({
        url: "../control/ReenviarLogin.php",
        type: "POST",
        data: {codpessoa: codpessoa},
        dataType: 'json',
        success: function (data, textStatus, jqXHR) {
            if (data.situacao === true) {
                swal("Login enviado", data.mensagem, "success");
                procurarPessoa(true);
            } else if (data.situacao === false) {
                swal("Erro ao enviar", data.mensagem, "error");
            }
        }, error: function (jqXHR, textStatus, errorThrown) {
            swal("Erro ao enviar", "Erro causado por:" + errorThrown, "error");
        }
    });
}

//procurarCodigo(13, 177);

function procurarCodigo(codpessoa, codempresa) {
    $.ajax({
        url: "../control/ProcurarPessoaCodigojson.php",
        type: "POST",
        data: {codpessoa: codpessoa, codempresa: codempresa},
        dataType: 'json',
        success: function (data, textStatus, jqXHR) {
            if (data.nome != undefined && data.nome != "") {
                $.each(data, function(i, item) {
                    if(i == "status"){
                        document.fpessoa.status.value = item;
                    }else if(i == "email"){
                        document.fpessoa.email.value = item;
                    }else if(i == "imagem"){
                        document.fpessoa.img_previewPessoa.src = '../arquivos/'+ item;
                    }else{
                        $("#" + i).val(item);
                    }
                });
                if($("#codpagina").val() == 128){
                    $("#tabs").tabs({active: 2});
                }else{
                    $("#tabs").tabs({active: 0});
                }
            
            } else if (data.situacao === false) {
                swal("Erro", "Erro ao procurar usuario por codigo!", "error");
            }
        }, error: function (jqXHR, textStatus, errorThrown) {
            swal("Erro ao enviar", "Erro causado por:" + errorThrown, "error");
        }
    });
}

function excluirPessoa(codpessoa) {
    if(codpessoa == undefined){
        codpessoa = $("#codpessoa").val();
    }
    swal({
        title: "Confirma exclusão?",
        text: "Você não poderá mais visualizar as informações dessa pessoa!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sim, exclua ele!",
        cancelButtonText: "Não",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
            if (codpessoa !== null && codpessoa !== "") {
                $.ajax({
                    url: "../control/ExcluirPessoa.php",
                    type: "POST",
                    data: {codpessoa: codpessoa},
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        if (data.situacao === true) {
                            swal("Pessoa excluida", data.mensagem, "success");
                            procurarPessoa(true);
                        } else if (data.situacao === false) {
                            swal("Erro ao excluir", data.mensagem, "error");
                        }
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        swal("Erro ao excluir", "Erro causado por:" + errorThrown, "error");
                    }
                });
            } else {
                swal("Campo em branco", "Por favor escolha a pessoa para excluir!", "error");
            }
        }
    });
}

function inativarPessoa(codpessoa) {
    if(codpessoa == undefined){
        codpessoa = $("#codpessoa").val();
    }
    swal({
        title: "Confirma inativação?",
        text: "Essa pessoa perdera o acesso ao sistema!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sim, inative ele!",
        cancelButtonText: "Não",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
            if (codpessoa !== null && codpessoa !== "") {
                $.ajax({
                    url: "../control/MudarStatusPessoa.php",
                    type: "POST",
                    data: {codpessoa: codpessoa, status: 'i'},
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        if (data.situacao === true) {
                            swal("Pessoa inativada", data.mensagem, "success");
                            procurarPessoa(true);
                        } else if (data.situacao === false) {
                            swal("Erro", data.mensagem, "error");
                        }
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        swal("Erro", "Erro causado por:" + errorThrown, "error");
                    }
                });
            } else {
                swal("Campo em branco", "Por favor escolha a pessoa!", "error");
            }
        }
    });
}

function ativarPessoa(codpessoa) {
    if(codpessoa == undefined){
        codpessoa = $("#codpessoa").val();
    }
    swal({
        title: "Confirma ativação?",
        text: "Essa pessoa ganhará o acesso ao sistema!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sim, ative ele!",
        cancelButtonText: "Não",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
            if (codpessoa !== null && codpessoa !== "") {
                $.ajax({
                    url: "../control/MudarStatusPessoa.php",
                    type: "POST",
                    data: {codpessoa: codpessoa, status: 'a'},
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        if (data.situacao === true) {
                            swal("Pessoa ativada", data.mensagem, "success");
                            procurarPessoa(true);
                        } else if (data.situacao === false) {
                            swal("Erro", data.mensagem, "error");
                        }
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        swal("Erro", "Erro causado por:" + errorThrown, "error");
                    }
                });
            } else {
                swal("Campo em branco", "Por favor escolha a pessoa!", "error");
            }
        }
    });
}


function excluirFoto(codpessoa) {
    swal({
        title: "Confirma exclusão?",
        text: "Você não poderá mais visualizar a imagem dessa pessoa!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sim, exclua ele!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
            if (codpessoa !== null && codpessoa !== "") {
                $.ajax({
                    url: "../control/ExcluirImgPessoa.php",
                    type: "POST",
                    data: {codpessoa: codpessoa},
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        if (data.situacao === true) {
                            swal("Imagem Pessoa excluida", data.mensagem, "success");

                            $("#imagemCarregada").html("");
                        } else if (data.situacao === false) {
                            swal("Erro ao excluir", data.mensagem, "error");
                        }
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        swal("Erro ao excluir", "Erro causado por:" + errorThrown, "error");
                    }
                });
            } else {
                swal("Campo em branco", "Por favor escolha a imagem pessoa para excluir!", "error");
            }
        }
    });
}

function abreTiraFoto(codpessoa) {
    var oWin = window.open("TirarFotoPessoa.php?codpessoa=" + codpessoa, "Tirar Foto", "width=1250, height=550");
    if (oWin === null || typeof (oWin) === "undefined") {
        swal("Erro ao visualizar", "O Bloqueador de Pop-up esta ativado, desbloquei-o por favor!", "error");
    } else {
        window.close();
    }
}

function setaEditarPessoa(pessoa) {
    document.getElementById("codpessoa").value = pessoa[0];
    document.getElementById("nome").value = pessoa[1];
    document.getElementById("telefone").value = pessoa[2];
    document.getElementById("email").value = pessoa[3];
    document.getElementById("senha").value = pessoa[4];
    document.getElementById("celular").value = pessoa[5];
    document.getElementById("imagemCarregada").innerHTML = "<img src='../arquivos/" + pessoa[6] + "' alt='Imagem da pessoa' title='Imagem da pessoa'/>";
    $("#btatualizarPessoa").css("display", "");
    $("#btexcluirPessoa").css("display", "");
    $("#btnovoPessoa").css("display", "");
    $("#btinserirPessoa").css("display", "none");
    $("#codnivel option[value='" + pessoa[7] + "']").attr("selected", true);
}

function procurarPessoa(acao) {
    $.ajax({
        url: '../control/ProcurarPessoa.php',
        type: "POST",
        data: $("#fPpessoa").serialize(),
        dataType: 'text',
        success: function (data, textStatus, jqXHR) {
            if (acao === false && data === "") {
                swal("Atenção", "Nada encontrado de pessoas!", "error");
            }
            document.getElementById("listagemPessoa").innerHTML = data;
            if(document.getElementById('ehCliente') != null && document.getElementById('ehCliente').value == 's'){
                dataTablePadrao('table_cliente');
            }else{
                dataTablePadrao('table_pessoa');
            }
        }, error: function (jqXHR, textStatus, errorThrown) {
            swal("Erro", "Erro causado por:" + errorThrown, "error");
        }
    });
}

function abreRelatorioPessoa(tipo) {
    if(tipo == 1 || tipo == 2){
        document.getElementById('fPpessoa').action = "/control/ProcurarPessoaRelatorio.php";
    }
    if(tipo === 1){
        document.getElementById("tipo").value = "pdf";
    }else if(tipo === 2){
        document.getElementById("tipo").value = "xls";
    }
    document.getElementById("fPpessoa").submit();
}

        
$(function () {
    
    var progress = $(".progress");
    var progressbar = $("#progressbar");
    var sronly = $("#sronly");

    $("#fpessoa").submit(function () {
        progress.css("visibility", "visible");
    });

    $('#fpessoa').ajaxForm({
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
                procurarPessoa(true);
                progress.hide();
            } else if (data.situacao === false) {
                swal("Erro", data.mensagem, "error");
            }
        }
    });
});
