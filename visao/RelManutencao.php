<?php
$titulo = "Relatório de Manutenções";
include "validacaoLogin.php";
$equipamento = new Equipamento($conexao);
$executor = new Executor($conexao);
$pessoa = new Pessoa($conexao);
$status = new StatusManutencao($conexao);
$local = new LocalEquipamento($conexao);
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
                            <?php if ($nivelp["procurar"] == 1 || $_SESSION["codnivel"] == '1') { ?>
                                <li><a href="#tabs-1">Relatório</a></li>
                            <?php } ?>

                        </ul>   
                        <div id="tabs-1">
                            <?php include("formRelManutencao.php"); ?>
                        </div>
                        <span style="float: right; color: grey;width: 100%;text-align: right;">@ <?= ($empresap["razao"]) ?></span>                            
                    </div>

                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <?php include "footer.php" ?>
        </div><!-- ./wrapper -->

        <?php include './javascriptFinal.php'; ?>
        <script type="text/javascript" src="./recursos/js/ajax/Manutencao.js?12wdwgf6ddgfd3"></script>  
        <script type="text/javascript" src="/visao/recursos/js/bootstrap-select.min.js"></script>
        <?php
            if(isset($_GET)){
                echo '<script>procurarManutencao(true)</script>';
            }
        ?>
    </body>
</html>
