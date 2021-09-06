<?php
session_start();

include "../model/Conexao.php";
$conexao = new Conexao();

if (isset($_POST["codmodulo"]) && $_POST["codmodulo"] != NULL && $_POST["codmodulo"] != "") {
    $and .= " and pagina.codmodulo = {$_POST["codmodulo"]}";
}
if (isset($_POST["nome"]) && $_POST["nome"] != NULL && $_POST["nome"] != "") {
    $and .= " and pagina.nome like '%{$_POST["nome"]}%'";
}
$sql = 'select SQL_CACHE * from pagina where 1 = 1 ' . $and . ' order by nome';
$res = $conexao->comando($sql);
$qtd = $conexao->qtdResultado($res);

if ($qtd > 0) {
    ?>
    <table id="table_pagina" class="display responsive nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" name="marcarTudo" id="marcarTudo" onclick="marcarTudoPagina();" value="s"/>
                </th>
                <th>
                    Nome
                </th>
                <th>
                    Link
                </th>
                <th>
                    Titulo
                </th>
                <th>
                    Opções
                </th>
            </tr>
        </thead>
        <tbody>
            <?php while ($pagina = $conexao->resultadoArray($res)) { ?>
                <tr>
                    <td>
                        <input class="checkbox_pagina" type="checkbox" name="paginas_selecao[]" value="<?= $pagina["codpagina"] ?>"/>
                    </td>
                    <td>
                        <?= ($pagina["nome"]) ?>
                    </td>
                    <td>
                        <?= $pagina["link"] ?>
                    </td>
                    <td>
                        <?= ($pagina["titulo"]) ?>
                    </td>
                    <td>
                        <?php
                        $arrayJavascript = "new Array('{$pagina["codpagina"]}', '{$pagina["nome"]}', '" . ($pagina["titulo"]) . "', '{$pagina["link"]}', '{$pagina["codmodulo"]}', '{$pagina["abreaolado"]}', '{$pagina["iconepagina"]}')";
                        echo '<a href="javascript:setaEditarPagina(', $arrayJavascript, ')" title="Clique aqui para editar"><img src="./recursos/img/editar.png" alt="botão editar"/></a>';
                        echo '<a href="#" onclick="excluirPagina(', $pagina["codpagina"], ')" title="Clique aqui para excluir"><img src="./recursos/img/excluir.png" alt="botão excluir"/></a>';
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>

    </table>
    <?php
    $classe_linha = "even";
}
?>