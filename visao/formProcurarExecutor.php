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
                <form id="fPexecutor" name="fPexecutor" method="post" target="_blank" action="../control/ProcurarExecutorRelatorio.php">
                    <input type="hidden" name="tipoRel" id="tipoRel" value=""/>  
                    <?php montaStatus();?>
                    <div class="col-md-3">                        
                        <div class="form-group">
                            <label for="tipo">Tipo</label>
                            <select class="form-control" name="tipo" id="tipo">
                                <?php $executor->optionTipos();?>
                            </select>
                        </div>
                    </div>                        
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="tipo">FUNÇÃO</label>
                            <select class="form-control" name="funcao" id="funcao">
                                <?php $executor->optionFuncoes();?>
                            </select>
                        </div>
                    </div>                     
                 
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="nome">Nome Executor/Fornecedor</label>
                            <input type='text' class="form-control" name="nome" id="nome" placeholder="Digite nome" value="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php
                                if(isset($nivelp["procurar"]) && $nivelp["procurar"] == 1){
                                    echo '<button class="btn btn-primary" type="button" onclick="procurarExecutor(false)"><i class="fa fa-search" aria-hidden="true"></i> Procurar</button> ';
                                }
                                if(isset($nivelp["gerapdf"]) && $nivelp["gerapdf"] == 1){
                                    echo '<button class="btn btn-primary" type="button" onclick="abreRelatorioExecutor()"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Gerar PDF</button> ';
                                }
                                if(isset($nivelp["geraexcel"]) && $nivelp["geraexcel"] == 1){
                                    echo '<button class="btn btn-primary" type="button" onclick="abreRelatorioExecutor2()"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Gerar Excel</button> ';
                                }
                            ?>
                        
                        </div>                                        
                    </div>                    
                </form>
            </div>
            <div class="row">
                <div id="listagemExecutor" class="col-md-12"></div>
            </div>
        </div>
    </div>
    <!--/.col (right) -->
</div>