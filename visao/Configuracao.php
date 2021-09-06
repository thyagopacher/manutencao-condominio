<?php
include "validacaoLogin.php";

if (isset($_GET["codnivel"])) {
    $sql = "select * from nivel where codnivel = '{$_GET["codnivel"]}'";
    $nivel = $conexao->comandoArray($sql);
}

$titulo = "Salvar Configuração";
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include 'head.php'; ?>
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
                        </ul>   
                        <div id="tabs-1">
                            <?php include("formConfiguracao.php"); ?>
                        </div>

                        <span style="float: right; color: grey;width: 100%;text-align: right;">@ <?= ($empresap["razao"]) ?></span>                            
                    </div>
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <?php include "footer.php" ?>
        </div><!-- ./wrapper -->

        <?php include './javascriptFinal.php'; ?>
        <script src="/visao/recursos/js/ajax/Configuracao.js"></script>

    </body>
</html>
