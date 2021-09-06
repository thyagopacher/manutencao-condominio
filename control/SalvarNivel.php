<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_erros', 1);
//error_reporting(E_ALL);
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
$nivel = new Nivel($conexao);

$msg_retorno = '';
$sit_retorno = true;

$variables = (strtolower($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $nivel->$key = $value;
}

$nivelp = $conexao->comandoArray('select codnivel, imagem 
    from nivel 
    where codempresa = ' . $_SESSION["codempresa"] . ' 
    and nome = "' . $nivel->nome . '"       
    and dtcadastro >= "' . date("Y-m-d") . ' 00:00:00" and dtcadastro <= "' . date("Y-m-d") . ' 23:59:59"    
    and codfuncionario = ' . $_SESSION["codpessoa"]);


if (!isset($nivel->nome) || $nivel->nome == NULL || $nivel->nome == "") {
    die(json_encode(array('mensagem' => 'Por favor insira nome para o nível!', 'situacao' => false)));
}

if (isset($nivel->codnivel) && $nivel->codnivel != NULL && $nivel->codnivel != "") {
    $resInserirNivel = $nivel->atualizar();
} else { 
    $nivel->codmorador = $_SESSION["codpessoa"];

    if (isset($nivelp["codnivel"]) && $nivelp["codnivel"] != NULL && $nivelp["codnivel"] != "") {
        die(json_encode(array('mensagem' => 'Nivel ja cadastrado, por favor verifique!', 'situacao' => false)));
    }
    $resInserirNivel = $nivel->inserir();
    $nivel->codnivel = mysqli_insert_id($conexao->conexao);
}

if ($resInserirNivel == FALSE) {
    die(json_encode(array('mensagem' => 'Erro ao salvar nível:' . mysqli_error($conexao->conexao), 'situacao' => false)));
} else {
    
    new Log($conexao, "Nivel salvo para: {$nivel->nome} - dia: " .date("d/m/Y H:i"));
    die(json_encode(array('mensagem' => 'Nivel salva com sucesso!!!', 'situacao' => true)));
}


