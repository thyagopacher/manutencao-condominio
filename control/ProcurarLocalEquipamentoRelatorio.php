<?php
session_start();
//validação caso a sessão caia
if (!isset($_SESSION["codempresa"])) {
    die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
}

include "../model/Conexao.php";
$conexao = new Conexao();

include "../model/LocalEquipamento.php";
$local = new LocalEquipamento($conexao);

$reslocal = $local->procurar($_POST);
$qtdlocal = $conexao->qtdResultado($reslocal);
if ($qtdlocal > 0) {
    $nome = "Local Equipameto";
    $html = "";
    $html .= '<table class="responstable">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th style="text-align: center;">Data</th>';
    $html .= '<th>Nome</th>';
    $html .= '<th>Descrição1</th>';
    $html .= '<th>Descrição2</th>';
    $html .= '<th>Descrição3</th>';
    $html .= '<th>Cadastrado por</th>';
    $html .= '<th>Imagem</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';
    while ($local = $conexao->resultadoArray($reslocal)) {
        $html .= '<tr>';
        $html .= '<td style="width: 100px;text-align: center;">' .$local["dtcadastro2"]. '</td>';
        $html .= '<td style="width: 200px;">' . $local["nome"] . '</td>';
        $html .= '<td>' . $local["descricao1"] . '</td>';
        $html .= '<td>' . $local["descricao2"] . '</td>';
        $html .= '<td>' . $local["descricao3"] . '</td>';
        $html .= '<td>' . $local["funcionario"] . '</td>';
        $html .= '<td>';
        if (isset($local["imagem"]) && $local["imagem"] != NULL && $local["imagem"] != "") {
            $caminhoImagem = LOCAL_ARQUIVO . "{$local["imagem"]}";
            $html .= '<a target="_blank" href="'.$caminhoImagem.'">Abrir</a>';
        }          
        $html .= '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody>';
    $html .= '</table>';
    $_POST["html"] = $html;
    $paisagem = "sim";

    //echo $html;
    
    if (isset($_POST["tipo"]) && $_POST["tipo"] == "xls") {
        include "GeraExcel.php";
    } else {
        include "GeraPdf.php";
    }
} else {
    echo '<script>alert("Sem locais encontrados!");window.close();</script>';
}  