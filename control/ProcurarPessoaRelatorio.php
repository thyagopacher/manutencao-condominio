<?php
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);
session_start();
//validação caso a sessão caia
if (!isset($_SESSION)) {
    die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
}
function __autoload($class_name) {
    if (file_exists("../model/" . $class_name . '.php')) {
        include "../model/" . $class_name . '.php';
    } elseif (file_exists("../visao/" . $class_name . '.php')) {
        include "../visao/" . $class_name . '.php';
    } elseif (file_exists("./" . $class_name . '.php')) {
        include "./" . $class_name . '.php';
    }
}
$conexao = new Conexao();
$pessoa = new Pessoa($conexao);
$res = $pessoa->procurar($_POST);
$qtd = $conexao->qtdResultado($res);

if ($qtd > 0) {
    $nome = "Rel. Pessoas";
    $html = '';
    $html .= '<table width="100%" id="table_usuario">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th>Data Cad.</th>';
    $html .= '<th>Nome</th>';
    $html .= '<th>E-mail</th>';
    $html .= '<th>Nivel</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';
    while ($usuario = $conexao->resultadoArray($res)) { 
        $html .= '<tr>';
        $html .= '<td>'. date("d/m/Y", strtotime($usuario["dtcadastro"])) .'</td>';
        $html .= '<td>'. $usuario["nome"] .'</td>';
        $html .= '<td>'. $usuario["email"] .'</td>';
        $html .= '<td>'. $usuario["nivel_pessoa"] .'</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody>';
    $html .= '</table>';
    
    $_POST["html"] = preg_replace('/\s+/', ' ', str_replace("> <", "><", $html));
    $paisagem = "sim";
    if (isset($_POST["tipo"]) && $_POST["tipo"] == "xls") {
        include "./GeraExcel.php";
    } else {
        include "./GeraPdf.php";
    }
} else {
    echo '<script>alert("Sem usuários encontrados!");window.close();</script>';
}
?>