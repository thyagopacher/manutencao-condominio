<?php
session_start();
include "../model/Conexao.php";

$conexao = new Conexao();
$msg_retorno = "";
$sit_retorno = true;

$site    = $_SERVER["SERVER_NAME"];
$site    = str_replace('https://', '', $site);
$site    = str_replace('https://', '', $site);

$sql = "select pessoa.codpessoa, pessoa.nome, pessoa.codempresa, pessoa.morador, pessoa.acessapainel, pessoa.senha 
    from pessoa 
    inner join nivel on nivel.codnivel = pessoa.codnivel and nivel.codempresa = pessoa.codempresa
    where pessoa.email = '{$_POST["email"]}'";

$pessoa  = $conexao->comandoArray($sql);
$empresa = $conexao->comandoArray("select SQL_CACHE logo, site from empresa where codempresa = '{$pessoa['codempresa']}'");



if (isset($pessoa) && isset($pessoa['codpessoa'])) {
    include("../model/FilaEmail.php");
    $fila = new FilaEmail($conexao);
    $fila->codpessoa = $pessoa["codpessoa"];
    $fila->assunto = "Recuperação de senha - GestCCon - " . date("d/m/Y");
    $fila->codempresa = $pessoa["codempresa"];
    $fila->codfuncionario = $pessoa["codpessoa"];
    $fila->codpagina = 4;
    $fila->dtcadastro = date("Y-m-d H:i:s");
    $fila->situacao = 'n';
    $fila->tipo = 7;
    $fila->texto = "Recuperação de Senha para acesso ao portal do condominio<br>";
    $fila->texto .= "Olá caro usuário {$pessoa['nome']} sua senha é [senha]<br>";
    if (isset($pessoa["morador"]) && $pessoa["morador"] != NULL && $pessoa["morador"] == "s") {
        if (isset($empresa["site"]) && $empresa["site"] != NULL && $empresa["site"] != "") {
            $fila->texto .= "Link de acesso {$empresa["razao"]}: <a href='{$empresa["site"]}'>Acesso Portal</a><br>";
        }
    }
    if (isset($pessoa["acessapainel"]) && $pessoa["acessapainel"] != NULL && $pessoa["acessapainel"] == "s") {
        $fila->texto .= "Link de acesso {$empresa["razao"]}: <a href='https://manutencao.gestccon.com.br/'>Acesso Painel ADM</a><br>";
    }
    $fila->texto .= "<br>Para mudar sua senha vai em Minhas informações, acione editar, digite a nova senha e atualize seu cadastro.";
    $resInserir = $fila->inserir();
    if ($resInserir == FALSE) {
        $msg_retorno = "Erro causado:" . mysqli_errno($conexao->conexao);
    }
} else {
    $msg_retorno = "Erro ao recuperar senha, nenhum login encontrado com esse e-mail!";
    $sit_retorno = false;
}

if($sit_retorno){
    $msg_retorno = "E-mail enviado com sucesso!";
}

echo json_encode(array('mensagem' => $msg_retorno, 'situacao' => $sit_retorno));
