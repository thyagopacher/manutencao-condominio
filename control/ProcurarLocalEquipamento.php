<?php
session_start();
//validação caso a sessão caia
if (!isset($_SESSION["codempresa"])) {
    die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
}

include "../model/Conexao.php";
$conexao = new Conexao();

include "../model/LocalEquipamento.php";
$local = new LocalEquipamento($conexao);



$reslocal = $local->procurar($_POST);
$qtdlocal = $conexao->qtdResultado($reslocal);
if ($qtdlocal > 0) {
    echo 'Encontrou ', $qtdlocal, ' resultados<br>';
    ?>
    <table id="table_local" class="display responsive nowrap" cellspacing="0" width="100%">
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
            <?php while ($local = $conexao->resultadoArray($reslocal)) { ?>
                <tr>
                    <td data-order="<?= $local["dtcadastro"]?>">
                        <?= $local["dtcadastro2"] ?>
                    </td>
                    <td>
                        <?= $local["funcionario"] ?>
                    </td>
                    <td>
                        <?= $local["nome"] ?>
                    </td>
                    <td>
                        <a href="Local.php?codlocal=<?= ($local["codlocal"]); ?>" title="Clique aqui para editar">
                            <img style="width: 20px;" src="../visao/recursos/img/editar.png" alt="botão editar"/>
                        </a>
                        <a href="javascript: excluirLocal(<?= $local["codlocal"] ?>)" title="Clique aqui para excluir">
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