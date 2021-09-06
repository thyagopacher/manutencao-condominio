<?php
session_start();
//validação caso a sessão caia
if (!isset($_SESSION["codempresa"])) {
    die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
}

include "../model/Conexao.php";
$conexao = new Conexao();

include "../model/Equipamento.php";
$equipamento = new Equipamento($conexao);

$resequipamento = $equipamento->procurar($_POST);
$qtdequipamento = $conexao->qtdResultado($resequipamento);

if ($qtdequipamento > 0) {
    $nome = "Equipamentos";
    $html = "";
    $html .= '<table class="responstable">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th style="text-align: center;">Data</th>';
    $html .= '<th>Nome</th>';
    $html .= '<th style="text-align: center;">Status</th>';
    $html .= '<th>Patrimonio</th>';    
    $html .= '<th style="text-align: center;">QRCode</th>';  
    $html .= '<th>Localização</th>';
    $html .= '<th>Imagem</th>';
    if (isset($_POST["tipo"]) && $_POST["tipo"] == "xls") {
        $html .= '<th>Período</th>';   
        $html .= '<th>Descrição</th>';
        $html .= '<th>Cadastrado por</th>';
    }
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';
    while ($equipamento = $conexao->resultadoArray($resequipamento)) {
        $html .= '<tr>';
        $html .= '<td style="width: 100px;text-align: center;">' . $equipamento["dtcadastro2"] . '</td>';
        $html .= '<td style="width: 200px;">' . $equipamento["nome"] . '</td>';
        $html .= '<td style="width: 80px;text-align: center;">' . $conexao->trocaStatus($equipamento["status"]) . '</td>';
        $html .= '<td style="width: 150px;">' . $equipamento["codpatrimonio"] . '</td>';
        $html .= '<td style="width: 100px;text-align: center;">' . $equipamento["qrcode"] . '</td>';   
        $html .= '<td style="width: 250px">' . $equipamento["local"] . '</td>';   
        $html .= '<td>';
        if (isset($equipamento["imagem"]) && $equipamento["imagem"] != NULL && $equipamento["imagem"] != "") {
            $caminhoImagem = LOCAL_ARQUIVO . "{$equipamento["imagem"]}?123456";
            $html .= '<a target="_blank" href="'.$caminhoImagem.'">Abrir</a>';
        }      
        $html .= '</td>';        
        if (isset($_POST["tipo"]) && $_POST["tipo"] == "xls") {
            $html .= '<td>' . $conexao->trocaPeriodo($equipamento["periodo"]) . '</td>';
            $html .= '<td>' . $equipamento["descricao"] . '</td>';
            $html .= '<td>' . $equipamento["funcionario"] . '</td>';
        }
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
    echo '<script>alert("Sem equipamentos encontrado!");window.close();</script>';
}   
