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

include "../model/Equipamento.php";
$equipamento = new Equipamento($conexao);

$resequipamento = $conexao->comando("select codequipamento from equipamento where codempresa = 29");
$qtdequipamento = $conexao->qtdResultado($resequipamento);
if ($qtdequipamento > 0) {
    while($equipamentop = $conexao->resultadoArray($resequipamento)) {
        for ($i = 0; $i <= 9; $i++) {
            $manutencao = new Manutencao($conexao);
            $manutencao->descricao = "Manutençao {$i} do equipamento";
            $manutencao->codequipamento = $equipamento["codequipamento"];
            $manutencaop->data = date("Y-m-d");
            $manutencaop->datafim = date("Y-m-d");
            $manutencaop->valor = "Valor: {$i}";
            $manutencao->inserir();
        }
    }
}