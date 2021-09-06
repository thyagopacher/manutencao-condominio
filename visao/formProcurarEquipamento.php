<div class="row">
    <div class="box box-default">
        <div class="box-header with-border">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <form id="fPequipamento" name="fPequipamento" method="post" target="_blank" action="../control/ProcurarEquipamentoRelatorio.php">
                    <input type="hidden" name="tipo" id="tipo" value="<?=$_GET["tipo"]?>"/>
                    
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="nome">Nome Equipamento</label>
                            <select name="codequipamento" class="form-control selectpicker" data-live-search="true">
                                <?php
                                    $equipamento->optionEquipamento();
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php montaStatus();?>

                    <div class="col-md-3">                        
                        <div class="form-group">
                            <label for="nome">Periodo</label>
                            <select class="form-control" name="periodo">
                                <?php
                                echo '<option value="">--Selecione--</option>';
                                foreach ($equipamento->array_periodo as $key => $periodo) {
                                    echo '<option value="', $key, '">', $periodo, '</option>';
                                }
                                ?>
                            </select> 
                        </div>
                    </div>
                    <div class="col-md-3">                        
                        <div class="form-group">
                            <label for="codpatrimonio">N° de identificação</label>
                            <input type='text' class="form-control" name="codpatrimonio" id="codpatrimonio" placeholder="Digite cod. patrimonio" value="">
                        </div>
                    </div>
                    <div class="col-md-3">                        
                        <div class="form-group">
                            <label for="codpatrimonio">QR CODE</label>
                            <input type='text' class="form-control" name="qrcode" id="qrcode" placeholder="Digite QRCode" value="">
                        </div>
                    </div>                       
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="tipo">Fornecedor</label>
                            <select class="form-control" required name="codfornecedor" id="codfornecedor">
                                <?php
                                $executor->optionExecutor('f');
                                ?>
                            </select>
                        </div>
                    </div>    
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="tipo">Executor Manutenção</label>
                            <select class="form-control" required name="codexecutor" id="codexecutor">
                                <?php
                                $executor->optionExecutor('e');
                                ?>                                  
                            </select>
                        </div>
                    </div>     
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="tipo">Localização</label>
                            <select class="form-control" required name="codlocal" id="codlocal">
                                <?php
                                $reslocal = $conexao->comando("select codlocal, nome from localequipamento where codempresa = {$_SESSION["codempresa"]} order by nome");
                                $qtdlocal = $conexao->qtdResultado($reslocal);
                                if ($qtdlocal > 0) {
                                    echo ' <option value="">--Selecione--</option>';
                                    while ($local = $conexao->resultadoArray($reslocal)) {
                                        echo ' <option value="', $local["codlocal"], '">', $local["nome"], '</option>';
                                    }
                                }
                                ?>                                
                            </select>
                        </div>
                    </div>                     

                    <div class="col-md-12">
                        <div class="form-group">
                            <?php
                                if(isset($nivelp["procurar"]) && $nivelp["procurar"] == 1){
                                    echo '<button class="btn btn-primary" type="button" onclick="procurarEquipamento(false)"><i class="fa fa-search" aria-hidden="true"></i> Procurar</button> ';
                                }
                                if(isset($nivelp["gerapdf"]) && $nivelp["gerapdf"] == 1){
                                    echo '<button class="btn btn-primary" type="button" onclick="abreRelatorioEquipamento()"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Gerar PDF</button> ';
                                }
                                if(isset($nivelp["geraexcel"]) && $nivelp["geraexcel"] == 1){
                                    echo '<button class="btn btn-primary" type="button" onclick="abreRelatorioEquipamento2()"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Gerar Excel</button> ';
                                }
                            ?>
                        
                        </div>                                        
                    </div>                     
                </form>
            </div>
            <div class="row">
                <div id="listagemEquipamento" class="col-md-12"></div>
            </div>
        </div>
    </div>
    <!--/.col (right) -->
</div>