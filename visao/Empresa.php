<?php

include "validacaoLogin.php";

if (isset($_GET["codempresa"]) && $_GET["codempresa"] != NULL && trim($_GET["codempresa"]) != "") {
    $sql = "select *
        from empresa where codempresa = '{$_GET["codempresa"]}'";
    $empresap = $conexao->comandoArray($sql);
}
    
$categoria = new CategoriaPessoa($conexao);
$nivel = new Nivel($conexao);
$empresa = new Empresa($conexao);
$status = new StatusEmpresa($conexao);
$titulo = "Gestão de Empresas";
?>  
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Gestão de Empresas | Painel ADM.</title>
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
                        <i class="fa fa-building" aria-hidden="true"></i>
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
                            <?php 
                            } 
                            if(isset($_GET["codempresa"]) && $_GET["codempresa"] != NULL && $_GET["codempresa"] != "" && $_SESSION["codnivel"] == 1){
                                echo '<li><a href="#tabs-3">Funcionário</a></li>';
                                echo '<li><a href="#tabs-4">Proc. Funcionário</a></li>';
                            }
                            ?>     
                        </ul>   
                        <div id="tabs-1">
                            <?php include("formEmpresa.php"); ?>
                        </div>
                        <?php if ($nivelp["procurar"] == 1 || $_SESSION["codnivel"] == '1') { ?>
                            <div id="tabs-2">
                                <?php include("formProcurarEmpresa.php"); ?>
                            </div>
                        <?php 
                        } 
                        if(isset($_GET["codempresa"]) && $_GET["codempresa"] != NULL && $_GET["codempresa"] != "" && $_SESSION["codnivel"] == 1){
                            echo '<div id="tabs-3">';
                            include("formPessoa.php");
                            echo '</div>';
                            echo '<div id="tabs-4">';
                            include("formProcurarPessoa.php");
                            echo '</div>';
                        }                        
                        ?>
                        
                        <span style="float: right; color: grey;width: 100%;text-align: right;">@ <?= ($sitep["nome"])?></span>                                  
                    </div>

                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <?php include "footer.php" ?>
        </div><!-- ./wrapper -->

        <?php include './javascriptFinal.php';?>
        <script type="text/javascript" src="./recursos/js/jquery.form.min.js"></script>
        <script type="text/javascript" src="./recursos/js/ajax/Empresa.js?1234556"></script>
        <?php if(isset($_GET['procurar']) && $_GET['procurar'] != NULL && $_GET['procurar'] == "1"){?>
        <script>
            $("#tabs").tabs({active: 1});
            procurarEmpresa(true);
        </script>        
        <?php }
        if(isset($_GET["codempresa"]) && $_GET["codempresa"] != NULL && $_GET["codempresa"] != "" && $_SESSION["codnivel"] == 1){
            echo '<script type="text/javascript" src="./recursos/js/ajax/Pessoa.js?1234ddgs5f6srefd"></script>';
        }
        ?>        
    </body>
</html>
