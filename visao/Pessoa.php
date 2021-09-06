<?php

include "validacaoLogin.php";
if (isset($_GET["codpessoa"]) && $_GET["codpessoa"] != NULL && trim($_GET["codpessoa"]) != "") {
    $sql = "select *
        from pessoa where codpessoa = '{$_GET["codpessoa"]}'";
    $pessoap = $conexao->comandoArray($sql);
}
$action = "../control/SalvarPessoa.php";
?>  
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Gestão de Pessoas | Painel ADM.</title>
        <?php include 'head.php';?>
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
                            <?php include("formPessoa.php"); ?>
                        </div>
                        <?php if ($nivelp["procurar"] == 1 || $_SESSION["codnivel"] == '1') { ?>
                            <div id="tabs-2">
                                <?php include("formProcurarPessoa.php"); ?>
                            </div>
                        <?php } ?>

                        <span style="float: right; color: grey;width: 100%;text-align: right;">@ <?= ($empresap["razao"])?></span>                            
                    </div>

                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <?php include "footer.php" ?>
        </div><!-- ./wrapper -->

        <?php include './javascriptFinal.php';?>
        <script type="text/javascript" src="./recursos/js/jquery.form.min.js"></script>
        <script type="text/javascript" src="./recursos/js/ajax/Pessoa.js?123gs4fdwfhsdsdsdffd56"></script>
        <?php if(isset($_GET['procurar']) && $_GET['procurar'] != NULL && $_GET['procurar'] == "1"){?>
        <script>
            $("#tabs").tabs({active: 1});
            procurarPessoa(true);
        </script>        
        <?php }?> 
    </body>
</html>
