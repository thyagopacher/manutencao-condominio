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
$empresa = new Empresa($conexao);
$res = $empresa->procurar($_POST);
$qtd = $conexao->qtdResultado($res);
if ($qtd > 0) {
    echo "Encontrou {$qtd} resultados<br>";
    ?>
    <table id="table_empresa" class="display responsive nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>
                    <i class="fa fa-calendar"></i>
                    Data Cad.
                </th>
                <th>
                    Razão
                </th>
                <th>
                    <i class="fa fa-envelope"></i>
                    E-mail
                </th>
                <th>
                    <i class="fa fa-phone"></i>
                    Telefone
                </th>
                <th>
                    <i class="fa fa-mobile" aria-hidden="true"></i>
                    Celular
                </th>
                <th>
                    Status
                </th>
                <th>
                    Opções
                </th>
            </tr>
        </thead>
        <tbody>
            <?php while ($empresa = $conexao->resultadoArray($res)) { ?>
                <tr>
                    <td data-order="<?=$empresa["dtcadastro"]?>">
                        <?= date("d/m/Y", strtotime($empresa["dtcadastro"])) ?>
                    </td>
                    <td>
                        <?= $empresa["razao"] ?>
                    </td>
                    <td>
                        <a title="clique para enviar e-mail" href="mailto: <?= $empresa["email"] ?>"><?= $empresa["email"] ?></a>
                    </td>
                    <td>
                        <a title="clique para telefonar" href="tel: <?= $empresa["telefone"] ?>"><?= $empresa["telefone"] ?></a>
                    </td>
                    <td>
                        <a title="clique para telefonar" href="tel: <?= $empresa["celular"] ?>"><?= $empresa["celular"] ?></a>
                    </td>
                    <td>
                        <?= ($empresa["status"]) ?>
                    </td>
                    <td>
                        <?php
                        echo '<a href="Empresa.php?codempresa=', $empresa["codempresa"], '" title="Clique aqui para editar"><img style="width: 20px;" src="./recursos/img/editar.png" alt="botão editar"/></a>';
                        echo '<a href="javascript: excluirEmpresa(', $empresa["codempresa"], ')" title="Clique aqui para excluir"><img style="width: 20px;" src="./recursos/img/excluir.png" alt="botão excluir"/></a>';
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>

    </table>

    <?php
}
