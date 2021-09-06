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
                <form id="fPmanutencao" name="fPmanutencao" method="post" target="_blank" action="../control/ProcurarManutencaoRelatorio.php">
                    <input type="hidden" name="tipoRel" id="tipoRel" value=""/>                    
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Equipamento</label>
                            <select name="codequipamento" id="codequipamento" class="form-control selectpicker" data-live-search="true">
                                <?php
                                    $equipamento->optionEquipamento();
                                ?>
                            </select>
                        </div>                             
                    </div> 
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Localização</label>
                            <select name="codlocal" id="codlocal" class="form-control selectpicker" data-live-search="true">
                                <?php
                                    $local->optionLocal();
                                ?>
                            </select>
                        </div>                             
                    </div> 
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Dt. inicio Agendamento</label>
                            <input type='date' class="form-control" name="data1" id="data1" value='<?=$_GET["data1"]?>' placeholder="dd/mm/aaaa">
                        </div>                             
                    </div> 
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Dt. fim Agendamento</label>
                            <input type='date' class="form-control" name="data2" id="data2" value='<?=$_GET["data2"]?>' placeholder="dd/mm/aaaa">
                        </div>                             
                    </div> 
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Fornecedor</label>
                            <select class="form-control" name="codfornecedor" id="codfornecedor">
                                <?php
                                    $executor->optionExecutor('f');
                                ?>
                            </select>
                        </div>                             
                    </div> 
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Executor</label>
                            <select class="form-control" name="codexecutor" id="codexecutor">
                                <?php
                                    $executor->optionExecutor('e');
                                ?>
                            </select>
                        </div>                             
                    </div> 
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Tipo</label>
                            <select class="form-control" name="tipo" id="tipo">
                                <?php $executor->optionTipos();?>
                            </select>
                        </div>                             
                    </div> 
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control selectpicker" name="status[]" id="status" multiple data-selected-text-format="count > 3">
                                <?php $status->optionStatus($_GET["status"]);?>
                            </select>
                        </div>                             
                    </div> 
                    
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Agendado por</label>
                            <select name="por" id="por" class="form-control selectpicker" data-live-search="true">
                                <?php $pessoa->optionPessoa();?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-12">
                        <div class="form-group">
                            <button class="btn btn-primary" type="button" onclick="procurarManutencao(false)"><i class="fa fa-search" aria-hidden="true"></i> Procurar</button>
                            <button class="btn btn-primary" type="button" onclick="abreRelatorioManutencao(1)"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Gerar PDF</button>
                            <button class="btn btn-primary" type="button" onclick="abreRelatorioManutencao(2)"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Gerar Excel</button>
                        </div>                                        
                    </div>
                </form>
            </div>
            <div class="row">
                <div id="listagemManutencao" class="col-sm-12"></div>
            </div>
        </div>
    </div>
    <!--/.col (right) -->
</div>
