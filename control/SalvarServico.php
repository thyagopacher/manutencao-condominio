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
$servico = new Servico($conexao);

$msg_retorno = '';
$sit_retorno = true;

$variables = (strtolower($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $servico->$key = $value;
}


if (!isset($servico->nome) || $servico->nome == NULL || $servico->nome == "") {
    die(json_encode(array('mensagem' => 'Por favor insira nome do servico!', 'situacao' => false)));
}
if (!isset($servico->observacao) || $servico->observacao == NULL || $servico->observacao == "") {
    die(json_encode(array('mensagem' => 'Por favor insira observacao do servico!', 'situacao' => false)));
}

if (isset($servico->codservico) && $servico->codservico != NULL && $servico->codservico != "") {
    $resInserirServico = $servico->atualizar();
} else {
    $sql = 'select codservico, nome
        from servico 
        where codempresa = ' . $_SESSION["codempresa"] . ' 
        and nome = "' . $servico->nome . '" ';
    $servicop = $conexao->comandoArray($sql);    

    if (isset($servicop["codservico"]) && $servicop["codservico"] != NULL && $servicop["codservico"] != "") {
        die(json_encode(array('mensagem' => 'Servico ja cadastrado, por favor verifique!', 'situacao' => false)));
    }
    $resInserirServico = $servico->inserir();
    $servico->codservico = mysqli_insert_id($conexao->conexao);
}

if ($resInserirServico == FALSE) {
    die(json_encode(array('mensagem' => 'Erro ao salvar servico:' . mysqli_error($conexao->conexao), 'situacao' => false)));
} else {
    new Log($conexao, "Servico salvo para nome: {$servico->nome}");
    die(json_encode(array('mensagem' => 'Servico salvo com sucesso!!!', 'situacao' => true)));
}


