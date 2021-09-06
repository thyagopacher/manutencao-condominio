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
$modulo = new Modulo($conexao);

$msg_retorno = '';
$sit_retorno = true;

$variables = (strtolower($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $modulo->$key = $value;
}

$modulop = $conexao->comandoArray('select codmodulo, nome, titulo 
    from modulo 
    where nome = "' . $modulo->nome . '"       
    and titulo = ' . $modulo->titulo);


if (!isset($modulo->nome) || $modulo->nome == NULL || $modulo->nome == "") {
    die(json_encode(array('mensagem' => 'Por favor insira nome para o módulo!', 'situacao' => false)));
}

if (isset($modulo->codmodulo) && $modulo->codmodulo != NULL && $modulo->codmodulo != "") {
    $resInserirModulo = $modulo->atualizar();
} else { 
    $modulo->codmorador = $_SESSION["codpessoa"];

    if (isset($modulop["codmodulo"]) && $modulop["codmodulo"] != NULL && $modulop["codmodulo"] != "") {
        die(json_encode(array('mensagem' => 'Modulo ja cadastrado, por favor verifique!', 'situacao' => false)));
    }
    $resInserirModulo = $modulo->inserir();
    $modulo->codmodulo = mysqli_insert_id($conexao->conexao);
}

if ($resInserirModulo == FALSE) {
    die(json_encode(array('mensagem' => 'Erro ao salvar nível:' . mysqli_error($conexao->conexao), 'situacao' => false)));
} else {
    
    new Log($conexao, "Modulo salvo para: {$modulo->nome} - dia: " .date("d/m/Y H:i"));
    die(json_encode(array('mensagem' => 'Modulo salva com sucesso!!!', 'situacao' => true)));
}


