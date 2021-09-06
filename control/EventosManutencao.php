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
$eventos = array();
if ($qtdmanutencao > 0) {
    while ($manutencaop = $conexao->resultadoArray($resmanutencao)) {
        if(isset($manutencaop["datafim"]) && $manutencaop["datafim"] != NULL && $manutencaop["datafim"] != "0000-00-00"){
            $dtFim = date('Y-m-d', strtotime('+1 days', strtotime($manutencaop["datafim"])));
            $eventos[] = array('title' => $manutencaop["equipamento"], 'start' => $manutencaop["data"], 'end' => $dtFim, 'allDay' => true);
        }else{
            $eventos[] = array('title' => $manutencaop["equipamento"], 'start' => $manutencaop["data"], 'allDay' => true);
        }
    }
    echo json_encode($eventos);
}