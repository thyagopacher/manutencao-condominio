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

$conexao = new Conexao();
$local = new LocalManutencao($conexao);

$msg_retorno = '';
$sit_retorno = true;

$variables = (strtolower($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $local->$key = $value;
}

if (!isset($local->nome) || $local->nome == NULL || $local->nome == "") {
    die(json_encode(array('mensagem' => 'Por favor insira nome do local!', 'situacao' => false)));
}

if (isset($local->codlocal) && $local->codlocal != NULL && $local->codlocal != "") {
    $resInserirLocal = $local->atualizar();
} else {

    $localp = $conexao->comandoArray('select codlocal, nome 
    from local 
    where codempresa = ' . $_SESSION["codempresa"] . ' 
    and nome = "' . $local->nome . '"    
    and dtcadastro >= "' . date("Y-m-d") . ' 00:00:00" and dtcadastro <= "' . date("Y-m-d") . ' 23:59:59"');

    $local->codfuncionario = $_SESSION["codpessoa"];

    if (isset($localp["codlocal"]) && $localp["codlocal"] != NULL && $localp["codlocal"] != "") {
        die(json_encode(array('mensagem' => 'Local ja cadastrado, por favor verifique!', 'situacao' => false)));
    }
    $resInserirLocal = $local->inserir();
    $local->codlocal = mysqli_insert_id($conexao->conexao);
}

if ($resInserirLocal == FALSE) {
    die(json_encode(array('mensagem' => 'Erro ao salvar local:' . mysqli_error($conexao->conexao), 'situacao' => false)));
} else {
    new Log($conexao, "Local salvo para nome: {$local->nome}");
    die(json_encode(array('mensagem' => 'Local salvo com sucesso!!!', 'situacao' => true)));
}


