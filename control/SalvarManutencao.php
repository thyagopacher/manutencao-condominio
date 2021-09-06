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
$manutencao = new Manutencao($conexao);

$msg_retorno = '';
$sit_retorno = true;

$variables = (strtolower($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $manutencao->$key = $value;
}
$manutencao->codservico = implode(",", $_POST["codservico"]);
if (isset($_POST["codpagina"]) && $_POST["codpagina"] != NULL && $_POST["codpagina"] != 113) {
    if (!isset($manutencao->codequipamento) || $manutencao->codequipamento == NULL || $manutencao->codequipamento == "") {
        die(json_encode(array('mensagem' => 'Por favor selecione o equipamento para manutenção!', 'situacao' => false)));
    }

    if (!isset($manutencao->data) || $manutencao->data == NULL || $manutencao->data == "") {
        die(json_encode(array('mensagem' => 'Por favor selecione data para manutenção!', 'situacao' => false)));
    }
}

if (isset($_FILES['imagem_servico'])) {
    $upload = new Upload($_FILES['imagem_servico']);
    if ($upload->erro == '') {
        $manutencao->imagem_servico = $upload->nome_final;
    }
}

if (isset($_FILES['imginicio'])) {
    $upload = new Upload($_FILES['imginicio']);
    if ($upload->erro == '') {
        $manutencao->imginicio = $upload->nome_final;
    }
}

if (isset($_FILES['imgfim'])) {
    $upload = new Upload($_FILES['imgfim']);
    if ($upload->erro == '') {
        $manutencao->imgfim = $upload->nome_final;
    }
}

if (isset($manutencao->codmanutencao) && $manutencao->codmanutencao != NULL && $manutencao->codmanutencao != "") {
    $resInserirManutencao = $manutencao->atualizar();
} else {
    $manutencaop = $conexao->comandoArray('select codmanutencao 
    from manutencao 
    where codempresa = ' . $_SESSION["codempresa"] . ' 
    and codequipamento = ' . $manutencao->codequipamento . '    
    and data = "' . $manutencao->data . '"
    and valor = "' . $manutencao->valor . '"    
    and codfuncionario = ' . $_SESSION["codpessoa"]);
    if (isset($manutencaop["codmanutencao"]) && $manutencaop["codmanutencao"] != NULL && $manutencaop["codmanutencao"] != "") {
        die(json_encode(array('mensagem' => 'Manutenção ja cadastrada, por favor verifique!', 'situacao' => false)));
    }
    $resInserirManutencao = $manutencao->inserir();
    $manutencao->codmanutencao = mysqli_insert_id($conexao->conexao);
}

if ($resInserirManutencao == FALSE) {
    die(json_encode(array('mensagem' => 'Erro ao salvar manutenção:' . mysqli_error($conexao->conexao), 'situacao' => false)));
} else {
    new Log($conexao, "Manutenção salva para local: {$manutencao->local} - titulo: {$manutencao->titulo} - Descrição: {$manutencao->descricao}");
    die(json_encode(array('mensagem' => 'Manutenção salva com sucesso!!!', 'situacao' => true)));
}


