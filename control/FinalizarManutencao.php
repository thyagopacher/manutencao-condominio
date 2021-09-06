<?php

/* 
 * @author Thyago Henrique Pacher - thyago.pacher@gmail.com
 */

session_start();
if(!isset($_SESSION)){
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
$manutencao  = new Manutencao($conexao);
$manutencao->codmanutencao = $_POST["codmanutencao"];

$msg_retorno = '';
$sit_retorno = true;

$res = $manutencao->finalizar();

if ($res === FALSE) {
    $msg_retorno = 'Erro ao finalizar manutenção! Causado por:' . $conexao->mostraErro();
    $sit_retorno = false;
} else {
    $msg_retorno = "Manutenção finalizada com sucesso!";
}

echo json_encode(array('mensagem' => $msg_retorno, 'situacao' => $sit_retorno));
