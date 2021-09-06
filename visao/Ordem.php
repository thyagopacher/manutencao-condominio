<?php

$titulo = "Ordem de Serviço";
include "validacaoLogin.php";
$equipamento = new Equipamento($conexao);
$executor = new Executor($conexao);
$pessoa = new Pessoa($conexao);
$manutencao = new Manutencao($conexao);
$status = new StatusManutencao($conexao);
$servico = new Servico($conexao);
$local = new LocalEquipamento($conexao);

if(isset($_GET["codmanutencao"]) && $_GET["codmanutencao"] != NULL && $_GET["codmanutencao"] != ""){
    $sql = "select manutencao.*, equipamento.codlocal, equipamento.codexecutor, manutencao.codservico
    from manutencao
    inner join equipamento on equipamento.codequipamento = manutencao.codequipamento and equipamento.codempresa = manutencao.codempresa
    where manutencao.codempresa = {$_SESSION["codempresa"]} 
    and manutencao.codmanutencao = {$_GET["codmanutencao"]}";
    $manutencaop = $conexao->comandoArray($sql);
}
?>  
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include 'head.php'; ?>
        <link rel="stylesheet" href="/visao/recursos/css/bootstrap-select.min.css">
    </head>
    <body class="hold-transition skin-blue sidebar-mini">

        <div class="wrapper">

            <?php include "header.php"; ?>
            <?php include "menu.php"; ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?= $titulo ?>

                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#"><?= $nivelp["modulo"] ?></a></li>
                        <li class="active"><?= $nivelp["pagina"] ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div id="tabs">
                        <ul>
                            <?php if(isset($_GET["codmanutencao"]) && $_GET["codmanutencao"] != NULL && $_GET["codmanutencao"] != ""){?>
                            <li><a href="#tabs-1">Cadastro</a></li>
                            <?php }?>
                            <?php if ($nivelp["procurar"] == 1 || $_SESSION["codnivel"] == '1') { ?>
                                <li><a href="#tabs-2">Relatório</a></li>
                            <?php } ?>

                        </ul>   
                        <?php if(isset($_GET["codmanutencao"]) && $_GET["codmanutencao"] != NULL && $_GET["codmanutencao"] != ""){?>
                        <div id="tabs-1"><?php include("formManutencao.php"); ?></div>
                        <?php }?>
                        <div id="tabs-2"><?php include("formProcurarManutencao.php"); ?></div>
                        <span style="float: right; color: grey;width: 100%;text-align: right;">@ <?= ($empresap["razao"]) ?></span>                            
                    </div>

                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <?php include "footer.php" ?>
        </div><!-- ./wrapper -->

        
        <?php include './javascriptFinal.php'; ?>
        
        <link rel="stylesheet" href="./recursos/css/jquery.dataTables.css"/>
        <link rel="stylesheet" href="./recursos/css/responsive.dataTables.min.css"/>
        <script type="text/javascript" src="./recursos/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="./recursos/js/dataTables.responsive.min.js"></script>        
        
        <script type="text/javascript" src="/visao/recursos/js/jquery.form.min.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/ajax/Manutencao.js?5essf4874d"></script>
        <script type="text/javascript" src="/visao/recursos/js/bootstrap-select.min.js"></script>
        <?php
            if(isset($_GET["codmanutencao"]) && $_GET["codmanutencao"] != NULL && $_GET["codmanutencao"] != ""){
                echo '<script>procurarManutencao(true)</script>';
            }
        ?>
    </body>
</html>
