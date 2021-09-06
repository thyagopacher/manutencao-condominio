<?php

ob_start();
header('Content-type: text/html; charset=utf-8');
session_start();
//validação caso a sessão caia
if (!isset($_SESSION)) {
    die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
}

function __autoload($class_name) {
    if (file_exists("../model/" . $class_name . '.php')) {
        include "../model/" . $class_name . '.php';
    } elseif (file_exists("../visao/" . $class_name . '.php')) {
        include "../visao/" . $class_name . '.php';
    } elseif (file_exists("./" . $class_name . '.php')) {
        include "./" . $class_name . '.php';
    }
}

$conexao = new Conexao();
$empresa = new Empresa($conexao);
$executor = new Executor($conexao);
$local = new LocalEquipamento($conexao);
$manutencao = new Manutencao($conexao);

$manutencaop = $manutencao->procurarCodigo($_GET["codmanutencao"]);

$status = $conexao->comandoArray("select nome from statusmanutencao where codstatus = {$manutencaop["codstatus"]}");

$equipamento = new Equipamento($conexao, $manutencaop["codequipamento"]);
$equipamentop = $equipamento->procurarCodigo('nome, descricao, qrcode, periodo, codexecutor, codlocal, codpatrimonio');

$periodo = $equipamento->array_periodo[$equipamentop["periodo"]];

$empresap = $empresa->procurarCodigo('logo, razao, tipologradouro, logradouro, numero, cep, telefone, celular, email, cidade, uf, bairro');
$executor->codexecutor = $equipamentop["codexecutor"];
$executorp = $executor->procurarCodigo();

$localp = $local->procurarCodigo($equipamentop["codlocal"], 'nome, descricao1, descricao2, descricao3, imagem');

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Gestão de OS.</title>
        <?php include '../visao/head.php'; ?>
        <link rel="stylesheet" href="/visao/recursos/css/bootstrap.print.css" media="all">
        <style>

            /* Remove the navbar's default margin-bottom and rounded borders */ 
            .navbar {
                margin-bottom: 0;
                border-radius: 0;
            }

            /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
            .row.content {height: 450px}

            /* Set gray background color and 100% height */
            .sidenav {
                padding-top: 20px;
                background-color: #f1f1f1;
                height: 100%;
            }

            /* Set black background color, white text and some padding */
            footer {
                background-color: #555;
                color: white;
                padding: 15px;
            }

            /* On small screens, set height to 'auto' for sidenav and grid */
            @media screen and (max-width: 767px) {
                .sidenav {
                    height: auto;
                    padding: 15px;
                }
                .row.content {height:auto;} 
            }

            #logo{
                width: auto;
                height: 110px;
            }
            #nome_empresa{
                margin-top: 0;
            }
            h3{
                font-weight: bolder;
            }
            .borda-topo{
                border-top: 2px solid rgba(128, 128, 128, 0.72);
            }
            .borda-topo h4{
                font-weight: bolder;
            }

            .div_resposta{
                margin: 10px 0px 10px 0px;
            }
            #texto_codigo_barra{
                text-align: center;
                font-size: 20px;
                font-weight: bolder;
                margin-top: 0;
                padding-top: 0;                
            }
            #div_qrcode .thumbnail{
                border: initial;
            }
            #div_qrcode .caption{
                padding-top: 0;
            }
            @page {
                size: A4;
                margin: 0;
            }
            @media print {
                html, body {
                    width: 210mm;
                    height: 297mm;
                }
            }   
            #campo_final{
                margin-top: 22px;
                font-weight: initial;                
            }
            h4{
                float: left;
            }
            .textoDiv{
                height: 15px; 
                /*padding-top: 11px;*/
                line-height: 14px;
            }
            .tituloDiv{
                margin-top: -1px;
                line-height: 15px;
            }
        </style>
    </head>
    <body>
        <input type="hidden" id="codpatrimonioqr" value="<?= $equipamentop["qrcode"] ?>"/>
        <div class="container-fluid text-center">
            <br><br>
            <div class="row">
                <div class="col-sm-6">
                    <img id="logo" class="img-responsive" src="/arquivos/<?= $empresap["logo"] ?>" alt="logo OS empresa"/>
                </div>
                <div class="col-sm-6 text-left">
                    <h3 id="nome_empresa"><?= $empresap["razao"] ?></h3>
                    <p>
                        <?php
                        echo ucfirst($empresap["tipologradouro"]), ' ', ucfirst($empresap["logradouro"]), ', n° ', $empresap["numero"], '<br>';
                        echo ucfirst($empresap["bairro"]), ' - ', ucfirst($empresap["cidade"]), ' - ', strtoupper($empresap["uf"]), ' - Cep: ', $empresap["cep"], '<br>';
                        echo "Telefone(s): {$empresap["telefone"]} - {$empresap["celular"]}<br>";
                        echo "E-mail: {$empresap["email"]}";
                        ?>                        
                    </p>

                </div>
            </div>
        </div>    

        <div class="container-fluid text-center borda-topo">    
            <div class="row">
                <div class="col-sm-6 text-left">
                    <h4>O.S.: <?= $_GET["codmanutencao"] ?>/<?= date("Y") ?> - <?= $status["nome"] ?></h4> 
                </div>
                <div class="col-sm-6 text-right">
                    <h4>Data Registro: <?= date("d/m/Y", strtotime($manutencaop["dtcadastro"])); ?></h4> 
                </div>

            </div>
        </div>

        <div class="container-fluid text-center borda-topo">    
            <div class="row">
                <div class="col-sm-8 text-left">
                    <h3>EQUIPAMENTO:</h3>
                    <div class="row">
                        <h4 class="col-md-3 tituloDiv">NOME EQUIPAMENTO:</h4><div class="col-md-9 textoDiv"><?= $equipamentop["nome"] ?></div>
                    </div>
                    <?php
                        if(isset($equipamentop["codpatrimonio"]) && $equipamentop["codpatrimonio"]!= NULL && $equipamentop["codpatrimonio"] != ""){
                    ?>
                    <div class="row">
                        <h4 class="col-md-3 tituloDiv">N° IDENTIFICAÇÃO:</h4><div class="col-md-9 textoDiv"><?= $equipamentop["codpatrimonio"] ?></div>
                    </div>
                    <?php
                        }
                    ?>
                    <div class="row">
                        <h4 class="col-md-3 tituloDiv">PERIODO DE MANUTENÇÃO:</h4><div class="col-md-9 textoDiv"><?= $periodo ?></div>
                    </div>
                    <div class="row">
                        <h4 class="col-md-3 tituloDiv">MANUTENÇÃO PROGRAMADA PARA:</h4><div class="col-md-9 textoDiv"><?= date("d/m/Y", strtotime($manutencaop["data"])) ?></div>
                    </div>
                    <div class="row">
                        <h4 class="col-md-3 tituloDiv">OBSERVAÇÃO:</h4><div class="col-md-9 textoDiv"><?= $equipamentop["descricao"] ?></div>
                    </div>
                </div>
                <div id="div_qrcode" class="col-sm-4 text-left" style="margin-bottom: -20px;">
                    <div class="thumbnail">
                        <img style="height: 150px;" src="" alt="imagem qrcode gestccon" id="imgQrCode" class="img-responsive">
                        <div class="caption">
                            <p id="texto_codigo_barra"></p>
                        </div>
                    </div>                    
                </div>

            </div>
        </div>

        <div class="container-fluid text-center borda-topo">    
            <div class="row">
                <div class="col-sm-8 text-left">
                    <h3>LOCALIZAÇÃO:</h3>
                    <div class="row">
                        <h4 class="col-md-3 tituloDiv">NOME:</h4><div class="col-md-9 textoDiv"><?= $localp["nome"] ?></div>
                    </div>
                    <div class="row">
                        <h4 class="col-md-3 tituloDiv">DESCRIÇÃO 1:</h4><div class="col-md-9 textoDiv"><?= $localp["descricao1"] ?></div>
                    </div>
                    <?php
                        if(isset($localp["descricao2"]) && $localp["descricao2"]!= NULL && $localp["descricao2"] != ""){
                    ?>                    
                    <div class="row">
                        <h4 class="col-md-3 tituloDiv">DESCRIÇÃO 2:</h4><div class="col-md-9 textoDiv"><?= $localp["descricao2"] ?></div>
                    </div>
                    <?php 
                        }
                        if(isset($localp["descricao3"]) && $localp["descricao3"]!= NULL && $localp["descricao3"] != ""){
                    ?>
                    <div class="row">
                        <h4 class="col-md-3 tituloDiv">DESCRIÇÃO 3:</h4><div class="col-md-9 textoDiv"><?= $localp["descricao3"] ?></div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
                <div id="div_qrcode" class="col-sm-4 text-right">
                    <?php if (isset($localp["imagem"]) && $localp["imagem"] != NULL && $localp["imagem"] != "") { ?>
                        <img style="height: 130px; margin-top: 10px; margin-bottom: 10px;" src="/arquivos/<?= $localp["imagem"] ?>" alt="imagem local gestccon" class="img-responsive">
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="container-fluid text-center borda-topo">    
            <div class="row">
                <div class="col-sm-8 text-left">
                    <h3>EXECUTOR:</h3>
                    <?php
                        $titulo = "";
                        $execucao = "";
                        if($executorp["tipo"] == "e"){
                            $titulo = "RAZAO / CNPJ: ";
                            $execucao = $executorp["razao"]. " / ".$executorp["cnpj"];
                        }elseif($executorp["tipo"] == "p" || $executorp["tipo"] == "f"){
                            if(isset($executorp["cpf"]) && $executorp["cpf"] != NULL && $executorp["cpf"] != ""){
                                $titulo = "NOME / CPF: ";
                                $execucao = $executorp["nome"]. " / ".$executorp["cpf"];
                            }else{
                                $titulo = "NOME: ";
                                $execucao = $executorp["nome"];                                
                            }
                        }
                    ?>
                        <div class="row">
                            <h4 class="col-md-3 tituloDiv"><?= $titulo ?></h4>
                            <div class="col-md-9 textoDiv"><?= $execucao ?></div>
                        </div>
                    <?php
                        if(isset($executorp["cep"]) && $executorp["cep"] != NULL && $executorp["cep"] != ""){
                            $endereco = $executorp["logradouro"] . ' - ' . $executorp["bairro"] . ' - ' . $executorp["cidade"] . ' - ' . $executorp["uf"] . ' - ' . $executorp["cep"];
                            if(strlen($endereco) > 63){
                                $margin = 'style = "margin-bottom: 15px !important;"';
                            }else{
                                $margin = "";
                            }
                            echo '<div class="row">';
                            echo '<h4 class="col-md-3 tituloDiv" '.$margin.'>ENDEREÇO:</h4><div class="col-md-9 textoDiv">'.$endereco.'</div>';
                            echo'</div>';
                        }elseif(isset($executorp["cep_pessoa"]) && $executorp["cep_pessoa"] != NULL && $executorp["cep_pessoa"] != ""){
                            $endereco_pessoa = $executorp["logradouro_pessoa"] . ' - ' . $executorp["bairro_pessoa"] . ' - ' . $executorp["cidade_pessoa"] . ' - ' . $executorp["uf_pessoa"] . ' - ' . $executorp["cep_pessoa"];
                            if(strlen($endereco_pessoa) > 63){
                                $margin_pessoa = 'style = "margin-bottom: 15px !important;"';
                            }else{
                                $margin_pessoa = "";
                            }
                            echo '<div class="row">';
                            echo '<h4 class="col-md-3 tituloDiv" '.$margin_pessoa.'>ENDEREÇO:</h4><div class="col-md-9 textoDiv">'.$endereco_pessoa.'</div>';
                            echo'</div>';                            
                        }
                        $contato = "";
                        if($executorp["tipo"] == "e"){
                            $contato = 'CELULAR: ' . $executorp["celular"] . ' - FIXO:' . $executorp["telefone"];
                        }elseif($executorp["tipo"] == "p" || $executorp["tipo"] == "f"){
                            if(isset($executorp["telefone_pessoa"]) && $executorp["telefone_pessoa"] != NULL && $executorp["telefone_pessoa"] != ""){
                                $contato = 'CELULAR: ' . $executorp["celular_pessoa"] . ' - FIXO:' . $executorp["telefone_pessoa"];
                            }else{
                                $contato = 'CELULAR: ' . $executorp["celular_pessoa"];                                
                            }
                        }
                    ?>
                    <div class="row">
                        <h4 class="col-md-3 tituloDiv">CONTATOS:</h4><div class="col-md-9 textoDiv"><?= $contato ?></div>
                    </div>
                </div>
                <div id="div_qrcode" class="col-sm-4 text-right">
                    <?php if (isset($executorp["logo"]) && $executorp["logo"] != NULL && $executorp["logo"] != "") { ?>
                        <img style="height: 130px; margin-top: 10px; margin-bottom: 10px;" src="/arquivos/<?= $executorp["logo"] ?>" alt="imagem logo executor gestccon" class="img-responsive">
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="container-fluid text-center borda-topo">    
            <div class="row">
                <div class="col-sm-8 text-left">
                    <h3>SERVIÇOS (Imagem inicio manutençao):</h3>
                    <?php
                        $resservico = $conexao->comando("select codservico, nome, observacao  from servico where codservico in({$manutencaop["codservico"]}) and codempresa = {$_SESSION["codempresa"]}");
                        $qtdservico = $conexao->qtdResultado($resservico);
                        if($qtdservico > 0){   
                            $i = 1;
                    ?>
                    <div class="row">
                        <?php    
                            while($servicop = $conexao->resultadoArray($resservico)){
                                echo '<h4 class="col-md-3 tituloDiv">Serviço' .$i.':</h4>';
                                $servicos =  "{$servicop["nome"]} - {$servicop["observacao"]}; ";
                                $servicos2 = explode(';', $servicos);
                                foreach($servicos2 as $servico){
                                    echo '<div class="col-md-9 textoDiv">';
                                    echo $servico. "<br>";
                                    echo "</div>";
                                }
                                $i++;
                            }
                        ?>
                    </div> 
                    <?php
                        }
                    ?>
                </div>
                <div id="div_qrcode" class="col-sm-4 text-right">
                    <?php if (isset($manutencaop["imginicio"]) && $manutencaop["imginicio"] != NULL && $manutencaop["imginicio"] != "") { ?>
                        <img style="height: 130px; margin-top: 10px; margin-bottom: 10px;" src="/arquivos/<?= $manutencaop["imginicio"] ?>" alt="imagem inicio manutenção" class="img-responsive">
                        <!--<h4 style="text-align: initial;">Inicio Manutenção</h4>-->
                    <?php } ?>
                </div>                
            </div>
        </div>
    
        <?php
            $sql = "select codmanutencao, data, valor 
            from manutencao 
            where codequipamento = {$manutencaop["codequipamento"]} 
            and codmanutencao <> {$manutencaop["codmanutencao"]}
            and codempresa = {$_SESSION["codempresa"]} order by codmanutencao desc limit 1";
            $servicoAnterior = $conexao->comandoArray($sql);                    
            $separa_data = explode('-', $servicoAnterior["data"]);
            if(isset($servicoAnterior) && $servicoAnterior["codmanutencao"] != NULL && $servicoAnterior["codmanutencao"] != ""){
        ?>        

        <div class="container-fluid text-center borda-topo">    
            <div class="row">
                <div class="col-sm-12 text-left">
                    <h3>Valor gasto da última Ordem de Serviço nº <?= $servicoAnterior["codmanutencao"] . '/' . $separa_data[0] ?>: R$ <?= number_format($servicoAnterior["valor"], 2, ',', '.') ?></h3>
                </div>
            </div>
        </div>
        <?php } ?>
        
        <div class="container-fluid text-center borda-topo">    
            <div class="row">
                <div class="col-sm-8 text-left">
                    <div class="row">
                        <h3 class="col-md-2">Observações (Fim manutençao) :</h3>
                    </div>
                    <?php
                        if(isset($manutencaop["status"]) && $manutencaop["status"]!= NULL && $manutencaop["status"] != ""){
                    ?>
                    <div class="row">
                        <h4 class="col-md-3 tituloDiv">STATUS:</h4><div class="col-md-9 textoDiv"><?= $manutencaop["status"] ?></div>
                    </div>                 
                    <?php 
                        }                     
                        if(isset($manutencaop["material"]) && $manutencaop["material"]!= NULL && $manutencaop["material"] != ""){  
                            $material = $manutencaop["material"];
                            if(strlen($material) > 60){
                                $margin = 'style = "margin-bottom: 20px !important;"';
                            }else{
                                $margin = "";
                            }  
                    ?>
                    <div class="row">
                        <h4 class="col-md-3 tituloDiv" <?= $margin ?>>MATERIAL:</h4><div class="col-md-9 textoDiv"><?= $material ?></div>
                    </div>                 
                    <?php
                        }
                        if(isset($manutencaop["tempo_gasto"]) && $manutencaop["tempo_gasto"]!= NULL && $manutencaop["tempo_gasto"] != "" && $manutencaop["tempo_gasto"] != 0
                            && (isset($manutencaop["valor_gasto"]) && $manutencaop["valor_gasto"]!= NULL && $manutencaop["valor_gasto"] != "" && $manutencaop["valor_gasto"] != "0,00")){
                    ?>
                    <div class="row">
                        <h4 class="col-md-3 tituloDiv">TEMPO / VALOR GASTO :</h4><div class="col-md-9 textoDiv"><?= $manutencaop["tempo_gasto"]. " / R$".number_format($manutencaop["valor_gasto"], 2, ',', '.')?></div>
                    </div>
                    <?php 
                        } 
                        if(isset($manutencaop["codservico"]) && $manutencaop["codservico"]!= NULL && $manutencaop["codservico"] != ""){  
                    ?>
                    <?php
                        }
                        if(isset($manutencaop["pendencias"]) && $manutencaop["pendencias"]!= NULL && $manutencaop["pendencias"] != ""){
                            $pendencia = $manutencaop["pendencias"];
                            if(strlen($pendencia) > 60){
                                $margin = 'style = "margin-bottom: 20px !important;"';
                            }else{
                                $margin = "";
                            }                    
                    ?>
                    <div class="row">
                        <h4 class="col-md-3 tituloDiv" <?= $margin ?>>PENDÊNCIAS:</h4><div class="col-md-9 textoDiv"><?= $pendencia ?></div>
                    </div>
                    <?php 
                        }
                        if(isset($manutencaop["demais_observacoes"]) && $manutencaop["demais_observacoes"]!= NULL && $manutencaop["demais_observacoes"] != ""){  
                            $observacoes = $manutencaop["demais_observacoes"];
                            if(strlen($observacoes) > 60){
                                $margin = 'style = "margin-bottom: 20px !important;"';
                            }else{
                                $margin = "";
                            }                     
                    ?>
                    <div class="row">
                        <h4 class="col-md-3 tituloDiv" <?= $margin ?>>OBSERVAÇÕES:</h4><div class="col-md-9 textoDiv"><?= $observacoes ?></div>
                    </div>
                    <?php
                        }if(isset($manutencaop["dtfinalizacao"]) && $manutencaop["dtfinalizacao"]!= NULL && $manutencaop["dtfinalizacao"] != "" && $manutencaop["dtfinalizacao"] != "0000-00-00 00:00:00"){
                    ?> 
                    <div class="row">
                        <h3 class="col-md-3 tituloDiv">DATA DE TÉRMINO: <?= date("d/m/Y", strtotime($manutencaop["dtfinalizacao"])); ?></h3>
                    </div>
                    <?php 
                        }
                    ?>
                </div>
                <div id="div_qrcode" class="col-sm-4 text-right">
                    <?php if (isset($manutencaop["imgfim"]) && $manutencaop["imgfim"] != NULL && $manutencaop["imgfim"] != "") { ?>
                        <img style="height: 130px; margin-top: 10px; margin-bottom: 10px;" src="/arquivos/<?= $manutencaop["imgfim"] ?>" alt="imagem fim manutenção" class="img-responsive">
                        <!--<h4 style="text-align: initial;">Fim Manutenção</h4>-->
                    <?php } ?>
                        
                </div>                  
            </div>
        </div>


        <?php include '../visao/javascriptFinal.php'; ?>
        <script type="text/javascript">
            var imgres = criarQRCODE($("#codpatrimonioqr").val(), 350);
            $("#imgQrCode").prop("src", imgres);
            $("#texto_codigo_barra").append($("#codpatrimonioqr").val());
        </script>
    </body>
</html>
<?php
$html = ob_get_clean();
echo preg_replace('/\s+/', ' ', $html);


