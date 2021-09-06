<?php
session_start();
//validação caso a sessão caia
if (!isset($_SESSION["codempresa"])) {
    die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
}

include "../model/Conexao.php";
$conexao = new Conexao();

$qtd_gerais_gasto = array();
$qtd_gerais_previsto = array();
for($i = 6; $i >= 0; $i--){
    $mesAno = date('Y-m', strtotime("-$i months"));
    $sql = "select (
        select
        ifnull(sum(valor), 0) as valor1 
        from manutencao 
        where 1 = 1
        and data >= '".$mesAno."-01'
        and data <= '".$mesAno."-30'
        and codempresa = {$_SESSION["codempresa"]}) as valor1,    
        (select ifnull(sum(valor_gasto), 0) as valor2
        from manutencao 
        where 1 = 1
        and data >= '".$mesAno."-01'
        and data <= '".$mesAno."-30'
        and codempresa = {$_SESSION["codempresa"]}) as valor2";   
    $qtdManutencao = $conexao->comandoArray($sql);
    $qtd_gerais_previsto[] = $qtdManutencao["valor1"];
    $qtd_gerais_gasto[] = $qtdManutencao["valor2"];
}

echo json_encode(array('gasto', $qtd_gerais_gasto, 'previsto' => $qtd_gerais_previsto));
