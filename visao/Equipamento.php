<?php

include "validacaoLogin.php";
$titulo = "Gestão de Equipamento";
$executor = new Executor($conexao);
$servico = new Servico($conexao);
$equipamento = new Equipamento($conexao);
if (isset($_GET["codequipamento"]) && $_GET["codequipamento"] != NULL && trim($_GET["codequipamento"]) != "") {
    $equipamentop = $conexao->comandoArray("select * from equipamento where codequipamento = {$_GET["codequipamento"]}");
}
?>  
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include 'head.php'; ?>
        <style>
            #div_qrcode div{
                text-align: center;
                width: 20%;
                margin-left: 50px;
                font-weight: bolder;                
            }
        </style>
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
                            <li><a href="#tabs-1">Cadastro</a></li>
                            <?php if ($nivelp["procurar"] == 1 || $_SESSION["codnivel"] == '1') { ?>
                                <li><a href="#tabs-2">Procurar</a></li>
                            <?php } ?>

                        </ul>   
                        <div id="tabs-1">
                            <?php include("formEquipamento.php"); ?>
                        </div>
                        <?php if ($nivelp["procurar"] == 1 || $_SESSION["codnivel"] == '1') { ?>
                            <div id="tabs-2">
                                <?php include("formProcurarEquipamento.php"); ?>
                            </div>
                        <?php } ?>

                        <span style="float: right; color: grey;width: 100%;text-align: right;">@ GestCCon</span>                            
                    </div>

                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <?php include "footer.php" ?>
        </div><!-- ./wrapper -->
        
        <?php include './javascriptFinal.php'; ?>
        <script type="text/javascript" src="./recursos/js/jquery.form.min.js"></script>
        <script type="text/javascript" src="./recursos/js/ajax/Equipamento.js?<?= date("YmdHis") ?>"></script>
        <?php
            if(isset($_GET["procurar"]) && $_GET["procurar"] != NULL && $_GET["procurar"] == "1"){
                echo "<script>$('#tabs').tabs({active: 1});procurarEquipamento(true)</script>";
            }
        ?>
        <script type="text/javascript" charset="UTF-8" src="/visao/recursos/js/bootstrap-select.min.js?12s3456"></script>
    </body>
</html>
