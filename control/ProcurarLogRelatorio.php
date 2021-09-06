<?php

header('Content-type: text/html; charset=utf-8');
session_start();
//validação caso a sessão caia
if (!isset($_SESSION)) {
    die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
}
function __autoload($class_name) {
    if (file_exists("../model/" . $class_name . '.php')) {
        include "../model/" . $class_name . '.php';
    } elseif (file_exists("../visao/" . $class_name . '.php')) {
        include "../visao/" . $class_name . '.php';
    } elseif (file_exists("./" . $class_name . '.php')) {
        include "./" . $class_name . '.php';
    }
}

$conexao = new Conexao();
$log = new Log($conexao);
$res = $log->procurar($_POST);
$qtd = $conexao->qtdResultado($res);

if ($qtd > 0) {
    $html = '';
    $nome = "Rel. de Logs";
    $html .= '<table class="" width="100%" id="table_log">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th>Dt Cadastro</th>';
    $html .= '<th>Nome</th>';
    $html .= '<th>Nível</th>';
    $html .= '<th>O que</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';
    while ($log = $conexao->resultadoArray($res)) {
        
        $html .= '<tr>';
        $html .= '<td>' . date("d/m/Y", strtotime($log["data"])) . ' '. $log["hora"].'</td>';
        $html .= '<td>' . ($log["pessoa"]) . '</td>';
        $html .= '<td>' . ($log["nivel"]) . '</td>';
        $html .= '<td>' . ($log["observacao"]) . '</td>';
    
        $html .= '</tr>';
    
    }
    $html .= '</tbody>';
    $html .= '</table>';

    $_POST["html"] = preg_replace('/\s+/', ' ', str_replace("> <", "><", $html));
    $paisagem = "sim";
    if (isset($_POST["tipo"]) && $_POST["tipo"] == "xls") {
        include "./GeraExcel.php";
    } else {
        include "./GeraPdf.php";
//        echo $html;
    }
} else {
    echo '<script>alert("Sem logs encontrados!");window.close();</script>';
}

function verificaData($data) {
    if (isset($data) && $data != NULL && $data != "") {
        $separa_data = explode('-', $data);
        if ($separa_data[0] <= date("Y")) {
            $data = date("d/m/Y", strtotime($data));
        } else {
            $data = '';
        }
    } else {
        $data = '';
    }
    return $data;
}

function verificaPct($aulas, $assistiu) {
    if ($aulas > 0) {
        $pct = ($assistiu / $aulas) * 100;
    } else {
        $pct = 0.0;
    }
    if ($pct > 100) {
        $pct = 100;
    }
    return $pct;
}

function verificaCertificado($log, $pct) {
    $site = 'http://'.$_SERVER['SERVER_NAME']. '/';
    if ((($log["IND_PRECISA_PROVA"] == 1 && $log["IND_APROVADO"] == 1) || ($log["IND_PRECISA_PROVA"] == 0)) && $pct >= 70) {
        $certificado = '<a href="'.$site.'/GerarPDF/generatepdf/gerador_certificado.php?cod_produto=' . $log["COD_PRODUTO"] . '&cod_cliente=' . $log["COD_CLIENTE"] . '">Gerar certificado em PDF</a>';
    } elseif ($pct >= 70 && $log["IND_PRECISA_PROVA"] == 1 && $log["IND_APROVADO"] == 0) {
        $certificado = 'Não realizou as provas';
    } elseif ($pct < 70) {
        $certificado = 'Não assistiu todas as aulas';
    }
    return $certificado;
}
