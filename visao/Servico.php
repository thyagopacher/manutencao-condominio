<?php
include "validacaoLogin.php";
if (isset($_GET["codservico"]) && $_GET["codservico"] != NULL && trim($_GET["codservico"]) != "") {
    $sql = "select *
        from servico where codservico = " .$_GET["codservico"];
    $servicop = $conexao->comandoArray($sql);
}

$action = "../control/SalvarServico.php";
$array_periodo = array('1' => 'Diário', '2' => 'Semanal', '3' => 'Mensal', '4' => 'Anual', '5' => 'Dias não sequenciais');
?>  
<!DOCTYPE html>
<html lang="pt-br">
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
<?php if ($nivelp["procurar"] == 1 || $_SESSION["codnivel"] == '1') { ?>
                                <li><a href="#tabs-2">Procurar</a></li>
                            <?php } ?>

                        </ul>   
                        <div id="tabs-1">
<?php include("formServico.php"); ?>
                        </div>
                            <?php if ($nivelp["procurar"] == 1 || $_SESSION["codnivel"] == '1') { ?>
                            <div id="tabs-2">
                            <?php include("formProcurarServico.php"); ?>
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
        <script type="text/javascript" src="./recursos/js/ajax/Servico.js?"></script>
    </body>
</html>
