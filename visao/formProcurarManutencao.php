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
                <form method="post" action="../control/ProcurarManutencaoRelatorio.php" name="fPmanutencao" id="fPmanutencao" onsubmit="return false;" target="_blank">
                    <input type="hidden" name="tipoRel" id="tipoRel" value="pdf"/>
                    <input type="hidden" name="codpagina" id="codpagina" value="<?= $nivelp["codpagina"] ?>"/>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nome">Dt. Inicio Cadastro</label>
                            <input type="date" class="form-control" name="data1" id="data1" value='<?= $_GET["data1"] ?>' title="Digite data de inicio onde foi feito o cadastro">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nome">Dt. Fim Cadastro</label>
                            <input type="date" class="form-control" name="data2" id="data2" value='<?= $_GET["data2"] ?>' title="Digite data de fim onde foi feito o cadastro">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Dt. inicio Agend.</label>
                            <input type='date' class="form-control" name="data3" id="data3" value='<?= $_GET["data3"] ?>' placeholder="dd/mm/aaaa">
                        </div>                             
                    </div> 
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Dt. fim Agend.</label>
                            <input type='date' class="form-control" name="data4" id="data4" value='<?= $_GET["data4"] ?>' placeholder="dd/mm/aaaa">
                        </div>                             
                    </div>                     
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Equipamento</label>
                            <select class="form-control" name="codequipamento" id="codequipamento">
                                <?php
                                $equipamento->optionEquipamento();
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Registro por</label>
                            <select class="form-control" name="por" id="por">
                                <?php
                                $pessoa->optionPessoa();
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">                        
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control selectpicker" name="status[]" id="status" multiple data-selected-text-format="count > 3">
                                <?php $status->optionStatus($_GET["status"], true); ?>
                            </select>
                        </div>
                    </div>                    
                    <div class="col-md-3">                        
                        <div class="form-group">
                            <label>Tipo</label>
                            <select required class="form-control" name="tipo" id="tipo">
                                <?php
                                if (count($manutencao->array_tipos) > 0) {
                                    echo "<option value=''>--Selecione--</option>";
                                    foreach ($manutencao->array_tipos as $key => $tipo) {
                                        echo "<option value='$key'>$tipo</option>";
                                    }
                                }else{
                                    echo "<option value=''>--Nada encontrado--</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fornecedor</label>
                            <select class="form-control" name="codfornecedor" id="codfornecedor">
                                <?php
                                $executor->optionExecutor('f');
                                ?>
                            </select>
                        </div>                             
                    </div> 
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Executor</label>
                            <select class="form-control" name="codexecutor" id="codexecutor">
                                <?php
                                $executor->optionExecutor('e');
                                ?>
                            </select>
                        </div>                             
                    </div>   
                </form>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php
                        if ($nivelp["procurar"] == 1) {
                            echo '<a onclick="procurarManutencao(false);" class="btn btn-primary"/> ';
                            echo '<i class="fa fa-search" aria-hidden="true"></i> ';
                            echo 'Procurar';
                            echo '</a> ';
                        }
                        if ($nivelp["gerapdf"] == 1) {
                            echo '<a onclick="abreRelatorioManutencao(1);" class="btn btn-primary"/>';
                            echo '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> ';
                            echo 'Gerar PDF';
                            echo '</a> ';
                        }
                        if ($nivelp["geraexcel"] == 1) {
                            echo '<a onclick="abreRelatorioManutencao(2);" class="btn btn-primary"/> ';
                            echo '<i class="fa fa-file-excel-o" aria-hidden="true"></i> ';
                            echo 'Gerar Excel';
                            echo '</a> ';
                        }
                        ?>                         
                    </div>                                        
                </div>
            </div>
            </form>
            <div class="row">
                <div class="col-sm-12" id="listagemManutencao"></div>
            </div>
        </div>
    </div>
    <!--/.col (right) -->
</div>