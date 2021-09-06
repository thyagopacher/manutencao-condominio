<?php
session_start();
//validação caso a sessão caia
if (!isset($_SESSION["codempresa"])) {
    die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
}

include "../model/Conexao.php";
$conexao = new Conexao();

$sql = "select DATE_FORMAT(local.dtcadastro, '%d/%m/%Y') as dtcadastro2,
local.nome, funcionario.nome as funcionario, local.dtcadastro, local.codlocal
from localmanutencao as local
left join pessoa as funcionario on funcionario.codpessoa = local.codfuncionario  
and local.codempresa = '{$_SESSION['codempresa']}'
order by local.dtcadastro desc";

$reslocalmanutencao = $conexao->comando($sql)or die("<pre>$sql</pre>");
$qtdlocalmanutencao = $conexao->qtdResultado($reslocalmanutencao);
if ($qtdlocalmanutencao > 0) {
    echo 'Encontrou ', $qtdlocalmanutencao, ' resultados<br>';
    ?>
    <table id="table_localmanutencao" class="display responsive nowrap" cellspacing="0" width="100%">
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
            <?php while ($localmanutencao = $conexao->resultadoArray($reslocalmanutencao)) { ?>
                <tr>
                    <td data-order="<?= $localmanutencao["dtcadastro"]?>">
                        <?= $localmanutencao["dtcadastro2"] ?>
                    </td>
                    <td>
                        <?= $localmanutencao["funcionario"] ?>
                    </td>
                    <td>
                        <?= $localmanutencao["nome"] ?>
                    </td>
                    <td>
                        <a href="?codigo=<?= base64_encode($localmanutencao["codlocal"]); ?>" title="Clique aqui para editar">
                            <img style="width: 20px;" src="./visao/recursos/img/editar.png" alt="botão editar"/>
                        </a>
                        <a href="javascript: excluirLocalManutencao(<?= $localmanutencao["codlocalmanutencao"] ?>)" title="Clique aqui para excluir">
                            <img style="width: 20px;" src="./visao/recursos/img/excluir.png" alt="botão excluir"/>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>


        <?php
        $classe_linha = "even";
    }
    ?>