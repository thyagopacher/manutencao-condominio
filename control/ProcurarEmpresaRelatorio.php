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
$empresa = new Empresa($conexao);

$res = $empresa->procurar($_POST);
$qtd = $conexao->qtdResultado($res);
if ($qtd > 0) {
    $nome = 'Rel. Empresa';
    $html .= '<table width="100%" id="table_empresa">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th>Data Cad.</th>';
    $html .= '<th>Razão</th>';
    $html .= '<th>E-mail</th>';
    $html .= '<th>Telefone</th>';
    $html .= '<th>Celular</th>';
    $html .= '<th>Status</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';
    while ($empresa = $conexao->resultadoArray($res)) {
        $html .= '<tr>';
        $html .= '<td>' . date("d/m/Y", strtotime($empresa["dtcadastro"])) . '</td>';
        $html .= '<td>' . $empresa["razao"] . '</td>';
        $html .= '<td><a href="mailto: '.$empresa["email"].'">' . $empresa["email"] . '</a></td>';
        $html .= '<td><a href="tel: '.$empresa["telefone"].'">' . $empresa["telefone"] . '</a></td>';
        $html .= '<td><a href="tel: '.$empresa["celular"].'">' . $empresa["celular"] . '</a></td>';
        $html .= '<td>' . $conexao->trocaStatus($empresa["status"]) . '</td>';
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
    }
} else {
    echo '<script>alert("Sem empresas encontradas!");window.close();</script>';
}
