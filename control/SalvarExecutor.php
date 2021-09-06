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
$executor = new Executor($conexao);


$msg_retorno = '';
$sit_retorno = true;

$variables = (strtolower($_SERVER['REQUEST_METHOD']) == 'GET') ? $_GET : $_POST;
foreach ($variables as $key => $value) {
    $executor->$key = $value;
}


if (isset($_FILES['imagemexecutor'])) {
    $upload = new Upload($_FILES['imagemexecutor']);
    if ($upload->erro == '') {
        $executor->imagemexecutor = $upload->nome_final;
    }
}

if (in_array($executor->tipo, array('f', 'p'))) {
    if (!isset($executor->nome) || $executor->nome == NULL || $executor->nome == "") {
        die(json_encode(array('mensagem' => 'Por favor insira nome!', 'situacao' => false)));
    }
}else{
    $executor->nome = $executor->razao;
}
if (isset($executor->codexecutor) && $executor->codexecutor != NULL && $executor->codexecutor != "") {
    $resInserirExecutor = $executor->atualizar();
} else {
    $sql = 'select codexecutor, nome 
        from executor
        where codempresa = ' . $_SESSION["codempresa"] . ' 
        and nome = "' . $executor->nome . '" 
        and dtcadastro >= "' . date("Y-m-d") . ' 00:00:00" and dtcadastro <= "' . date("Y-m-d") . ' 23:59:59"';
    $executorp = $conexao->comandoArray($sql);
    if (isset($executorp["codexecutor"]) && $executorp["codexecutor"] != NULL && $executorp["codexecutor"] != "") {
        die(json_encode(array('mensagem' => 'Já cadastrado, por favor verifique!', 'situacao' => false)));
    }   
    $resInserirExecutor = $executor->inserir();
    $executor->codexecutor = mysqli_insert_id($conexao->conexao);
}

if ($resInserirExecutor == FALSE) {
    die(json_encode(array('mensagem' => 'Erro ao salvar executor:' . mysqli_error($conexao->conexao), 'situacao' => false)));
} else {
    //tem que passar codpessoa ou codempresa 
    if ($executor->tipo == "e") {
        
        $empresa = new Empresa($conexao);
        $empresa->codempresa = $_POST["codempresa"];
        $empresa->codexecutor = $executor->codexecutor;
        $empresa->razao = $_POST["razao"];
        $empresa->cep = $_POST["cep"];
        $empresa->tipologradouro = $_POST["tipologradouro"];
        $empresa->logradouro = $_POST["logradouro"];
        $empresa->numero = $_POST["numero"];
        $empresa->bairro = $_POST["bairro"];
        $empresa->cidade = $_POST["cidade"];
        $empresa->uf = $_POST["estado"];
        $empresa->telefone = $_POST["telefone1"];
        $empresa->celular = $_POST["telefone2"];
        $empresa->site = $_POST["siteurl"];
        $empresa->cnpj = $_POST["cnpj"];
        $empresa->email = $_POST["email1"];
        $empresa->skype = $_POST["skype"];
        $empresa->logo = $executor->imagem;
        if(isset($empresa->codempresa) && $empresa->codempresa != NULL && $empresa->codempresa != ""){
            $empresa->atualizar();
        }else{
            $empresa->inserir(); 
        }
    }elseif($executor->tipo == "p" || $executor->tipo == "f"){
        $pessoa = new Pessoa($conexao);
        $pessoa->codpessoa = $_POST["codpessoa"];
        $pessoa->codexecutor = $executor->codexecutor;
        $pessoa->nome = $_POST["nome"];
        $pessoa->cep = $_POST["cep"];
        $pessoa->tipologradouro = $_POST["tipologradouro"];
        $pessoa->logradouro = $_POST["logradouro"];
        $pessoa->numero = $_POST["numero"];
        $pessoa->bairro = $_POST["bairro"];
        $pessoa->cidade = $_POST["cidade"];
        $pessoa->uf = $_POST["estado"];
        $pessoa->telefone = $_POST["telefone1"];
        $pessoa->celular = $_POST["telefone2"];
        $pessoa->site = $_POST["siteurl"];
        $pessoa->email = $_POST["email1"];
        $pessoa->skype = $_POST["skype"];
        if(isset($pessoa->codpessoa) && $pessoa->codpessoa != NULL && $pessoa->codpessoa != ""){
            $pessoa->atualizar();
        }else{
            $pessoa->inserir(); 
        }      
    }
    new Log($conexao, "Executor salvo para nome: {$executor->nome}");
    die(json_encode(array('mensagem' => 'Executor salvo com sucesso!!!', 'situacao' => true)));
}


