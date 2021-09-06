<?php

ini_set('zlib.output_compression', '1');
header('Content-Type: text/html; charset=utf-8');
header('Cache-Control:public, max-age=31536000');
header('X-Powered-by: Thyago H. Pacher - thyago.pacher@gmail.com');

session_start();

if (!isset($_SESSION["codpessoa"])) {
    echo '<script>alert("Sua sessão caiu por favor faça login novamente!!!"); location.href="/"</script>';
}

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
$cache = new Cache();

$empresap = $cache->read('empresap');
if (!isset($empresap) || $empresap == NULL) {
    $sql = 'select SQL_CACHE * from empresa where codempresa = 1';
    $empresap = $conexao->comandoArray($sql);
    if (mb_detect_encoding($empresap["razao"], 'UTF-8', true) == FALSE) {
        $empresap["razao"] = ($empresap["razao"]);
    }
    $cache->save('empresap', $empresap, '180 minutes');
}

$pagina = $_SERVER["REQUEST_URI"];
$separado_pagina = explode('/', $pagina);
$pagina = $separado_pagina[count($separado_pagina) - 1];
$pagina = explode('?', $pagina); //limpa código página
$pagina = $pagina[0];

$nivelp = $cache->read('nivelpCodnivel' . $_SESSION["codnivel"] . 'Link' . $pagina);
if (!isset($nivelp) || $nivelp == NULL) {
    $sql = "select SQL_CACHE nivelpagina.*, pagina.nome as pagina, modulo.nome as modulo, pagina.link as pagina_link 
                from nivelpagina 
                inner join pagina on pagina.codpagina = nivelpagina.codpagina    
                inner join modulo on modulo.codmodulo = pagina.codmodulo
                where nivelpagina.codnivel = '{$_SESSION["codnivel"]}' and pagina.link = '{$pagina}'";
    $nivelp = $conexao->comandoArray($sql);

    if (mb_detect_encoding($nivelp["modulo"], 'UTF-8', true) == FALSE) {
        $nivelp["modulo"] = ($nivelp["modulo"]);
    }
    if (mb_detect_encoding($nivelp["pagina"], 'UTF-8', true) == FALSE) {
        $nivelp["pagina"] = ($nivelp["pagina"]);
    }
    $cache->save('nivelpCodnivel' . $_SESSION["codnivel"] . 'Link' . $pagina, $nivelp, '180 minutes');
}

$_SESSION["codpagina"] = $nivelp["codpagina"];

function montaStatus($codstatus = null) {
    if (isset($_GET["status"]) && $_GET["status"] != NULL && $_GET["status"] != "") {
        $codstatus = $_GET["status"];
    }
    $status_padroes = array('a' => 'Ativo', 'i' => 'Inativo', 'n' => 'Novo');
    echo '<!-- status padrão -->';
    echo '<div class="col-md-3">';
    echo '<div class="form-group">';
    echo '<label>Status</label>';
    echo '<select class="form-control" required name="status" id="status">';
    echo "<option value=''>--Selecione--</option>";
    foreach ($status_padroes as $key => $status) {
        if (isset($codstatus) && $codstatus != NULL && $codstatus == $key) {
            echo "<option selected value='$key'>$status</option>";
        } else {
            echo "<option value='$key'>$status</option>";
        }
    }
    echo '</select>';
    echo '</div>';
    echo '</div>';
}

function montaNome($nome = '') {
    echo '<div class="col-md-6">';
    echo '<div class="form-group">';
    echo '<label>Nome</label>';
    echo '<input type="text" class="form-control" name="nome" id="nome" placeholder="Digite nome" value="', $nome, '">';
    echo '</div>';
    echo '</div>';
}
