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
                <form id="fmanutencao" name="fmanutencao" method="post" action="../control/SalvarManutencao.php">
                    <input type="hidden" name="codmanutencao" id="codmanutencao" value="<?=$_GET["codmanutencao"]?>"/>
                    <input type="hidden" name="codpagina" id="codpagina" value="<?=$nivelp["codpagina"]?>"/>
                    <div class="col-md-12">                        
                        <div class="form-group">
                            <a class="btn btn-default" target="_blank" href="Equipamento.php?codequipamento=<?=$manutencaop["codequipamento"]?>">
                                <i class="fa fa-cog" aria-hidden="true"></i> 
                                Equipamento
                            </a>
                            <a class="btn btn-default" target="_blank" href="Local.php?codlocal=<?=$manutencaop["codlocal"]?>">
                                <i class="fa fa-map-marker" aria-hidden="true"></i> 
                                Localização
                            </a>
                            <a class="btn btn-default" target="_blank" href="Executor.php?codexecutor=<?=$manutencaop["codexecutor"]?>">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                Executor
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h4>N° O.S.: <?=$manutencaop["codmanutencao"]?>/<?=date("Y", strtotime($manutencaop["dtcadastro"]))?></h4>
                    </div>              
                    <div class="col-md-4">                        
                        <div class="form-group">
                            <label>Status</label>
                            <select required class="form-control" name="codstatus" id="codstatus">
                                <?php
                                    $status->optionStatus($manutencaop["codstatus"]);
                                ?>
                            </select>
                        </div>
                    </div>                   
                    <div class="col-md-4">                        
                        <div class="form-group">
                            <label>Tempo gasto</label>
                            <input maxlength="100" required class="form-control" type="text" name="tempo_gasto" id="tempo_gasto" value="<?php if(isset($manutencaop["tempo_gasto"])){echo $manutencaop["tempo_gasto"];}?>"/>
                        </div>
                    </div>
                    <div class="col-md-4">                        
                        <div class="form-group">
                            <label for="valor">Valor gasto</label>
                            <input type='text' required class="form-control real" name="valor_gasto" id="valor_gasto" placeholder="Digite valor gasto" value="<?php if(isset($manutencaop["valor_gasto"])){echo number_format($manutencaop["valor_gasto"], 2, ',', '.');}?>">
                        </div>
                    </div>  
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label>Material utilizado</label>
                            <input maxlength="250" required name="material" id="material" class="form-control" placeholder="Digite material" value="<?php if(isset($manutencaop["material"])){echo $manutencaop["material"];}?>"/>
                        </div>
                    </div>                     
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="tipo">Serviços</label>
                            <select class="form-control selectpicker" required name="codservico[]" id="codservico" multiple>
                                <?php
                                    $servico->optionServico($manutencaop["codservico"], true);
                                ?>                                
                            </select>
                        </div>
                    </div>                     
                    <div class="col-md-12">                        
                        <div class="form-group">
                            <label>Pendências</label>
                            <?php
                                if($manutencaop["codstatus"] != 3){
                                    $required = "required";
                                }else{
                                    $required = "";
                                }
                            ?>
                            <textarea maxlength="250" <?= $required ?> name="pendencias" id="pendencias" class="form-control" placeholder="Digite pendencias"><?php if(isset($manutencaop["pendencias"])){echo $manutencaop["pendencias"];}?></textarea>
                        </div>
                    </div>

                    <div class="col-md-12">                        
                        <div class="form-group">
                            <label>Demais observações</label>
                            <textarea maxlength="250" name="demais_observacoes" id="demais_observacoes" class="form-control" placeholder="Digite observação"><?php if(isset($manutencaop["demais_observacoes"])){echo $manutencaop["demais_observacoes"];}?></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">                        
                        <div class="form-group">
                            <label>Img. Serviço</label>
                            <input type="file" name="imagem_servico" id="input_imagem" accept="image/*"/>
                            <?php 
                            if(isset($manutencaop["imagem_servico"]) && $manutencaop["imagem_servico"] != NULL && $manutencaop["imagem_servico"] != ""){
                                echo '<img style="width: 230px;" id="img_preview" src="../arquivos/'.$manutencaop["imagem_servico"].'" class="img-responsive"/>';
                            }else{
                                echo '<img style="width: 230px;" id="img_preview" src="../visao/recursos/img/sem_imagem.png" class="img-responsive"/>';
                            }
                            ?>
                            
                        </div>
                    </div>

         
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php 
                            if($nivelp["inserir"] == 1 || $nivelp["atualizar"] == 1){
                                echo '<input type="submit" name="submit" id="submit" value="Salvar" class="btn btn-primary"/> ';
                            }
                            if($nivelp["excluir"] == 1 && isset($_GET["codmanutencao"])){
                                echo '<button class="btn btn-primary" id="btexcluirManutencao" onclick="excluirManutencao()">Excluir</button>  ';
                            }
                            if($nivelp["codpagina"] != 113){
                                echo '<a style="color: white" class="btn btn-primary" href="javascript: botaoNovoReload()">Novo</a> ';      
                            }
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