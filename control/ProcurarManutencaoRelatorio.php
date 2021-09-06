<?php

session_start();
//validação caso a sessão caia
if (!isset($_SESSION["codempresa"])) {
    die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
}

include "../model/Conexao.php";
$conexao = new Conexao();

include "../model/Manutencao.php";
$manutencao = new Manutencao($conexao);



$resmanutencao = $manutencao->procurar($_POST);
$qtdmanutencao = $conexao->qtdResultado($resmanutencao);
if ($qtdmanutencao > 0) {
    $nome = "Manutenção";
    $html = "";
    $html .= '<table width="100%">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th>Registrado em</th>';
    $html .= '<th>Por</th>';    
    $html .= '<th>Equipamento</th>';
    $html .= '<th>Data</th>';
    $html .= '<th>Tipo</th>';
    $html .= '<th>Valor</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';
    while ($manutencaop = $conexao->resultadoArray($resmanutencao)) {
        $html .= '<tr>';
        $html .= '<td style="width: 100px;">' . $manutencaop["dtcadastro2"] . '</td>';
        $html .= '<td>' . $manutencaop["funcionario"] . '</td>';        
        $html .= '<td>' . $manutencaop["equipamento"] . '</td>';        
        $html .= '<td>' . date("d/m/Y", strtotime($manutencaop["data"])) . '</td>';
        $html .= '<td>' . $manutencao->trocaTipo($manutencaop["tipo"]) . '</td>';
        $html .= '<td>' . number_format($manutencaop["valor"], 2, ',', '.') . '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody>';
    $html .= '</table>';
    $_POST["html"] = $html;
    $paisagem = "sim";


    if (isset($_POST["tipoRel"]) && $_POST["tipoRel"] == "xls") {
        include "GeraExcel.php";
    } else {
        include "GeraPdf.php";
    }
} else {
    echo '<script>alert("Sem manutenções encontradas!");window.close();</script>';
}    