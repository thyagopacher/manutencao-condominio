<?php

session_start();

function __autoload($class_name) {
    if (file_exists('../model/' . $class_name . '.php')) {
        include '../model/' . $class_name . '.php';
    } elseif (file_exists("../visao/" . $class_name . '.php')) {
        include "../visao/" . $class_name . '.php';
    } elseif (file_exists("./" . $class_name . '.php')) {
        include "./" . $class_name . '.php';
    }
}

$sit_retorno = true;
$msg_morador = '';

$conexao = new Conexao();
$pessoa = new Pessoa($conexao);

$variables = (strtolower($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $pessoa->$key = $value;
}

$pessoap = $pessoa->login();

if (isset($pessoap["codpessoa"]) && $pessoap["codpessoa"] != NULL && $pessoap["codpessoa"] != "") {
    $_SESSION['nome'] = $pessoap["nome"];
    $_SESSION['codnivel'] = $pessoap["codnivel"];
    $_SESSION['nivel'] = $pessoap["nivel"];
    $_SESSION['codpessoa'] = $pessoap["codpessoa"];
    $_SESSION['codempresa'] = $pessoap["codempresa"];
    $_SESSION['imagem'] = $pessoap["imagem"];
    $_SESSION["dtcadastro"] = $pessoap["dtcadastro"];

    $acesso = new Acesso($conexao);
    $acesso->codempresa = $pessoap["codempresa"];
    $acesso->codpessoa = $pessoap["codpessoa"];
    $res = $acesso->salvar();

    die(json_encode(array('mensagem' => '', 'situacao' => true)));
} else {
    die(json_encode(array('mensagem' => 'Erro ao efetuar login, e-mail ou senha incorretos!', 'situacao' => false)));
}