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
                <form action="../control/ProcurarLocalEquipamentoRelatorio.php" name="fPlocal" id="fPlocal" method="post" onsubmit="return false;" target="_blank">
                    <input type="hidden" name="codlocal" id="codlocal" value="<?=$_GET["codlocal"]?>"/>
                    <input type="hidden" name="tipo" id="tipo" value="<?= $_get["tipo"] ?>"/>
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="nome">Nome Local</label>
                            <input type='text' class="form-control" name="nome" id="nome" placeholder="Digite nome" value="">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <?php
                            if ($nivelp["procurar"] == 1) {
                                echo '<a onclick="procurarLocal(false);" class="btn btn-primary"/> ';
                                echo '<i class="fa fa-search" aria-hidden="true"></i> ';
                                echo 'Procurar';
                                echo '</a> ';
                            }
                            if ($nivelp["gerapdf"] == 1) {
                                echo '<a onclick="abreRelatorioLocal(1);" class="btn btn-primary"/>';
                                echo '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> ';
                                echo 'Gerar PDF';
                                echo '</a> ';
                            }
                            if ($nivelp["geraexcel"] == 1) {
                                echo '<a onclick="abreRelatorioLocal(2);" class="btn btn-primary"/> ';
                                echo '<i class="fa fa-file-excel-o" aria-hidden="true"></i> ';
                                echo 'Gerar Excel';
                                echo '</a> ';
                            }
                            ?>                             
                        </div>                                        
                    </div>
                </form>                
            </div>
            <div class="row">
                <div class="col-sm-12" id="listagemLocal"></div>
            </div>
        </div>
    </div>
    <!--/.col (right) -->
</div>