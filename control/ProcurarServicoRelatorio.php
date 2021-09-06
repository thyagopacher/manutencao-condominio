<?php
session_start();
//validação caso a sessão caia
if (!isset($_SESSION["codempresa"])) {
    die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
}

include "../model/Conexao.php";
$conexao = new Conexao();

include "../model/Servico.php";
$servico = new Servico($conexao);

$resservico = $servico->procurar($_POST);
$qtdservico = $conexao->qtdResultado($resservico);

if ($qtdservico > 0) {
    $nome = "Rel. Serviços";
    $html = "";
    $html .= '<table class="responstable">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th style="text-align: center;">Data</th>';
    $html .= '<th>Nome</th>';
    $html .= '<th style="text-align: center;">Status</th>';     
    $html .= '<th>Observação</th>';
    $html .= '<th>Cadastrado por</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';
    while ($servico = $conexao->resultadoArray($resservico)) {
        $html .= '<tr>';
        $html .= '<td style="width: 100px;text-align: center;">' . $servico["dtcadastro2"] . '</td>';
        $html .= '<td style="width: 200px;">' . $servico["nome"] . '</td>';
        $html .= '<td style="width: 80px;text-align: center;">' . $conexao->trocaStatus($servico["status"]) . '</td>';
        $html .= '<td style="width: 250px">' . $servico["observacao"] . '</td>';
        $html .= '<td>' . $servico["funcionario"] . '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody>';
    $html .= '</table>';
    $_POST["html"] = $html;
    $paisagem = "sim";

//    echo $html;
    
    if (isset($_POST["tipo"]) && $_POST["tipo"] == "xls") {
        include "GeraExcel.php";
    } else {
        include "GeraPdf.php";
    }
} else {
    echo '<script>alert("Sem serviços encontrado!");window.close();</script>';
}   
