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
                <form id="fequipamento" name="fequipamento" method="post" action="../control/SalvarConfiguracao.php">
                    <input type="hidden" name="codequipamento" id="codequipamento" value="<?=$_GET["codequipamento"]?>"/>
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="nome">Qtd SMS periodo</label>
                            <input type='text' class="form-control" name="nome" id="nome" placeholder="Digite nome" value="<?php if(isset($equipamentop["nome"])){echo $equipamentop["nome"];}?>">
                        </div>
                    </div>
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="nome">Qtd E-mail periodo</label>
                            <input type='text' class="form-control" name="nome" id="nome" placeholder="Digite nome" value="<?php if(isset($equipamentop["nome"])){echo $equipamentop["nome"];}?>">
                        </div>
                    </div>
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="nome">Dias antes do venc.</label>
                            <input type='text' class="form-control" name="nome" id="nome" placeholder="Digite nome" value="<?php if(isset($equipamentop["nome"])){echo $equipamentop["nome"];}?>">
                        </div>
                    </div>
                                  
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php 
                            if($nivelp["inserir"] == 1 || $nivelp["atualizar"] == 1){
                                echo '<input type="submit" name="submit" id="submit" value="Salvar" class="btn btn-primary"/> ';
                            }
                            if($nivelp["excluir"] == 1 && isset($_GET["codequipamento"])){
                                echo '<button class="btn btn-primary" id="btexcluirConfiguracao" onclick="excluirConfiguracao()">Excluir</button>  ';
                            }
                            echo '<a style="color: white" class="btn btn-primary" href="javascript: botaoNovoReload()">Novo</a> ';                            
                            ?>
                        </div>                                        
                    </div>                    
                </form>
            </div>
            <div class="row">
                <div id="listagemCategoriaProduto" class="col-md-12"></div>
            </div>
        </div>
    </div>
    <!--/.col (right) -->
</div>