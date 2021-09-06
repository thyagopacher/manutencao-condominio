<?php
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);
header('Content-type: text/html; charset=utf-8');
session_start();
//validação caso a sessão caia
if (!isset($_SESSION)) {
    die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
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
$log = new Log($conexao);
$res = $log->procurar($_POST);
$qtd = $conexao->qtdResultado($res);
if ($qtd > 0) {
    echo "Encontrou {$qtd} resultados<br>";
    ?>
    <table id="table_log" class="display responsive nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>
                    Data Cad.
                </th>
                <th>
                    Nome
                </th>
                <th>
                    Nível
                </th>
                <th>
                    O que
                </th>
            </tr>
        </thead>
        <tbody>
            <?php while ($log = $conexao->resultadoArray($res)) { ?>
                <tr>
                    <td data-order="<?=$log["data"] .' '. $log["hora"]?>">
                        <?= date("d/m/Y", strtotime($log["data"])). ' ' .$log["hora"]?>
                    </td>
                    <td>
                        <?= ($log["pessoa"]) ?>
                    </td>
                    <td>
                        <?= $log["nivel"] ?>
                    </td>
                    <td>
                        <?= $log["observacao"] ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>

    </table>

    <?php
    $classe_linha = "even";
}

function trocaStatus($status) {
    switch ($status) {
        case 'a':
            $status = "Ativo";
            break;
        case 'i':
            $status = "Inativo";
            break;
    }
    return $status;
}

function trocaTipo($status) {
    switch ($status) {
        case 'p':
            $status = "PopUp";
            break;
        case 'n':
            $status = "Normal";
            break;
        case 'v':
            $status = "Vagas";
            break;
    }
    return $status;
}
?>