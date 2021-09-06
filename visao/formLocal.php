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
                <form id="flocal" name="flocal" method="post" action="<?= $action ?>">
                    <input type="hidden" name="codlocal" id="codlocal" value="<?= $localp["codlocal"] ?>"/>
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type='text' class="form-control" required name="nome" id="nome" placeholder="Digite nome" value="<?php if(isset($localp["nome"])){echo $localp["nome"];}?>">
                        </div>
                    </div>
                  
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="texto">Descrição 1 </label>
                            <textarea class="form-control" required name="descricao1" maxlength="50" id="descricao1" placeholder="Digite descrição 1"><?php if(isset($localp["descricao1"])){echo $localp["descricao1"];}?></textarea>
                        </div>
                    </div>                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="texto">Descrição 2</label>
                            <textarea class="form-control" name="descricao2" maxlength="50" id="descricao2" placeholder="Digite descrição 2"><?php if(isset($localp["descricao2"])){echo $localp["descricao2"];}?></textarea>
                        </div>
                    </div>  
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="texto">Descrição 3 </label>
                            <textarea class="form-control" name="descricao3" maxlength="50" id="descricao3" placeholder="Digite descrição 3"><?php if(isset($localp["descricao3"])){echo $localp["descricao3"];}?></textarea>
                        </div>
                    </div>                     
                    <div class="col-md-12 form-group">   
                        <div class="col-md-3">
                            <input type="file" name="imagem" id="input_imagem" value="imagem"><br> 
                            <?php
                                if(isset($localp["imagem"]) && $localp["imagem"] != NULL && $localp["imagem"] != ""){
                                    $caminhoImagem = LOCAL_ARQUIVO. "{$localp["imagem"]}";

                                }else{
                                    $caminhoImagem = "../visao/recursos/img/sem_imagem.png";
                                }                            
                            ?> 
                            <img class="img-responsive" id="img_preview" src="<?= $caminhoImagem ?>" alt="Imagem local"/><br>
                            
                            <button class="btn btn-primary" onclick="abreTiraFoto(<?= $equipamentop["codequipamento"]?>)">Inserir por webcam</button>
                        </div>
                    </div>                     
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php 
                            if($nivelp["inserir"] == 1 || $nivelp["atualizar"] == 1){
                                echo '<input type="submit" name="submit" id="submit" value="Salvar" class="btn btn-primary"/> ';
                            }
                            if($nivelp["excluir"] == 1 && isset($_GET["codlocal"])){
                                echo '<button class="btn btn-primary" id="btexcluirEquipamento" onclick="excluirEquipamento()">Excluir</button>  ';
                            }
                            echo '<a style="color: white" class="btn btn-primary" href="javascript: botaoNovoReload()">Novo</a> ';                            
                            ?>
                        </div>                                        
                    </div>                    
                </form>
            </div>
        </div>
    </div>
    <!--/.col (right) -->
</div>