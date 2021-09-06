<?php
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

$sql = "select * from pessoa where codempresa = {$_POST["codempresa"]} and codpessoa = {$_POST["codpessoa"]}";
$pessoap = $conexao->comandoArray($sql);
$pessoap["senha"] = base64_decode($pessoap["senha"]);
echo json_encode($pessoap);
