<?php
session_start();
//validação caso a sessão caia
if (!isset($_SESSION["codempresa"])) {
    die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
}

include "../model/Conexao.php";
$conexao = new Conexao();

include "../model/Servico.php";
$servico = new Servico($conexao);

$resservico = $servico->procurar($_POST);
$qtdservico = $conexao->qtdResultado($resservico);

if ($qtdservico > 0) {
    echo 'Encontrou ', $qtdservico, ' resultados<br>';
    ?>
    <table id="table_servico" class="display responsive nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>
                    Registrado em
                </th>
                <th>
                    Por
                </th>
                <th>
                    Nome
                </th>
                <th>
                    Opções
                </th>
            </tr>
        </thead>
        <tbody>
            <?php while ($servico = $conexao->resultadoArray($resservico)) { ?>
                <tr>
                    <td data-order="<?= $servico["dtcadastro"]?>">
                        <?= $servico["dtcadastro2"] ?>
                    </td>
                    <td>
                        <?= $servico["funcionario"] ?>
                    </td>
                    <td>
                        <?= $servico["nome"] ?>
                    </td>
                    <td>
                        <a href="?codservico=<?= ($servico["codservico"]); ?>" title="Clique aqui para editar">
                            <img style="width: 20px;" src="../visao/recursos/img/editar.png" alt="botão editar"/>
                        </a>
                        <a href="javascript: excluirServico(<?= $servico["codservico"] ?>)" title="Clique aqui para excluir">
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