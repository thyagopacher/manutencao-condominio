<?php
session_start();
//validação caso a sessão caia
if (!isset($_SESSION["codempresa"])) {
    die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
}

include "../model/Conexao.php";
$conexao = new Conexao();

include "../model/Executor.php";
$executor = new Executor($conexao);

$resexecutor = $executor->procurar($_POST);
$qtdexecutor = $conexao->qtdResultado($resexecutor);

if ($qtdexecutor > 0) {
    echo 'Encontrou ', $qtdexecutor, ' resultados<br>';
    ?>
    <table id="table_executor" class="display responsive nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>
                    Registrado em
                </th>
                <th>
                    Por
                </th>
                <th>Nome</th>
                <th>Status</th>
                <th>
                    Opções
                </th>
            </tr>
        </thead>
        <tbody>
            <?php while ($executor = $conexao->resultadoArray($resexecutor)) { ?>
                <tr>
                    <td data-order="<?= $executor["dtcadastro"]?>">
                        <?= $executor["dtcadastro2"] ?>
                    </td>
                    <td>
                        <?= $executor["funcionario"] ?>
                    </td>
                    <td><?= $executor["nome"] ?></td>
                    <td><?= $conexao->trocaStatus($executor["status"]) ?></td>
                    <td>
                        <a href="Executor.php?codexecutor=<?= ($executor["codexecutor"]); ?>" title="Clique aqui para editar">
                            <img style="width: 20px;" src="../visao/recursos/img/editar.png" alt="botão editar"/>
                        </a>
                        <a href="javascript: excluirExecutor(<?= $executor["codexecutor"] ?>)" title="Clique aqui para excluir">
                            <img style="width: 20px;" src="../visao/recursos/img/excluir.png" alt="botão excluir"/>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>


        <?php
        $classe_linha = "even";
    }
    ?>