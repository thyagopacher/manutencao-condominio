<?php
session_start();
//validação caso a sessão caia
if (!isset($_SESSION["codempresa"])) {
    die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
}

include "../model/Conexao.php";
$conexao = new Conexao();

include "../model/Equipamento.php";
$equipamento = new Equipamento($conexao);

$resequipamento = $equipamento->procurar($_POST);
$qtdequipamento = $conexao->qtdResultado($resequipamento);

if ($qtdequipamento > 0) {
    echo 'Encontrou ', $qtdequipamento, ' resultados<br>';
    ?>
    <table id="table_equipamento" class="display responsive nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>
                    Registrado em
                </th>
                <th>Por</th>
                <th>Nome</th>
                <th>Executor</th>
                <th>Fornecedor</th>
                <th>Local</th>
                <th>Status</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($equipamento = $conexao->resultadoArray($resequipamento)) { ?>
                <tr>
                    <td data-order="<?= $equipamento["dtcadastro"]?>">
                        <?= $equipamento["dtcadastro2"] ?>
                    </td>
                    <td>
                        <?= $equipamento["funcionario"] ?>
                    </td>
                    <td><?= $equipamento["nome"] ?></td>
                    <td><?= $equipamento["executor"] ?></td>
                    <td><?= $equipamento["fornecedor"] ?></td>
                    <td><?= $equipamento["local"] ?></td>
                    <td><?= $conexao->trocaStatus($equipamento["status"]) ?></td>
                    <td>
                        <a href="?codequipamento=<?= ($equipamento["codequipamento"]); ?>" title="Clique aqui para editar">
                            <img style="width: 20px;" src="../visao/recursos/img/editar.png" alt="botão editar"/>
                        </a>
                        <a href="javascript: excluirEquipamento(<?= $equipamento["codequipamento"] ?>)" title="Clique aqui para excluir">
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