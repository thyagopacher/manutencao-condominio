<?php

/*
 * @author Thyago Henrique Pacher - thyago.pacher@gmail.com
 */

session_start();
if (!isset($_SESSION)) {
    die(json_encode(array('mensagem' => 'Sua sessão caiu, por favor logue novamente!!!', 'situacao' => false)));
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
$pessoa = new Pessoa($conexao);

$variables = (strtolower($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $pessoa->$key = $value;
}

$msg_retorno = '';
$sit_retorno = true;

$pessoap = $conexao->comandoArray("select imagem from pessoa where codpessoa = {$pessoa->codpessoa}");

$res = $pessoa->excluir();

if ($res === FALSE) {
    $msg_retorno = 'Erro ao excluir pessoa! Causado por:' . mysqli_error($conexao->conexao);
    $sit_retorno = false;
} else {

    $msg_retorno = "Pessoa excluida com sucesso!";

    if (isset($pessoap["imagem"]) && $pessoap["imagem"] != NULL && $pessoap["imagem"] != "") {
        $resExcluirImg = unlink('../arquivos/' . $pessoap["imagem"]);
        if ($resExcluirImg == FALSE) {
            $msg_retorno .= " Imagem de usuário não pode ser apagada";
        }
    }
}

echo json_encode(array('mensagem' => $msg_retorno, 'situacao' => $sit_retorno));
