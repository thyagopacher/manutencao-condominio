<form id="fservico" name="fservico" method="post" action="../control/SalvarServico.php">
    <input type="hidden" name="codservico" value="<?php echo $servicop["codservico"]; ?>"/>
    <input type="hidden" name="codexecutor" value="<?php echo $executor["codexecutor"]; ?>"/>
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
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="nome">Nome Serviço</label>
                            <input style="margin-top: 19px;" required type='text' class="form-control" name="nome" id="nomeServico" maxlength="150" placeholder="Digite nome" value="<?php
                            if (isset($servicop["nome"])) {
                                echo $servicop["nome"];
                            }
                            ?>">
                        </div>
                    </div>                     
                 
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="observacao">Observação</label>
                            <textarea class="form-control" required name="observacao" maxlength="240" id="observacao" placeholder="Digite observação"><?php
                                if (isset($servicop["observacao"])) {
                                    echo $servicop["observacao"];
                                }
                                ?></textarea>
                        </div>
                    </div>  

                </div>
            </div>
        </div>
        <!--/.col (right) -->
    </div>

        <div class="form-group">
<?php
if ($nivelp["inserir"] == 1 || $nivelp["atualizar"] == 1) {
    echo '<input type="submit" name="submit" id="submit" value="Salvar" class="btn btn-primary"/> ';
}
if ($nivelp["excluir"] == 1 && isset($_GET["codigo"])) {
    echo '<button class="btn btn-primary" id="btexcluirServico" onclick="excluirServico()">Excluir</button>  ';
}
echo '<a style="color: white" class="btn btn-primary" href="javascript: botaoNovoReload()">Novo</a> ';
?>
        </div>                                        
</form>