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
$equipamento = new Equipamento($conexao);

$msg_retorno = '';
$sit_retorno = true;

$variables = (strtolower($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $equipamento->$key = $value;
}
$equipamento->codservico = implode(",", $_POST["codservico"]);
$and = '';
if (isset($_FILES["imagem"])) {
    $upload = new Upload($_FILES["imagem"], $livre_tam);
    if ($upload->erro == '') {
        $equipamento->imagem = $upload->nome_final;
    }
    if (isset($upload->erro) && $upload->erro != NULL && $upload->erro != '') {
        die(json_encode(array('mensagem' => $upload->erro, 'situacao' => false)));
    }
}

if (!isset($equipamento->nome) || $equipamento->nome == NULL || $equipamento->nome == "") {
    die(json_encode(array('mensagem' => 'Por favor insira nome do equipamento!', 'situacao' => false)));
}
if (!isset($equipamento->periodo) || $equipamento->periodo == NULL || $equipamento->periodo == "") {
    die(json_encode(array('mensagem' => 'Por favor insira periodo do equipamento!', 'situacao' => false)));
}
if (!isset($equipamento->status) || $equipamento->status == NULL || $equipamento->status == "") {
    die(json_encode(array('mensagem' => 'Por favor informe o status do equipamento!', 'situacao' => false)));
}
if (!isset($equipamento->qrcode) || $equipamento->qrcode == NULL || $equipamento->qrcode == "") {
    die(json_encode(array('mensagem' => 'Por favor informe o QR Code do equipamento!', 'situacao' => false)));
}


if (isset($equipamento->codequipamento) && $equipamento->codequipamento != NULL && $equipamento->codequipamento != "") {
    $resInserirEquipamento = $equipamento->atualizar();
} else {
    $sql = 'select codequipamento, nome, qrcode, status
        from equipamento 
        where codempresa = ' . $_SESSION["codempresa"] . ' 
        and (nome = "' . $equipamento->nome . '" or qrcode = "'.$equipamento->qrcode.'" )and "'.$equipamento->status.'" = "a"';
    $equipamentop = $conexao->comandoArray($sql);    

    if (isset($equipamentop["codequipamento"]) && $equipamentop["codequipamento"] != NULL && $equipamentop["nome"] == $equipamento->nome) {
        die(json_encode(array('mensagem' => 'Equipamento ja cadastrado, por favor verifique!', 'situacao' => false)));
    }    
    if (isset($equipamentop["qrcode"]) && $equipamentop["qrcode"] != NULL  && $equipamentop["qrcode"] == $equipamento->qrcode) {
        die(json_encode(array('mensagem' => 'Já temos um equipamento ativo com esse QR Code, verifique o status de seu equipamento !', 'situacao' => false)));
    }
    
    $resInserirEquipamento = $equipamento->inserir();
    $equipamento->codequipamento = mysqli_insert_id($conexao->conexao);
}

if ($resInserirEquipamento == FALSE) {
    die(json_encode(array('mensagem' => 'Erro ao salvar equipamento:' . mysqli_error($conexao->conexao), 'situacao' => false)));
} else {
    new Log($conexao, "Equipamento salvo para nome: {$equipamento->nome}");
    die(json_encode(array('mensagem' => 'Equipamento salvo com sucesso!!!', 'situacao' => true)));
}


