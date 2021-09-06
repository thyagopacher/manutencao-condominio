<?php
session_start();
//validação caso a sessão caia
if (!isset($_SESSION["codempresa"])) {
    die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
}

include "../model/Conexao.php";
$conexao = new Conexao();

$qtd_gerais_corretiva = array();
$qtd_gerais_preventiva = array();
for($i = 6; $i >= 0; $i--){
    $mesAno = date('Y-m', strtotime("-$i months"));
    $sql = "select (
        select
        count(1) as qtd 
        from manutencao 
        where tipo = 'p' and codstatus = 3
        and data >= '".$mesAno."-01'
        and data <= '".$mesAno."-30'
        and codempresa = {$_SESSION["codempresa"]}) as qtd1,    
        (select count(1) as qtd
        from manutencao 
        where tipo = 'c' and codstatus = 3
        and data >= '".$mesAno."-01'
        and data <= '".$mesAno."-30'
        and codempresa = {$_SESSION["codempresa"]}) as qtd2";   
    $qtdManutencao = $conexao->comandoArray($sql);
    $qtd_gerais_corretiva[] = $qtdManutencao["qtd1"];
    $qtd_gerais_preventiva[] = $qtdManutencao["qtd2"];
}

echo json_encode(array('corretivas', $qtd_gerais_corretiva, 'preventivas' => $qtd_gerais_preventiva));
