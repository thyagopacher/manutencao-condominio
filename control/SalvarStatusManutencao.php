<?php

session_start();
date_default_timezone_set('America/Sao_Paulo');

function __autoload($class_name) {
    if (file_exists('../model/' . $class_name . '.php')) {
        include '../model/' . $class_name . '.php';
    } elseif (file_exists("../visao/" . $class_name . '.php')) {
        include "../visao/" . $class_name . '.php';
    } elseif (file_exists("./" . $class_name . '.php')) {
        include "./" . $class_name . '.php';
    }
}

$conexao = new Conexao();
$status = new StatusManutencao($conexao);

$msg_retorno = '';
$sit_retorno = true;

$variables = (strtolower($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $status->$key = $value;
}

if (!isset($status->nome) || $status->nome == NULL || $status->nome == "") {
    die(json_encode(array('mensagem' => 'Por favor insira nome do status!', 'situacao' => false)));
}

if (isset($status->codstatus) && $status->codstatus != NULL && $status->codstatus != "") {
    $resInserirStatusManutencao = $status->atualizar();
} else {
    $status->codfuncionario = $_SESSION["codpessoa"];

    if (isset($statusp["codstatus"]) && $statusp["codstatus"] != NULL && $statusp["codstatus"] != "") {
        die(json_encode(array('mensagem' => 'Status manutenção ja cadastrado, por favor verifique!', 'situacao' => false)));
    }
    $resInserirStatusManutencao = $status->inserir();
    $status->codstatus = mysqli_insert_id($conexao->conexao);
}

if ($resInserirStatusManutencao == FALSE) {
    die(json_encode(array('mensagem' => 'Erro ao salvar status:' . mysqli_error($conexao->conexao), 'situacao' => false)));
} else {
    new Log($conexao, "Status manutenção salvo para nome: {$status->nome}");
    die(json_encode(array('mensagem' => 'Status manutenção salvo com sucesso!!!', 'situacao' => true)));
}


