<?php
session_start();
//validação caso a sessão caia
if (!isset($_SESSION["codempresa"])) {
    die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
}

include "../model/Conexao.php";
$conexao = new Conexao();

include "../model/Manutencao.php";
$manutencao = new Manutencao($conexao);

$resmanutencao = $manutencao->procurar($_POST);
$qtdmanutencao = $conexao->qtdResultado($resmanutencao);
if ($qtdmanutencao > 0) {
    echo 'Encontrou ', $qtdmanutencao, ' resultados<br>';
    ?>
<div class="">
    <table id="table_manutencao" class="table-responsive display responsive nowrap" cellspacing="0">
        <thead>
            <tr>
                <th>Registrado</th>
                <th>Por</th>
                <th>Equipamento</th>
                <th>Data Agenda</th>
                <th>Tipo</th>
                <th>Status</th>
                <th>Fornecedor</th>
                <th>Executor</th>
                <th>Valor</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($manutencaop = $conexao->resultadoArray($resmanutencao)) { ?>
                <tr>
                    <td data-order="<?= $manutencaop["dtcadastro"]?>">
                        <?= $manutencaop["dtcadastro2"] ?>
                    </td>
                    <td>
                        <?= $manutencaop["funcionario"] ?>
                    </td>
                    <td>
                        <?= $manutencaop["equipamento"] ?>
                    </td>
                    <td data-order="<?= $manutencaop["data"] ?>">
                        <?php 
                        echo date("d/m/Y", strtotime($manutencaop["data"]));
                        if(isset($manutencaop["datafim"]) && $manutencaop["datafim"] != NULL && $manutencaop["datafim"] != "0000-00-00"){
                            echo " - ". date("d/m/Y", strtotime($manutencaop["datafim"]));
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $manutencao->trocaTipo($manutencaop["tipo"]);
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $manutencaop["status"];
                        ?>
                    </td>
                    <td><?=$manutencaop["fornecedor"]?></td>
                    <td><?=$manutencaop["executor"]?></td>
                    <td>
                        <?php echo number_format($manutencaop["valor"], 2, ',', '.') ?>
                    </td>
                    <td>
                        <a href="?codmanutencao=<?= $manutencaop["codmanutencao"] ?>">
                            <img style="width: 20px;" src="../visao/recursos/img/editar.png" alt="botão editar"/>
                        </a>
                        <?php if($_POST["codpagina"] == 113){?>
                        <a href="javascript: imprimirDireto('OrdemServico.php?codmanutencao=<?= $manutencaop["codmanutencao"] ?>')">
                            <i class="fa fa-print" aria-hidden="true"></i>
                        </a>
                        <?php }?>
                        <a href="javascript: excluirManutencao(<?= $manutencaop["codmanutencao"] ?>)" title="Clique aqui para excluir">
                            <img style="width: 20px;" src="../visao/recursos/img/excluir.png" alt="botão excluir"/>
                        </a>
                        
                        <a href="javascript: fotoManutencao(<?= $manutencaop["codmanutencao"] ?>)" title="Clique aqui para colocar fotos">
                            <img style="width: 20px;" src="../visao/recursos/img/foto.png" alt="botão foto"/>
                        </a>
                        <?php if($manutencaop["statusm"] != 3){?>
                        <a href="javascript: finalizarManutencao(<?= $manutencaop["codmanutencao"] ?>)" title="Clique aqui para finalizar O.S.">
                            <img style="width: 20px;" src="../visao/recursos/img/finalizar.jpg" alt="botão finalizar"/>
                        </a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
        <?php
    }

    ?>
    </div>