/* 
 * @author Thyago Henrique Pacher - thyago.pacher@gmail.com
 */

function abreRelatorioLog(tipo) {
    if(tipo === 1){
        document.frellog.tipo.value = "pdf";
    }else if(tipo === 2){
        document.frellog.tipo.value = "xls";
    }
    document.getElementById("frellog").submit();
}

function procurarLog(acao) {
    $.ajax({
        url: "../control/ProcurarLog.php",
        type: "POST",
        data: $("#frellog").serialize(),
        dataType: 'text',
        success: function (data, textStatus, jqXHR) {
            if (acao == false && data === "") {
                swal("Atenção", "Nada encontrado de logs!", "error");
            }
            document.getElementById("listagemLog").innerHTML = data;
            dataTablePadrao('table_log');
        }, error: function (jqXHR, textStatus, errorThrown) {
            swal("Erro", "Erro causado por:" + errorThrown, "error");
        }
    });
}
