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
                <form id="frelacesso" name="frelacesso" method="post" target="_blank" action="../control/ProcurarAcessoRelatorio.php">
                    <input type="hidden" name="tipo" id="tipo" value="pdf"/>   
                   
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nome</label>
                            <select name="codpessoa" id="codpessoa" class="form-control">
                            <?php
                                $pessoa->optionPessoa();
                            ?>                            
                            </select>                            
                        </div>                             
                    </div>    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>CPF</label>
                            <input type='text' class="form-control" name="cpf" id="cpf" maxlength="14" placeholder="Digite cpf">
                        </div>                             
                    </div>                      
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type='email' class="form-control" name="email" id="email" maxlength="150" placeholder="Digite email">
                        </div>                             
                    </div>                     
                                        
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="data1"><i class="fa fa-calendar"></i> Acesso desde</label>
                            <input type="date" class="form-control" name="data1" id="data1" title="Digite data inicial de acessos">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="data2"><i class="fa fa-calendar"></i> Acesso até</label>
                            <input type="date" class="form-control" name="data2" id="data2" title="Digite data final de acessos">
                        </div>
                    </div>



                    <div class="col-md-12">
                        <div class="form-group">
                        <?php
                        if ($nivelp["procurar"] == 1) {
                            echo '<a onclick="procurarAcesso(false);" class="btn btn-primary"/> ';
                            echo '<i class="fa fa-search" aria-hidden="true"></i> ';
                            echo 'Procurar';
                            echo '</a> ';
                        }
                        if ($nivelp["gerapdf"] == 1) {
                            echo '<a onclick="abreRelatorioAcesso(1);" class="btn btn-primary"/>';
                            echo '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> ';
                            echo 'Gerar PDF';
                            echo '</a> ';
                        }
                        if ($nivelp["geraexcel"] == 1) {
                            echo '<a onclick="abreRelatorioAcesso(2);" class="btn btn-primary"/> ';
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
                <div id="listagemAcesso" class="col-md-12"></div>
            </div>
        </div>
    </div>
    <!--/.col (right) -->
</div>
