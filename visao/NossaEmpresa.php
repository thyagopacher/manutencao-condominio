<?php
include "validacaoLogin.php";
$sql = "select *
    from empresa where codempresa = '{$_SESSION["codempresa"]}'";
$empresap = $conexao->comandoArray($sql);
    
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
                            <?php include("formEmpresa.php"); ?>
                        </div>
                        
                        <span style="float: right; color: grey;width: 100%;text-align: right;">@ <?= ($sitep["nome"])?></span>                                  
                    </div>

                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <?php include "footer.php" ?>
        </div><!-- ./wrapper -->

        <?php include './javascriptFinal.php';?>
        <script type="text/javascript" src="./recursos/js/jquery.form.min.js"></script>
        <script type="text/javascript" src="./recursos/js/ajax/Empresa.js?123456"></script>
        <?php if(isset($_GET['procurar']) && $_GET['procurar'] != NULL && $_GET['procurar'] == "1"){?>
        <script>
            $("#tabs").tabs({active: 1});
            procurarEmpresa(true);
        </script>        
        <?php }?>        
    </body>
</html>
