var jadataTablePadrao = 'n';

function botaoNovoReload() {
    location.href = window.location.pathname;
}

/**javascript para integração geral no sistema*/
function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    // add a zero in front of numbers<10
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('horaCabecalho').innerHTML = h + ":" + m + ":" + s;
    t = setTimeout('startTime()', 500);
}

function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

//startTime();

function redirecionaLogin() {
    alert("Não pode acessar funcionalidade sem estar logado!");
    location.href = 'Login.php';
}

function reenviaSenha() {
    $.ajax({
        url: "../control/ReenviarSenha.php",
        type: "POST",
        data: {email: document.getElementById("email").value},
        dataType: 'json',
        success: function (data, textStatus, jqXHR) {
            if (data.situacao === true) {
                swal("Senha enviada", data.mensagem, "success");
            } else if (data.situacao === false) {
                swal("Erro", data.mensagem, "error");
            }
        }, error: function (jqXHR, textStatus, errorThrown) {
            swal("Erro ao enviar", "Erro causado por:" + errorThrown, "error");
        }
    });
}

function abrirPopUp(url) {
    TINY.box.show({url: url, width: 430, height: 155, opacity: 20, topsplit: 3});
}

function dataTablePadrao(id) {
    if (jadataTablePadrao == 'n') {
        $("body").append('<link rel="stylesheet" href="./recursos/css/jquery.dataTables.css"/>')
                .append('<link rel="stylesheet" href="./recursos/css/responsive.dataTables.min.css"/>')
                .append('<script type="text/javascript" src="./recursos/js/jquery.dataTables.js"></script>')
                .append('<script type="text/javascript" src="./recursos/js/dataTables.responsive.min.js"></script>');
        jadataTablePadrao = 's';
    }
    $('#' + id).DataTable({
        "language": {
            "lengthMenu": "Mostrando _MENU_ resultados por pág.",
            "zeroRecords": "Nada encontrado - desculpe",
            "info": "Mostrando pág _PAGE_ de _PAGES_",
            "infoEmpty": "Nenhum resultado disponivel",
            "infoFiltered": "(filtrando de _MAX_ total resultados)",
            "search": 'Procurar',
            "paginate": {
                "previous": "Pág. ant.",
                "next": "Próx. pág."
            }
        },
        "responsive": true,
        "autoWidth": false,
        "order": [[0, "desc"]]
    });
}

function ResetFormValues() {
    $(".count-jfilestyle").remove();
    $("#img_preview").prop("src", "../visao/recursos/img/sem_imagem.png");
    $("input[type=email]").val("");
    $("input[type=date]").val("");
    $("input[type=time]").val("");
    $("input[type=file]").val("");
    $("input[type=url]").val("");
    $("textarea").val("");
    $(".texto").val("");
    if ($(".texto").length) {
        tinymce.activeEditor.setContent("");
    }
    $(":text").each(function () {
        $(this).val("");
    });

    $(":radio").each(function () {
        $(this).prop({checked: false})
    });

    $("select").each(function () {
        $(this).val("");
    });
}

function imprimirDireto(url) {
    printPage(url);
}
//ABRIR PÁGINA DE IMPRESSÃO

function closePrint() {
    document.body.removeChild(this.__container__);
}

function setPrint() {
    this.contentWindow.__container__ = this;
    this.contentWindow.onbeforeunload = closePrint;
    this.contentWindow.onafterprint = closePrint;
    this.contentWindow.focus(); // Required for IE
    this.contentWindow.print();
}

function printPage(sURL) {
    var oHiddFrame = document.createElement("iframe");
    oHiddFrame.onload = setPrint;
    oHiddFrame.style.visibility = "hidden";
    oHiddFrame.style.position = "fixed";
    oHiddFrame.style.right = "0";
    oHiddFrame.style.bottom = "0";
    oHiddFrame.src = sURL;
    document.body.appendChild(oHiddFrame);
}



function criaQRCODE() {
    $("#imgQrCode").prop("src", $().qrcode($("#codpatrimonioqr").val(), "250"));
    $("#div_qrcode").append("<div>" + $("#codpatrimonioqr").val() + "</div>");
    $("#div_qrcode").show();
}

function criarQRCODE(url, size) {
    return "http://chart.apis.google.com/chart?cht=qr&chl=" + url + "&chs=" + size + "x" + size;
}

// Função para LER QRCode
function lerQRCode() {
    console.log("Ler QRCode");

    cordova.plugins.barcodeScanner.scan(
            function (result) {
                alert("We got a barcode\n" +
                        "Result: " + result.text + "\n" +
                        "Format: " + result.format + "\n" +
                        "Cancelled: " + result.cancelled);
            },
            function (error) {
                alert("Scanning failed: " + error);
            },
            {
                preferFrontCamera: false, // iOS and Android
                showFlipCameraButton: true, // iOS and Android
                showTorchButton: true, // iOS and Android
                torchOn: true, // Android, launch with the torch switched on (if available)
                prompt: "Coloque um código de barras dentro da área de digitalização", // Android
                resultDisplayDuration: 500, // Android, display scanned text for X ms. 0 suppresses it entirely, default 1500
                formats: "QR_CODE,PDF_417", // default: all but PDF_417 and RSS_EXPANDED
                orientation: "landscape", // Android only (portrait|landscape), default unset so it rotates with the device
                disableAnimations: true, // iOS
                disableSuccessBeep: false // iOS
            }
    );
}

document.addEventListener("deviceready", onDeviceReady, false);

function onDeviceReady() {
    console.log(navigator.camera);
    lerQRCode();
}

$(function () {

//validação de datas
    $(".datainicio").change(function () {
        if ($(this).val() != null && $(this).val() != "") {
            $(".datafim").attr('min', $(this).val());
        }
    });

//função de máscara para link
    $(".url").on('keydown', function (e) {
        e.preventDefault();

        if ($(this).val() != '') {
            if (window.urlDigitada == undefined) {
                var texto = $(this).val();
                window.urlDigitada = texto.replace('http://', '');
            }

        }
        if (190 == e.keyCode) {  //adiciono um ponto
            if (window.urlDigitada != undefined) {
                window.urlDigitada = window.urlDigitada + '.';
                $(this).val('http://' + window.urlDigitada);
            }
        } else if (193 == e.keyCode) { //adiciono uma barra
            if (window.urlDigitada != undefined) {
                window.urlDigitada = window.urlDigitada + '/';
                $(this).val('http://' + window.urlDigitada);
            }
        } else if (e.keyCode == 8) { //backspace
            if (window.urlDigitada != undefined || window.urlDigitada != '') {
                var tamanho = window.urlDigitada.length;
                window.urlDigitada = window.urlDigitada.substr(0, tamanho - 1);

                $(this).val('http://' + window.urlDigitada);
            } else {
                $(this).val('http://');
            }
        } else if ((e.keyCode >= 65 && e.keyCode <= 90) && (isNaN(String.fromCharCode(e.keyCode)))) {
            var letra = String.fromCharCode(e.keyCode).toLowerCase();
            if (window.urlDigitada != undefined) {
                window.urlDigitada = window.urlDigitada + letra;
            } else {
                window.urlDigitada = letra;
            }
            $(this).val('http://' + window.urlDigitada);
        }

    });

    var limiteUpload = 2;//mb
    var tamMaxUpload = 0;

    $.fn.qrcode = function (url, size) {
        return "http://chart.apis.google.com/chart?cht=qr&chl=" + url + "&chs=" + size + "x" + size;
    }

    if ($(".texto").length) {
        $("body").append('<script type="text/javascript" src="./recursos/js/tinymce/tinymce.min.js"></script>')
                .append('<script type="text/javascript" src="./recursos/js/Editor.js"></script>');
    }

    $("input[type='file']").change(function () {
        var tam = $(this)[0].files[0].size;
        if (tamMaxUpload == 0) {
            tamMaxUpload = 1024 * (1024 * limiteUpload);
        }
        if (tam > tamMaxUpload) {
            swal("Atenção", "Por favor verifique arquivo o tamanho máximo para upload é de " + limiteUpload + " Mb", "error");
            $(this).val('');
            $(this).focus();
        }
    });

    var textoPiscante = $('.textoPiscante');

    window.setInterval(function () {
        textoPiscante.css('visibility', 'hidden');

        window.setTimeout(function () {
            textoPiscante.css('visibility', 'visible');
        }, 150);
    }, 1 * 1000);

    $("#input_imagem").change(function (e) {
        var preview = document.getElementById('img_preview');
        var file = document.querySelector('input[type=file]').files[0];
        var reader = new FileReader();
        reader.onloadend = function () {
            preview.src = reader.result;
        };
        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    });
    if (document.getElementById("tabs") !== null) {
        $("#tabs").tabs();
    }
    $("#cep").blur(function () {
        $.ajax({
            url: "../control/BuscaCep.php",
            type: "POST",
            data: {cep: $("#cep").val()},
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {
                $("#tipologradouro").val(data.tipologradouro);
                $("#logradouro").val(data.logradouro);
                $("#cidade").val(data.cidade);
                $("#estado").val(data.uf);
                $("#bairro").val(data.bairro);
            }, error: function (jqXHR, textStatus, errorThrown) {
                swal("Erro ao excluir", "Erro causado por:" + errorThrown, "error");
            }
        });
    });
});



$(window).load(function () {

    if ($(".real").length || $(".porcentagem").length || $(".porcentagemMaisCasas").length) {
        $("body").append('<script type="text/javascript" src="./recursos/js/jquery.maskMoney.min.js"></script>');
    }
    if ($(".cep").length || $(".cpf").length || $(".placa").length || $(".telefone").length || $(".data").length) {
        $("body").append('<script type="text/javascript" src="./recursos/js/jquery.mask.min.js"></script>');
    }

    if ($(".real").length) {
        $(".real").maskMoney({showSymbol: true, symbol: "R$", decimal: ",", thousands: ""});
    }
    if ($(".porcentagem").length) {
        $(".porcentagem").maskMoney({showSymbol: true, symbol: "%", decimal: ",", thousands: ""});
    }
    if ($(".porcentagemMaisCasas").length) {
        $(".porcentagemMaisCasas").maskMoney({showSymbol: true, symbol: "%", decimal: ',', thousands: "", precision: 6});
    }
    if ($(".inteiro").length) {
        $('.inteiro').keypress(function (event) {
            var tecla = (window.event) ? event.keyCode : event.which;
            if ((tecla > 47 && tecla < 58))
                return true;
            else {
                if (tecla !== 8)
                    return false;
                else
                    return true;
            }
        });
    }
    if ($(".data").length) {
        $(".data").datepicker({/**usado para input text*/
            dateFormat: 'dd/mm/yy',
            dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
            dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            nextText: 'Próximo',
            prevText: 'Anterior',
            maxDate: "2099-12-30"
        });
        $(".data").mask("99/99/9999");

    }

    if ($(".cep").length) {
        $(".cep").mask("99.999-999");
    }
    if ($(".cpf").length) {
        $('.cpf').mask("999.999.999-99");
    }
    if ($(".placa").length) {
        $(".placa").mask("aaa-9999");
    }
    if ($(".cnpj").length) {
        $('.cnpj').mask("99.999.999/9999-99");
    }
    if ($(".telefone").length) {
        $(".telefone").mask("(99)9999-9999");
    }
    if ($(".celular").length) {
        $(".celular").mask("(99)99999-9999");
    }

});