<?php

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
if(isset($_POST["codempresa"]) && $_POST["codempresa"] != NULL && $_POST["codempresa"] != ""){
    $codempresa = $_POST["codempresa"];
}else{
    $codempresa = $_SESSION["codempresa"];
}
$conexao = new Conexao();
$pessoa = new Pessoa($conexao);
$res = $pessoa->procurar($_POST);
$qtd = $conexao->qtdResultado($res);
if ($qtd > 0) {
    ?>
    <table id="table_pessoa" class="display responsive nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>
                    Data Cad.
                </th>
                <th>
                    Nome
                </th>
                <th>Nivel</th>
                <th>Status</th>
                <th>
                    Opções
                </th>
            </tr>
        </thead>
        <tbody>
            <?php while ($pessoa = $conexao->resultadoArray($res)) { ?>
                <tr>
                    <td>
                        <?php
                        if(isset($pessoa["dtcadastro"]) && $pessoa["dtcadastro"] != NULL && $pessoa["dtcadastro"] != ""){
                            echo date("d/m/Y", strtotime($pessoa["dtcadastro"]));
                        }
                        ?>
                    </td>
                    <td><?= $pessoa["nome"] ?></td>
                    <td><?= $pessoa["nivel_pessoa"] ?></td>
                    <td><?= $conexao->trocaStatus($pessoa["status"]) ?></td>
                    <td>
                        <?php
                        echo '<a href="javascript: procurarCodigo(', $pessoa["codpessoa"], ', ',$codempresa,')" title="Clique aqui para editar"><img style="width: 20px;" src="./recursos/img/editar.png" alt="botão editar"/></a> ';
                        echo '<a href="javascript: excluirPessoa(', $pessoa["codpessoa"], ')" title="Clique aqui para excluir"><img style="width: 20px;" src="./recursos/img/excluir.png" alt="botão excluir"/></a> ';
                        if($pessoa["status"] == "a"){
                            echo '<a href="javascript: inativarPessoa(', $pessoa["codpessoa"], ')" title="Clique aqui para inativar"><i class="fa fa-ban" aria-hidden="true"></i></a> ';
                        }else{
                            echo '<a href="javascript: ativarPessoa(', $pessoa["codpessoa"], ')" title="Clique aqui para inativar"><i class="fa fa-check" aria-hidden="true"></i></a> ';
                        }
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>

    </table>
    <?php
}
?>