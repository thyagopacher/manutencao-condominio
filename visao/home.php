<?php
$menos6MesesBrasil = date('d/m/Y', strtotime('-6 months'));

$hojeBrasil = date("d/m/Y");
include './validacaoLogin.php';

$sql = "select SQL_CACHE count(1) as qtd from manutencao where codempresa = {$_SESSION["codempresa"]} and data >= {$menos6MesesBrasil}";
$totalGeralFinal = $conexao->comandoArray($sql);

$sql = "select SQL_CACHE count(1) as qtd from manutencao where codempresa = {$_SESSION["codempresa"]} and data >= {$menos6MesesBrasil}";
$totalGeral = $conexao->comandoArray($sql);

$sql = "select SQL_CACHE count(1) as qtd from manutencao where codempresa = {$_SESSION["codempresa"]} and codstatus = 1 and data >= {$menos6MesesBrasil}";
$totalAberta = $conexao->comandoArray($sql);

$sql = "select SQL_CACHE count(1) as qtd from manutencao where codempresa = {$_SESSION["codempresa"]} and codstatus = 4 and data >= {$menos6MesesBrasil}";
$totalEmAndamento = $conexao->comandoArray($sql);

$sql = "select SQL_CACHE count(1) as qtd from manutencao where codempresa = {$_SESSION["codempresa"]} and codstatus = 5 and data >= {$menos6MesesBrasil}";
$totalPendente = $conexao->comandoArray($sql);

$sql = "select SQL_CACHE count(1) as qtd from manutencao where codempresa = {$_SESSION["codempresa"]} and codstatus = 3 and data >= {$menos6MesesBrasil}";
$totalFinalizada = $conexao->comandoArray($sql);

$array_ultimos6meses = array();

trocaMes(date('m', strtotime("-6 months")));
for ($i = 6; $i >= 0; $i--) {
    $mes = date('m', strtotime("-$i months"));
    $array_ultimos6meses[] = '"' . trocaMes($mes) . '"';
}
?>
<!DOCTYPE html>
<html> 
    <head>
        <title>GestCCon | Painel</title>
        <?php include 'head.php'; ?>
    </script>    
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include 'header.php'; ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php include "menu.php"; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Dashboard
                    <small>Painel de controle</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                            <div class="info-box-content">

                                <span class="info-box-text">ABERTO</span>
                                <span class="info-box-number">
                                    <a href='RelManutencao.php?data1=<?= date("Y-m-d") ?>'>
                                        <?= $totalAberta["qtd"] ?>
                                    </a>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-red"><i class="ion ion-ios-gear-outline"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">PENDENTE</span>
                                <span class="info-box-number">
                                    <a href='RelManutencao.php?data2=<?= ONTEM ?>'>
                                        <?= $totalPendente["qtd"] ?>
                                    </a>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix visible-sm-block"></div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-gear-outline"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">EM ANDAMENTO</span>
                                <span class="info-box-number">
                                    <a href='RelManutencao.php?status=n3'>
                                        <?= $totalEmAndamento["qtd"] ?>    
                                    </a>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-green"><i class="ion ion-ios-gear-outline"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">FINALIZADO</span>
                                <span class="info-box-number">
                                    <a href='RelManutencao.php?status=3'>
                                        <?= $totalFinalizada["qtd"] ?>
                                    </a>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title negrito">Status Outras Manutenções</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="chart-responsive">
                                            <canvas id="pieChartServico" height="160" width="257" style="width: 257px; height: 160px;"></canvas>
                                        </div>
                                        <!-- ./chart-responsive -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-4">
                                        <ul class="chart-legend clearfix">
                                            <li>
                                                <a style="cursor: pointer;" target="_blank" href="/visao/Servico.php?codservico="<?= $servico["codservico"] ?>">
                                                    <i class="fa fa-circle-o text-agua"></i> <?= ($totalGeralFinal["qtd"] - $totalAberta["qtd"]) / 100 ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a style="cursor: pointer;" target="_blank" href="/visao/Servico.php?codservico="<?= $servico["codservico"] ?>">
                                                    <i class="fa fa-circle-o text-red"></i> <?= ($totalGeralFinal["qtd"] - $totalPendente["qtd"]) / 100 ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a style="cursor: pointer;" target="_blank" href="/visao/Servico.php?codservico="<?= $servico["codservico"] ?>">
                                                    <i class="fa fa-circle-o text-orange"></i> <?= ($totalGeralFinal["qtd"] - $totalEmAndamento["qtd"]) / 100 ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a style="cursor: pointer;" target="_blank" href="/visao/Servico.php?codservico="<?= $servico["codservico"] ?>">
                                                    <i class="fa fa-circle-o text-green"></i> <?= ($totalGeralFinal["qtd"] - $totalFinalizada["qtd"]) / 100 ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title negrito">Status Manutenção Equipamento</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="chart-responsive">
                                            <canvas id="pieChartServico" height="160" width="257" style="width: 257px; height: 160px;"></canvas>
                                        </div>
                                        <!-- ./chart-responsive -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-4">
                                        <ul class="chart-legend clearfix">
                                            <li>
                                                <a style="cursor: pointer;" target="_blank" href="/visao/Servico.php?codservico="<?= $servico["codservico"] ?>">
                                                    <i class="fa fa-circle-o text-agua"></i> <?= ($totalGeralFinal["qtd"] - $totalAberta["qtd"]) / 100 ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a style="cursor: pointer;" target="_blank" href="/visao/Servico.php?codservico="<?= $servico["codservico"] ?>">
                                                    <i class="fa fa-circle-o text-red"></i> <?= ($totalGeralFinal["qtd"] - $totalPendente["qtd"]) / 100 ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a style="cursor: pointer;" target="_blank" href="/visao/Servico.php?codservico="<?= $servico["codservico"] ?>">
                                                    <i class="fa fa-circle-o text-orange"></i> <?= ($totalGeralFinal["qtd"] - $totalEmAndamento["qtd"]) / 100 ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a style="cursor: pointer;" target="_blank" href="/visao/Servico.php?codservico="<?= $servico["codservico"] ?>">
                                                    <i class="fa fa-circle-o text-green"></i> <?= ($totalGeralFinal["qtd"] - $totalFinalizada["qtd"]) / 100 ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title negrito">Outros Finalizados x Não Finalizados</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="chart-responsive">
                                            <canvas id="pieChartQtdEquipamento" height="160" width="257" style="width: 257px; height: 160px;"></canvas>
                                        </div>
                                        <!-- ./chart-responsive -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-4">
                                        <?php
                                        $qtd_equipamento_servico = array();
                                        $linhaEquipamento = 0;
                                        $sql = "select *
                                            from qtd_servico_equipamento
                                            where codempresa = {$_SESSION["codempresa"]}
                                            and tipo = 'c'   
                                            limit 10";
                                        $resequipamento = $conexao->comando($sql);
                                        $qtdequipamento = $conexao->qtdResultado($resequipamento);
                                        if ($qtdequipamento > 0) {
                                            $cores = array('red', 'green', 'yellow', 'aqua', 'light-blue',
                                                'black', 'danger', 'fuchsia', 'marron', 'orange');
                                            echo '<ul class="chart-legend clearfix">';
                                            while ($equipamento = $conexao->resultadoArray($resequipamento)) {
                                                $qtd_equipamento_servico[] = array('qtd' => $equipamento["qtd"], 'nome' => $equipamento["nome"]);
                                                echo '<li>';
                                                echo '<a style="cursor: pointer;" target="_blank" href="/visao/Equipamento.php?codequipamento=', $equipamento["codequipamento"], '">';
                                                echo '<i class="fa fa-circle-o text-', $cores[$linhaEquipamento], '"></i> ', $equipamento["nome"], ' - ', $equipamento["qtd"], ' qtd. serviços';
                                                echo '</a>';
                                                echo '</li>';
                                                $linhaEquipamento++;
                                            }
                                            echo '</ul>';
                                        }
                                        ?>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title negrito">Equipamentos Finalizados x Não Finalizados</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="chart">
                                    <canvas id="barChart" style="height: 230px; width: 595px;" height="230" width="595"></canvas>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title negrito">Outros Preventivo x Corretivo</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="chart-responsive">
                                            <canvas id="pieChartQtdEquipamento2" height="160" width="257" style="width: 257px; height: 160px;"></canvas>
                                        </div>
                                        <!-- ./chart-responsive -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-4">
                                        <?php
                                        $qtd_equipamento_servico = array();
                                        $linhaEquipamento = 0;
                                        $sql = "select *
                                            from qtd_servico_equipamento
                                            where codempresa = {$_SESSION["codempresa"]}
                                            and tipo = 'c'   
                                            limit 10";
                                        $resequipamento = $conexao->comando($sql);
                                        $qtdequipamento = $conexao->qtdResultado($resequipamento);
                                        if ($qtdequipamento > 0) {
                                            $cores = array('red', 'green', 'yellow', 'aqua', 'light-blue',
                                                'black', 'danger', 'fuchsia', 'marron', 'orange');
                                            echo '<ul class="chart-legend clearfix">';
                                            while ($equipamento = $conexao->resultadoArray($resequipamento)) {
                                                $qtd_equipamento_servico[] = array('qtd' => $equipamento["qtd"], 'nome' => $equipamento["nome"]);
                                                echo '<li>';
                                                echo '<a style="cursor: pointer;" target="_blank" href="/visao/Equipamento.php?codequipamento=', $equipamento["codequipamento"], '">';
                                                echo '<i class="fa fa-circle-o text-', $cores[$linhaEquipamento], '"></i> ', $equipamento["nome"], ' - ', $equipamento["qtd"], ' qtd. serviços';
                                                echo '</a>';
                                                echo '</li>';
                                                $linhaEquipamento++;
                                            }
                                            echo '</ul>';
                                        }
                                        ?>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title negrito">Equipamentos Preventivo x Corretivo</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="chart-responsive">
                                            <canvas id="pieChartQtdEquipamentoPreventivo" height="160" width="257" style="width: 257px; height: 160px;"></canvas>
                                        </div>
                                        <!-- ./chart-responsive -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-4">
                                        <?php
                                        $qtd_equipamento_servicop = array();
                                        $linhaEquipamentop = 0;
                                        $sql = "select *
                                            from qtd_servico_equipamento
                                            where codempresa = {$_SESSION["codempresa"]}
                                            and tipo = 'p'   
                                            limit 10";
                                        $resequipamentop = $conexao->comando($sql);
                                        $qtdequipamentop = $conexao->qtdResultado($resequipamentop);
                                        if ($qtdequipamentop > 0) {
                                            $coresp = array('red', 'green', 'yellow', 'aqua', 'light-blue',
                                                'black', 'danger', 'fuchsia', 'marron', 'orange');
                                            echo '<ul class="chart-legend clearfix">';
                                            while ($equipamentop = $conexao->resultadoArray($resequipamentop)) {
                                                $qtd_equipamento_servicop[] = array('qtd' => $equipamentop["qtd"], 'nome' => $equipamentop["nome"]);
                                                echo '<li>';
                                                echo '<a style="cursor: pointer;" target="_blank" href="/visao/Equipamento.php?codequipamento=', $equipamento["codequipamento"], '">';
                                                echo '<i class="fa fa-circle-o text-', $coresp[$linhaEquipamentop], '"></i> ', $equipamentop["nome"], ' - ', $equipamentop["qtd"], ' qtd. serviços';
                                                echo '</a>';
                                                echo '</li>';
                                                $linhaEquipamentop++;
                                            }
                                            echo '</ul>';
                                        }
                                        ?>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Left col -->
                    <div class="col-md-8">
                        <!-- MAP & BOX PANE -->

                        <!-- /.box -->
                        <div class="row">

                            <!-- /.col -->

                            <div class="col-md-12">
                                <!-- USERS LIST -->
                                <div class="box box-danger">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Acessos Recentes</h3>

                                        <div class="box-tools pull-right">
                                            <span class="label label-danger">Ultimos acessos</span>
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body no-padding">
                                        <ul class="users-list clearfix">
                                            <?php
                                            $sql = "select DATE_FORMAT(acesso.data, '%d/%m/%Y') as data2, acesso.hora, pessoa.nome, pessoa.imagem, acesso.data
                                                        from acesso
                                                        inner join pessoa on pessoa.codempresa = acesso.codempresa
                                                        where acesso.codempresa = {$_SESSION["codempresa"]}
                                                        and acesso.codacesso = (select max(codacesso) from acesso where codpessoa = pessoa.codpessoa and acesso.codempresa = {$_SESSION["codempresa"]})
                                                        order by acesso.data desc limit 8";

                                            $resmembro = $conexao->comando($sql);
                                            $qtdmembro = $conexao->qtdResultado($resmembro);
                                            if ($qtdmembro > 0) {
                                                while ($membro = $conexao->resultadoArray($resmembro)) {
                                                    ?>    
                                                    <li>
                                                        <?php
                                                        if (isset($membro["imagem"]) && $membro["imagem"] != NULL && $membro["imagem"] != "") {
                                                            echo '<img style="width: 128px; height: 128px;" src="' . LOCAL_ARQUIVO . $membro["imagem"] . '" alt="User Image">';
                                                        } else {
                                                            echo '<img src="./recursos/img/sem_imagem.png" alt="User Image">';
                                                        }
                                                        echo '<a class="users-list-name" href="#">' . $membro["nome"] . '</a>';
                                                        if ($membro["data2"] == date("d/m/Y")) {
                                                            echo '<span class="users-list-date">Hoje ', $membro["hora"], '</span>';
                                                        } else {
                                                            echo '<span class="users-list-date">' . date("d/m", strtotime($membro["data"])) . ' ', $membro["hora"], '</span>';
                                                        }
                                                        ?>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                        <!-- /.users-list -->
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer text-center">
                                        <a href="/visao/RelAcesso.php" class="uppercase">Ver Todos os Acessos</a>
                                    </div>
                                    <!-- /.box-footer -->
                                </div>
                                <!--/.box -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- TABLE: LATEST ORDERS -->
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Ultimas Manutenções</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table no-margin">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>Local</th>
                                                <th>Título</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "select DATE_FORMAT(manutencao.data, '%d/%m/%Y') as data2, manutencao.titulo, manutencao.codstatus, manutencao.local, statusmanutencao.nome as nomestatus
                                                        from manutencao
                                                        inner join statusmanutencao on statusmanutencao.codstatus = manutencao.codstatus
                                                        where manutencao.codempresa = {$_SESSION["codempresa"]}
                                                        order by manutencao.data desc limit 8";
                                            $resmanutencao = $conexao->comando($sql);
                                            $qtdmanutencao = $conexao->qtdResultado($resmanutencao);
                                            if ($qtdmanutencao > 0) {
                                                while ($manutencao = $conexao->resultadoArray($resmanutencao)) {
                                                    echo '<tr>';
                                                    echo '<td><a href="pages/examples/invoice.html">' . $manutencao["data2"] . '</a></td>';
                                                    echo '<td>' . $manutencao["local"] . '</td>';
                                                    echo '<td>' . $manutencao["titulo"] . '</td>';
                                                    switch ($manutencao["codstatus"]) {
                                                        case 1:
                                                            echo '<td><span class="label label-danger">' . $manutencao["nomestatus"] . '</span></td>';
                                                            break;
                                                        case 2:
                                                            echo '<td><span class="label label-default">' . $manutencao["nomestatus"] . '</span></td>';
                                                            break;
                                                        case 3:
                                                            echo '<td><span class="label label-success">' . $manutencao["nomestatus"] . '</span></td>';
                                                            break;
                                                        case 4:
                                                            echo '<td><span class="label label-warning>' . $manutencao["nomestatus"] . '</span></td>';
                                                            break;
                                                        case 5:
                                                            echo '<td><span class="label label-info">' . $manutencao["nomestatus"] . '</span></td>';
                                                            break;
                                                        case 6:
                                                            echo '<td><span class="label label-success">' . $manutencao["nomestatus"] . '</span></td>';
                                                            break;
                                                    }
                                                    echo '</tr>';
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer clearfix">
                                <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Alterar ordem</a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">Todas as manutenções</a>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->

                    <div class="col-md-4">

                        <!-- PRODUCT LIST -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Equipamentos Cadastrados</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <?php
                                $sql = "select DATE_FORMAT(dtcadastro, '%d/%m/%Y') as dtcadastro2, nome, descricao, imagem, codpatrimonio, periodo
                                                    from equipamento
                                                    where codempresa = {$_SESSION["codempresa"]}
                                                    order by dtcadastro desc limit 4";
                                $resequipamento = $conexao->comando($sql);
                                $qtdequipamento = $conexao->qtdResultado($resequipamento);
                                if ($qtdequipamento > 0) {
                                    echo '<ul class="products-list product-list-in-box">';
                                    while ($equipamento = $conexao->resultadoArray($resequipamento)) {
                                        ?>
                                        <li class="item">
                                            <div class="product-img">
                                                <?php
                                                if (isset($equipamento["imagem"]) && $equipamento["imagem"] != NULL && $equipamento["imagem"] != "") {
                                                    echo '<img style="width: 50px; height: 50px;" src="' . LOCAL_ARQUIVO . $equipamento["imagem"] . '" alt="Imagem equipamento">';
                                                } else {
                                                    echo '<img style="width: 50px; height: 50px;" src="/visao/recursos/img/sem_imagem.png" alt="Imagem equipamento">';
                                                }
                                                ?>                                                            
                                            </div>
                                            <div class="product-info">
                                                <a href="javascript:void(0)" class="product-title"><?= $equipamento["nome"] ?>
                                                    <?php
                                                    switch ($equipamento["periodo"]) {
                                                        case 1:
                                                            echo '<span class="label label-warning pull-right">' . $equipamento["codpatrimonio"] . '</span></a>';
                                                            break;
                                                        case 2:
                                                            echo '<span class="label label-info pull-right">' . $equipamento["codpatrimonio"] . '</span></a>';
                                                            break;
                                                        case 3:
                                                            echo '<span class="label label-success pull-right">' . $equipamento["codpatrimonio"] . '</span></a>';
                                                            break;
                                                        case 4:
                                                            echo '<span class="label label-danger pull-right">' . $equipamento["codpatrimonio"] . '</span></a>';
                                                            break;
                                                        case 5:
                                                            echo '<span class="label label-primary pull-right">' . $equipamento["codpatrimonio"] . '</span></a>';
                                                            break;
                                                    }
                                                    ?> 
                                                    <span class="product-description">
                                                        <?= $equipamento["descricao"] ?>
                                                    </span>
                                            </div>
                                        </li>                                        
                                        <?php
                                    }
                                    echo '</ul>';
                                }
                                ?>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer text-center">
                                <a href="/visao/Equipamento.php?procurar=1" class="uppercase">Todos Equipamentos</a>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>                    
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        <?php include 'footer.php'; ?>
    </div><!-- ./wrapper -->

    <?php include './javascriptFinal.php'; ?>
    <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="plugins/chartjs/Chart.min.js"></script>
    <script src="dist/js/pages/dashboard2.js?v=1"></script>        
    <script>
        var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
        var areaChart = new Chart(areaChartCanvas);

        var areaChartOptions = {
            //Boolean - If we should show the scale at all
            showScale: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: false,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - Whether the line is curved between points
            bezierCurve: true,
            //Number - Tension of the bezier curve between points
            bezierCurveTension: 0.3,
            //Boolean - Whether to show a dot for each point
            pointDot: false,
            //Number - Radius of each point dot in pixels
            pointDotRadius: 4,
            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth: 1,
            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius: 20,
            //Boolean - Whether to show a stroke for datasets
            datasetStroke: true,
            //Number - Pixel width of dataset stroke
            datasetStrokeWidth: 2,
            //Boolean - Whether to fill the dataset with a color
            datasetFill: true,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true
        };
        $.ajax({
            url: "../control/ProcurarManutencaoGrafico.php",
            type: "POST",
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {
                var corretivas = data[1];
                var preventivas = data.preventivas;
                lineChartOptions.datasetFill = true;//faz virar o gráfico em linha preenchida
                var areaChartData = {
                    labels: [<?= implode(', ', $array_ultimos6meses) ?>],
                    datasets: [
                        {
                            label: "Preventivas",
                            fillColor: "rgba(210, 214, 222, 1)",
                            strokeColor: "rgba(210, 214, 222, 1)",
                            pointColor: "rgba(210, 214, 222, 1)",
                            pointStrokeColor: "#c1c7d1",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(220,220,220,1)",
                            data: corretivas
                        },
                        {
                            label: "Corretivas",
                            fillColor: "rgba(60,141,188,0.9)",
                            strokeColor: "rgba(60,141,188,0.8)",
                            pointColor: "#3b8bba",
                            pointStrokeColor: "rgba(60,141,188,1)",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(60,141,188,1)",
                            data: preventivas
                        }
                    ]
                };
                areaChart.Line(areaChartData, areaChartOptions);
            }, error: function (jqXHR, textStatus, errorThrown) {
                swal("Erro", "Erro causado por:" + errorThrown, "error");
            }
        });

        /**montagem do gráfico de linhas*/
        var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
        var lineChart = new Chart(lineChartCanvas);
        var lineChartOptions = areaChartOptions;

        $.ajax({
            url: "../control/ProcurarManutencaoGraficoValor.php",
            type: "POST",
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {
                var gasto = data[1];
                var previsto = data.previsto;
                lineChartOptions.datasetFill = false;//faz virar o gráfico em linha
                var lineChartData = {
                    labels: [<?= implode(', ', $array_ultimos6meses) ?>],
                    datasets: [
                        {
                            label: "Gasto",
                            fillColor: "rgba(210, 214, 222, 1)",
                            strokeColor: "rgba(210, 214, 222, 1)",
                            pointColor: "rgba(210, 214, 222, 1)",
                            pointStrokeColor: "#c1c7d1",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(220,220,220,1)",
                            data: gasto
                        },
                        {
                            label: "Prevista",
                            fillColor: "rgba(60,141,188,0.9)",
                            strokeColor: "rgba(60,141,188,0.8)",
                            pointColor: "#3b8bba",
                            pointStrokeColor: "rgba(60,141,188,1)",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(60,141,188,1)",
                            data: previsto
                        }
                    ]
                };
                lineChart.Line(lineChartData, lineChartOptions);
            }, error: function (jqXHR, textStatus, errorThrown) {
                swal("Erro", "Erro causado por:" + errorThrown, "error");
            }
        });

        /**montagem gráfico pizza 3*/
        var pieChartCanvas = $("#pieChartServico").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        var pieOptions = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke: true,
            //String - The colour of each segment stroke
            segmentStrokeColor: "#fff",
            //Number - The width of each segment stroke
            segmentStrokeWidth: 2,
            //Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 50, // This is 0 for Pie charts
            //Number - Amount of animation steps
            animationSteps: 100,
            //String - Animation easing effect
            animationEasing: "easeOutBounce",
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate: true,
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale: false,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };
        var PieData = [
            {
                value: <?= $qtd_servico_manutencao[0]["qtd"] ?>,
                color: "#f56954",
                highlight: "#f56954",
                label: "<?= $qtd_servico_manutencao[0]["nome"] ?>"
            },
            {
                value: <?= $qtd_servico_manutencao[1]["qtd"] ?>,
                color: "#00a65a",
                highlight: "#00a65a",
                label: "<?= $qtd_servico_manutencao[1]["nome"] ?>"
            },
            {
                value: <?= $qtd_servico_manutencao[2]["qtd"] ?>,
                color: "#f39c12",
                highlight: "#f39c12",
                label: "<?= $qtd_servico_manutencao[2]["nome"] ?>"
            },
            {
                value: <?= $qtd_servico_manutencao[3]["qtd"] ?>,
                color: "#00c0ef",
                highlight: "#00c0ef",
                label: "<?= $qtd_servico_manutencao[3]["nome"] ?>"
            },
            {
                value: <?= $qtd_servico_manutencao[4]["qtd"] ?>,
                color: "#3c8dbc",
                highlight: "#3c8dbc",
                label: "<?= $qtd_servico_manutencao[4]["nome"] ?>"
            },
            {
                value: <?= $qtd_servico_manutencao[5]["qtd"] ?>,
                color: "#111",
                highlight: "#111",
                label: "<?= $qtd_servico_manutencao[5]["nome"] ?>"
            },
            {
                value: <?= $qtd_servico_manutencao[6]["qtd"] ?>,
                color: "#a94442",
                highlight: "#a94442",
                label: "<?= $qtd_servico_manutencao[6]["nome"] ?>"
            },
            {
                value: <?= $qtd_servico_manutencao[7]["qtd"] ?>,
                color: "#f012be",
                highlight: "#f012be",
                label: "<?= $qtd_servico_manutencao[7]["nome"] ?>"
            },
            {
                value: <?= $qtd_servico_manutencao[8]["qtd"] ?>,
                color: "#333",
                highlight: "#333",
                label: "<?= $qtd_servico_manutencao[8]["nome"] ?>"
            },
            {
                value: <?= $qtd_servico_manutencao[9]["qtd"] ?>,
                color: "#ff851b",
                highlight: "#ff851b",
                label: "<?= $qtd_servico_manutencao[9]["nome"] ?>"
            }
        ];
        pieChart.Doughnut(PieData, pieOptions);

        /**montagem gráfico pizza 3*/
        var pieChartCanvas2 = $("#pieChartServicop").get(0).getContext("2d");
        var pieChart2 = new Chart(pieChartCanvas2);
        var pieOptions2 = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke: true,
            //String - The colour of each segment stroke
            segmentStrokeColor: "#fff",
            //Number - The width of each segment stroke
            segmentStrokeWidth: 2,
            //Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 50, // This is 0 for Pie charts
            //Number - Amount of animation steps
            animationSteps: 100,
            //String - Animation easing effect
            animationEasing: "easeOutBounce",
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate: true,
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale: false,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };
        var PieData2 = [
            {
                value: <?= $qtd_servico_manutencaop[0]["qtd"] ?>,
                color: "#f56954",
                highlight: "#f56954",
                label: "<?= $qtd_servico_manutencaop[0]["nome"] ?>"
            },
            {
                value: <?= $qtd_servico_manutencaop[1]["qtd"] ?>,
                color: "#00a65a",
                highlight: "#00a65a",
                label: "<?= $qtd_servico_manutencaop[1]["nome"] ?>"
            },
            {
                value: <?= $qtd_servico_manutencaop[2]["qtd"] ?>,
                color: "#f39c12",
                highlight: "#f39c12",
                label: "<?= $qtd_servico_manutencaop[2]["nome"] ?>"
            },
            {
                value: <?= $qtd_servico_manutencaop[3]["qtd"] ?>,
                color: "#00c0ef",
                highlight: "#00c0ef",
                label: "<?= $qtd_servico_manutencaop[3]["nome"] ?>"
            },
            {
                value: <?= $qtd_servico_manutencaop[4]["qtd"] ?>,
                color: "#3c8dbc",
                highlight: "#3c8dbc",
                label: "<?= $qtd_servico_manutencaop[4]["nome"] ?>"
            },
            {
                value: <?= $qtd_servico_manutencaop[5]["qtd"] ?>,
                color: "#111",
                highlight: "#111",
                label: "<?= $qtd_servico_manutencaop[5]["nome"] ?>"
            },
            {
                value: <?= $qtd_servico_manutencaop[6]["qtd"] ?>,
                color: "#a94442",
                highlight: "#a94442",
                label: "<?= $qtd_servico_manutencaop[6]["nome"] ?>"
            },
            {
                value: <?= $qtd_servico_manutencaop[7]["qtd"] ?>,
                color: "#f012be",
                highlight: "#f012be",
                label: "<?= $qtd_servico_manutencaop[7]["nome"] ?>"
            },
            {
                value: <?= $qtd_servico_manutencaop[8]["qtd"] ?>,
                color: "#333",
                highlight: "#333",
                label: "<?= $qtd_servico_manutencaop[8]["nome"] ?>"
            },
            {
                value: <?= $qtd_servico_manutencaop[9]["qtd"] ?>,
                color: "#ff851b",
                highlight: "#ff851b",
                label: "<?= $qtd_servico_manutencaop[9]["nome"] ?>"
            }
        ];
        pieChart2.Doughnut(PieData2, pieOptions2);




        /**montagem gráfico pizza 3*/
        var pieChartCanvas3 = $("#pieChartQtdEquipamento").get(0).getContext("2d");
        var pieChart3 = new Chart(pieChartCanvas3);
        var pieOptions3 = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke: true,
            //String - The colour of each segment stroke
            segmentStrokeColor: "#fff",
            //Number - The width of each segment stroke
            segmentStrokeWidth: 2,
            //Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 50, // This is 0 for Pie charts
            //Number - Amount of animation steps
            animationSteps: 100,
            //String - Animation easing effect
            animationEasing: "easeOutBounce",
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate: true,
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale: false,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };
        var PieData3 = [
            {
                value: <?= $qtd_equipamento_servico[0]["qtd"] ?>,
                color: "#f56954",
                highlight: "#f56954",
                label: "<?= $qtd_equipamento_servico[0]["nome"] ?>"
            },
            {
                value: <?= $qtd_equipamento_servico[1]["qtd"] ?>,
                color: "#00a65a",
                highlight: "#00a65a",
                label: "<?= $qtd_equipamento_servico[1]["nome"] ?>"
            },
            {
                value: <?= $qtd_equipamento_servico[2]["qtd"] ?>,
                color: "#f39c12",
                highlight: "#f39c12",
                label: "<?= $qtd_equipamento_servico[2]["nome"] ?>"
            },
            {
                value: <?= $qtd_equipamento_servico[3]["qtd"] ?>,
                color: "#00c0ef",
                highlight: "#00c0ef",
                label: "<?= $qtd_equipamento_servico[3]["nome"] ?>"
            },
            {
                value: <?= $qtd_equipamento_servico[4]["qtd"] ?>,
                color: "#3c8dbc",
                highlight: "#3c8dbc",
                label: "<?= $qtd_equipamento_servico[4]["nome"] ?>"
            },
            {
                value: <?= $qtd_equipamento_servico[5]["qtd"] ?>,
                color: "#111",
                highlight: "#111",
                label: "<?= $qtd_equipamento_servico[5]["nome"] ?>"
            },
            {
                value: <?= $qtd_equipamento_servico[6]["qtd"] ?>,
                color: "#a94442",
                highlight: "#a94442",
                label: "<?= $qtd_equipamento_servico[6]["nome"] ?>"
            },
            {
                value: <?= $qtd_equipamento_servico[7]["qtd"] ?>,
                color: "#f012be",
                highlight: "#f012be",
                label: "<?= $qtd_equipamento_servico[7]["nome"] ?>"
            },
            {
                value: <?= $qtd_equipamento_servico[8]["qtd"] ?>,
                color: "#333",
                highlight: "#333",
                label: "<?= $qtd_equipamento_servico[8]["nome"] ?>"
            },
            {
                value: <?= $qtd_equipamento_servico[9]["qtd"] ?>,
                color: "#ff851b",
                highlight: "#ff851b",
                label: "<?= $qtd_equipamento_servico[9]["nome"] ?>"
            }
        ];
        pieChart3.Doughnut(PieData3, pieOptions3);

        var barChartCanvas = $("#barChart").get(0).getContext("2d");
        var barChart = new Chart(barChartCanvas);
        var barChartData = areaChartData;
        barChartData.datasets[1].fillColor = "#00a65a";
        barChartData.datasets[1].strokeColor = "#00a65a";
        barChartData.datasets[1].pointColor = "#00a65a";
        var barChartOptions = {
            //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
            scaleBeginAtZero: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: true,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - If there is a stroke on each bar
            barShowStroke: true,
            //Number - Pixel width of the bar stroke
            barStrokeWidth: 2,
            //Number - Spacing between each of the X value sets
            barValueSpacing: 5,
            //Number - Spacing between data sets within X values
            barDatasetSpacing: 1,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
            //Boolean - whether to make the chart responsive
            responsive: true,
            maintainAspectRatio: true
        };

        barChartOptions.datasetFill = false;
        barChart.Bar(barChartData, barChartOptions);

    </script>
    <?php

    function trocaMes($mes) {
        $array_mes = array("01" => "Janeiro", "02" => "Fevereiro", "03" => "Março",
            "04" => "Abril", "05" => "Maio", "06" => "Junho", "07" => "Julho", "08" => "Agosto",
            "09" => "Setembro", "10" => "Outubro", "11" => "Novembro", "12" => "Dezembro");
        return $array_mes[$mes];
    }

    function validaArray($array, $tipo) {
        if (isset($array) && $array != NULL && $tipo == "qtd") {
            return $array["qtd"];
        } elseif ($tipo == "qtd") {
            return 0;
        }

        if (isset($array) && $array != NULL && $tipo == "nome") {
            return $array["nome"];
        } elseif ($tipo == "nome") {
            return '';
        }
    }
    ?>
</body>
</html>
