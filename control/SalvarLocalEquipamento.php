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
$local = new LocalEquipamento($conexao);

$msg_retorno = '';
$sit_retorno = true;

$variables = (strtolower($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $local->$key = $value;
}

if (isset($_FILES["imagem"])) {
    $upload = new Upload($_FILES["imagem"], $livre_tam);
    if ($upload->erro == '') {
        $local->imagem = $upload->nome_final;
    }
    if (isset($upload->erro) && $upload->erro != NULL && $upload->erro != '') {
        die(json_encode(array('mensagem' => $upload->erro, 'situacao' => false)));
    }
}

if (!isset($local->nome) || $local->nome == NULL || $local->nome == "") {
    die(json_encode(array('mensagem' => 'Por favor insira nome do local!', 'situacao' => false)));
}
if (!isset($local->descricao1) || $local->descricao1 == NULL || $local->descricao1 == "") {
    die(json_encode(array('mensagem' => 'Por favor insira descricao do local!', 'situacao' => false)));
}

if (isset($local->codlocal) && $local->codlocal != NULL && $local->codlocal != "") {
    $resInserirLocal = $local->atualizar();
} else {
    $localp = $conexao->comandoArray('select codlocal, nome 
        from localequipamento 
        where codempresa = ' . $_SESSION["codempresa"] . ' 
        and nome = "' . $local->nome . '"    
        and dtcadastro >= "' . date("Y-m-d") . ' 00:00:00" and dtcadastro <= "' . date("Y-m-d") . ' 23:59:59"');  

    if (isset($localp["codlocal"]) && $localp["codlocal"] != NULL && $localp["codlocal"] != "") {
        die(json_encode(array('mensagem' => 'Local ja cadastrado, por favor verifique!', 'situacao' => false)));
    }
    $resInserirLocal = $local->inserir();
}

if ($resInserirLocal == FALSE) {
    die(json_encode(array('mensagem' => 'Erro ao salvar local:' . mysqli_error($conexao->conexao), 'situacao' => false)));
} else {
    new Log($conexao, "Local salvo para nome: {$local->nome}");
    die(json_encode(array('mensagem' => 'Local salvo com sucesso!!!', 'situacao' => true)));
}
if (isset($upload->erro) && $upload->erro != NULL && $upload->erro != '') {
    $msg_retorno .= ' Problemas com o envio do arquivo: ' . $upload->erro;
}
echo json_encode(array('mensagem' => $msg_retorno, 'situacao' => $sit_retorno));



