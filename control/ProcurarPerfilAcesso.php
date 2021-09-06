<?php

session_start();
include '../model/Conexao.php';
$conexao = new Conexao();
$and = "";
$andModulo = '';
if (isset($_POST["codnivel"]) && $_POST["codnivel"] != NULL && $_POST["codnivel"] != "") {
    $and .= ' and codnivel = '.$_POST["codnivel"];
}
if (isset($_POST["naomaster"]) && $_POST["naomaster"] != NULL && $_POST["naomaster"] != "" && $_POST["naomaster"] == "true") {
    $andModulo .= ' and codmodulo <> 8';
    $and       .= ' and codnivel <> 1';
}

$sql = 'select codmodulo, nome from modulo where 1 = 1 '.$andModulo.' order by codmodulo';
$resmodulo = $conexao->comando($sql);
$qtdmodulo = $conexao->qtdResultado($resmodulo);
if ($qtdmodulo > 0) {
    echo '<table id="tabela_perfil_acesso" class="display responsive nowrap" cellspacing="0" width="100%">';
    echo '<thead>';
    echo '<tr>';
    echo '<th><i class="fa fa-link" aria-hidden="true"></i> Função</th>';
    echo '<th>Linha</th>';
    echo '<th><i class="fa fa-bars" aria-hidden="true"></i> Menu</th>';
    echo '<th><i class="fa fa-plus" aria-hidden="true"></i> Inserir</th>';
    echo '<th><i class="fa fa-pencil" aria-hidden="true"></i> Alterar</th>';
    echo '<th><i class="fa fa-trash-o" aria-hidden="true"></i> Excluir</th>';
    echo '<th><i class="fa fa-search" aria-hidden="true"></i> Procurar</th>';
    echo '<th><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</th>';
    echo '<th><i class="fa fa-file-excel-o" aria-hidden="true"></i> XLS</th>';
    echo '</tr>';
    echo '</thead>';
    while($modulo = $conexao->resultadoArray($resmodulo)) {
        echo '<tr><td colspan="1" class="tdmd">',  ($modulo["nome"]),'</td>';
        echo '<td colspan="8"><input title="Marcar/desmarcar todos da página" onclick="marcarModulo(', $modulo["codmodulo"], ')" type="checkbox" class="checkPagina" name="marcar_desmarcarModulo', $modulo["codmodulo"], '" id="marcar_desmarcarModulo', $modulo["codmodulo"], '" value="', $modulo["codmodulo"], '"/>Marcar todos do módulo</td>';
        echo '</tr>';
        $sql = 'select codpagina, nome from pagina where codpai = 0 and codmodulo = '.$modulo["codmodulo"].' order by nome';

        $res = $conexao->comando($sql);
        $qtd = $conexao->qtdResultado($res);
        if ($qtd > 0) {            
            while ($pagina = $conexao->resultadoArray($res)) {
                if (isset($_POST["codnivel"]) && $_POST["codnivel"] != NULL && $_POST["codnivel"] != "") {
                    $nivelpagina = $conexao->comandoArray('select mostrar, inserir, atualizar, excluir, procurar, gerapdf, geraexcel from nivelpagina where codpagina = '.$pagina["codpagina"].$and);
                }

                echo '<tr>';
                echo '<td>', ($pagina["nome"]), '</td>';
                echo '<td><input onclick="marcarLinhaPagina(', $pagina["codpagina"], ')" type="checkbox" class="checkPagina" name="marcar_desmarcarpg', $pagina["codpagina"], '" id="marcar_desmarcarpg', $pagina["codpagina"], '" value="', $pagina["codpagina"], '"/>*</td>';
                
                if ($nivelpagina['mostrar'] == 1) {
                    $checkedMenu = "checked";
                } else {
                    $checkedMenu = "";
                }
                if ($nivelpagina['inserir'] == 1) {
                    $checkedInserir = "checked";
                } else {
                    $checkedInserir = "";
                }
                if ($nivelpagina['atualizar'] == 1) {
                    $checkedAtualizar = "checked";
                } else {
                    $checkedAtualizar = "";
                }
                if ($nivelpagina['excluir'] == 1) {
                    $checkedExcluir = "checked";
                } else {
                    $checkedExcluir = "";
                }
                if ($nivelpagina['procurar'] == 1) {
                    $checkedProcurar = "checked";
                } else {
                    $checkedProcurar = "";
                }
                if ($nivelpagina['gerapdf'] == 1) {
                    $checkedPDF = "checked";
                } else {
                    $checkedPDF = "";
                }
                if ($nivelpagina['geraexcel'] == 1) {
                    $checkedXLS = "checked";
                } else {
                    $checkedXLS = "";
                }
                echo '<td><input '.$checkedMenu.' type="checkbox" class="checkPagina menu pagina', $pagina["codpagina"], ' modulo',$modulo["codmodulo"],'" name="pagina', $pagina["codpagina"], '[]" value="h"/>Menu</td>';
                echo '<td><input '.$checkedInserir.' type="checkbox" class="checkPagina inserir pagina', $pagina["codpagina"], ' modulo',$modulo["codmodulo"],'" name="pagina', $pagina["codpagina"], '[]" value="i"/>Inserir</td>';
                echo '<td><input '.$checkedAtualizar.' type="checkbox" class="checkPagina atualizar pagina', $pagina["codpagina"], ' modulo',$modulo["codmodulo"],'" name="pagina', $pagina["codpagina"], '[]" value="a"/>Alterar</td>';
                echo '<td><input '.$checkedExcluir.' type="checkbox" class="checkPagina excluir pagina', $pagina["codpagina"], ' modulo',$modulo["codmodulo"],'" name="pagina', $pagina["codpagina"], '[]" value="e"/>Excluir</td>';
                echo '<td><input '.$checkedProcurar.' type="checkbox" class="checkPagina procurar pagina', $pagina["codpagina"], ' modulo',$modulo["codmodulo"],'" name="pagina', $pagina["codpagina"], '[]" value="p"/>Procurar</td>';
                echo '<td><input '.$checkedPDF.' type="checkbox" class="checkPagina gerapdf pagina', $pagina["codpagina"], ' modulo',$modulo["codmodulo"],'" name="pagina', $pagina["codpagina"], '[]" value="pdf"/>PDF</td>';
                echo '<td><input '.$checkedXLS.' type="checkbox" class="checkPagina geraexcel pagina', $pagina["codpagina"], ' modulo',$modulo["codmodulo"],'" name="pagina', $pagina["codpagina"], '[]" value="xls"/>XLS</td>';
                echo '</tr>';
            }
            
        }
    }
    echo '</table>';
}
