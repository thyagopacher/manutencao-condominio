<?php
include "validacaoLogin.php";
$equipamento = new Equipamento($conexao);
$executor = new Executor($conexao);
$status = new StatusManutencao($conexao);
$pessoa = new Pessoa($conexao);
$local = new LocalEquipamento($conexao);

if(isset($_GET["codmanutencao"]) && $_GET["codmanutencao"] != NULL && $_GET["codmanutencao"] != ""){
    $agendamentop = $conexao->comandoArray("select * from manutencao where codempresa = {$_SESSION["codempresa"]} and codmanutencao = {$_GET["codmanutencao"]}");
}
$servico = new Servico($conexao);
?>  
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include 'head.php'; ?>
        <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.min.css">
        <link rel="stylesheet" href="/visao/recursos/css/fullcalendar.print.css" media="print">
        <link rel="stylesheet" href="/visao/recursos/css/bootstrap-select.min.css">
    </head>
    <body class="hold-transition skin-blue sidebar-mini">

        <div class="wrapper">

            <?php
            include "header.php";
            include "menu.php";
            ?>

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
                            <li><a href="#tabs-1" class="nimprimir">Cadastro</a></li>
                            <?php if ($nivelp["procurar"] == 1 || $_SESSION["codnivel"] == '1') { ?>
                            <li><a href="#tabs-2" class="nimprimir">Procurar</a></li>
                            <?php } ?>

                        </ul>   
                        <div id="tabs-1">
                            <?php include("formAgendamento.php"); ?>
                        </div>
                        <?php if ($nivelp["procurar"] == 1 || $_SESSION["codnivel"] == '1') { ?>
                            <div id="tabs-2" class="nimprimir">
                                <?php include("formProcurarAgendamento.php"); ?>
                            </div>
                        <?php } ?>

                        <span class="nimprimir" style="float: right; color: grey;width: 100%;text-align: right;">@ GestCCon</span>                            
                    </div>

                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <?php include "footer.php" ?>
        </div><!-- ./wrapper -->

        <?php include './javascriptFinal.php'; ?>
        <script type="text/javascript" charset="UTF-8" src="./recursos/js/moment.min.js"></script>
        <script type="text/javascript" charset="UTF-8" src="./recursos/js/fullcalendar.min.js"></script>
        <script type="text/javascript" charset="UTF-8" src="./recursos/js/jquery.form.min.js"></script>
        <script type="text/javascript" charset="UTF-8" src="./recursos/js/jquery.printElement.min.js"></script>
        <script type="text/javascript" charset="UTF-8" src="./recursos/js/locale-all.js?12345678e9"></script>
        <script type="text/javascript" charset="UTF-8" src="./recursos/js/gcal.min.js"></script>        
        <script type="text/javascript" charset="UTF-8" src="./recursos/js/ajax/Agendamento.js?897498"></script>
        <script type="text/javascript" charset="UTF-8" src="./recursos/js/ajax/Manutencao.js?88e55rd3ddtwfs7ee4w7f"></script>
        <script type="text/javascript" charset="UTF-8" src="/visao/recursos/js/bootstrap-select.min.js?12s3456"></script>
        <?php 
        if(isset($_GET["codmanutencao"]) && $_GET["codmanutencao"] != NULL && $_GET["codmanutencao"] != ""){
            echo '<script>escolheEquipamento()</script>';
        }
        
        ?>
    </body>
</html>
