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

            <form method="post" action="../control/ProcurarPessoaRelatorio.php" name="fPpessoa" id="fPpessoa" target="_blank">
                <div class="row">
                    <input type="hidden" name="codpagina" id="codpagina" value="<?=$nivelp["codpagina"]?>"/>
                    <input type="hidden" name="codempresa" id="codempresa" value="<?=$empresap["codempresa"]?>"/>
                    <input type="hidden" name="tipo" id="tipo" value="pdf"/>     
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>
                                <i class="fa fa-calendar"></i>
                                Dt. Inicio
                            </label>
                            <input type="date" class="form-control" name="data1" id="data1" title="Digite data de inicio onde foi feito o cadastro">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>
                                <i class="fa fa-calendar"></i>
                                Dt. Fim
                            </label>
                            <input type="date" class="form-control" name="data2" id="data2" title="Digite data de fim onde foi feito o cadastro">
                        </div>
                    </div>
                    <?php montaStatus(); ?>
<!--                    <div class="col-md-3">                        
                         /.form-group 
                        <div class="form-group"> 
                            <label>CPF</label>
                            <input type='text' class="form-control" name="cpf" id="cpf" placeholder="Digite cpf" title="Digite cpf que busca aqui">
                        </div>
                         /.form-group 
                    </div>-->
                    <!-- /.col -->


                    <div class="col-md-3">
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="email" class="form-control" name='email' id="email" placeholder="Digite e-mail">
                        </div>                          
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" class="form-control" name='nome' placeholder="Digite nome">
                        </div>                          
                    </div> 
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php
                            if ($nivelp["procurar"] == 1) {
                                echo '<a onclick="procurarPessoa(false);" class="btn btn-primary"/> ';
                                echo '<i class="fa fa-search" aria-hidden="true"></i> ';
                                echo 'Procurar';
                                echo '</a> ';
                            }

                            if ($nivelp["gerapdf"] == 1) {
                                echo '<a onclick="abreRelatorioPessoa(1);" class="btn btn-primary"/>';
                                echo '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> ';
                                echo 'Gerar PDF';
                                echo '</a> ';
                            }
                            if ($nivelp["geraexcel"] == 1) {
                                echo '<a onclick="abreRelatorioPessoa(2);" class="btn btn-primary"/> ';
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
                <div class="col-sm-12" id="listagemPessoa"></div>
            </div>
        </div>
    </div>
    <!--/.col (right) -->
</div>