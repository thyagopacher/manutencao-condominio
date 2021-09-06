<?php
session_start();
//validação caso a sessão caia
if (!isset($_SESSION["codempresa"])) {
    die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
}

include "../model/Conexao.php";
$conexao = new Conexao();

if(isset($_POST["dentro"]) && $_POST["dentro"] != NULL && $_POST["dentro"] == "s"){
    $and = " and manutencao.data >= '".date("Y-m-d")."'";
}else{
    $and = " and manutencao.data < '".date("Y-m-d")."'";
}

$qtd_periodo = array();
for($i = 1; $i <= 5; $i++){
    $sql = "select
    count(manutencao.codmanutencao) as qtd 
    from manutencao
    inner join equipamento on equipamento.codequipamento = manutencao.codequipamento and equipamento.codempresa = manutencao.codempresa and equipamento.periodo = '{$i}'
    where 1 = 1 {$and}
    and manutencao.codempresa = {$_SESSION["codempresa"]}";   
//    echo "<pre>$sql</pre>";
    $qtdManutencao = $conexao->comandoArray($sql);
    $qtd_periodo[$i] = $qtdManutencao["qtd"];
}

echo json_encode($qtd_periodo);
