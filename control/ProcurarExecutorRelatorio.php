<?php
session_start();
//validação caso a sessão caia
if (!isset($_SESSION["codempresa"])) {
    die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
}

include "../model/Conexao.php";
$conexao = new Conexao();

include "../model/Executor.php";
$executor = new Executor($conexao);

$resexecutor = $executor->procurar($_POST);
$qtdexecutor = $conexao->qtdResultado($resexecutor);

if ($qtdexecutor > 0) {
    $nome = "Executor";
    $html = "";
    $html .= '<table width="100%">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th>Data</th>';
    $html .= '<th>Nome</th>';
    $html .= '<th>Cadastrado por</th>';
    $html .= '<th>Imagem</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';
    while ($executor = $conexao->resultadoArray($resexecutor)) {
        $html .= '<tr>';
        $html .= '<td style="width: 100px;">' . $executor["dtcadastro2"] . '</td>';
        $html .= '<td>' . $executor["nome"] . '</td>';
        $html .= '<td>' . $executor["funcionario"] . '</td>';
        $html .= '<td>';
        if(isset($executor["imagemexecutor"]) && $executor["imagemexecutor"] != NULL && $executor["imagemexecutor"] != ""){
            $html .= '<a target="_blank" href="https://manutencao.gestccon.com.br/arquivos/' . $executor["imagemexecutor"] . '">Link Img</a>';
        }else{
            $html .= "Não tem";
        }
        $html .= '</td>';
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
    echo '<script>alert("Sem executores encontrado!");window.close();</script>';
}    