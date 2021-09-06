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


if (isset($_POST["paginas_selecao"]) && $_POST["paginas_selecao"] != NULL && count($_POST["paginas_selecao"]) > 0) {
    foreach ($_POST["paginas_selecao"] as $key => $codpagina) {
        $pagina = new Pagina($conexao);
        $pagina->codpagina = $codpagina;
        $res = $pagina->excluir();
        if ($res === FALSE) {
            $msg_retorno = 'Erro ao excluir página! Causado por:' . mysqli_error($conexao->conexao);
            $sit_retorno = false;
            break;
        }
    }
} else {
    $pagina = new Pagina($conexao);
    $pagina->codpagina = $_POST["codpagina"];
    $res = $pagina->excluir();
}

$msg_retorno = '';
$sit_retorno = true;

if ($res === FALSE) {
    $msg_retorno = 'Erro ao excluir página! Causado por:' . mysqli_error($conexao->conexao);
    $sit_retorno = false;
} else {
    $msg_retorno = "Página excluida com sucesso!";
}

echo json_encode(array('mensagem' => $msg_retorno, 'situacao' => $sit_retorno));
