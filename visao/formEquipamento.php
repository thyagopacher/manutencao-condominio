<form id="fequipamento" name="fequipamento" method="post" action="../control/SalvarEquipamento.php">
    <input type="hidden" name="codequipamento" value="<?php echo $equipamentop["codequipamento"]; ?>"/>
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
                            <label for="nome">Nome Equipamento</label>
                            <input type='text' required class="form-control" name="nome" id="nomeEquipamento" maxlength="150" placeholder="Digite nome" value="<?php
                            if (isset($equipamentop["nome"])) {
                                echo $equipamentop["nome"];
                            }
                            ?>">
                        </div>
                    </div>

                    <?php montaStatus($equipamentop["status"])?>

                    <div class="col-md-3">                        
                        <div class="form-group">
                            <label for="nome">Periodo</label>
                            <select class="form-control" required name="periodo" id="periodo" >
                                <?php
                                echo '<option value="">--Selecione--</option>';
                                foreach ($equipamento->array_periodo as $key => $periodo) {
                                    if ($key == $equipamentop["periodo"]) {
                                        echo '<option selected value="', $key, '">', $periodo, '</option>';
                                    } else {
                                        echo '<option value="', $key, '">', $periodo, '</option>';
                                    }
                                }
                                ?>
                            </select> 
                        </div>
                    </div>
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="codpatrimonio">N° de identificação</label>
                            <input type='text' class="form-control" name="codpatrimonio" id="codpatrimonio" placeholder="Digite cod. patrimonio" value="<?php
                            if (isset($equipamentop["codpatrimonio"])) {
                                echo $equipamentop["codpatrimonio"];
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="codpatrimonio">QR CODE</label>
                            <input type='text' class="form-control" required name="qrcode" id="codpatrimonioqr" placeholder="Digite QRCode" value="<?php
                            if (isset($equipamentop["qrcode"])) {
                                echo $equipamentop["qrcode"];
                            }
                            ?>">
                        </div>
                    </div>                    
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="tipo">Fornecedor</label>
                            <select class="form-control" required name="codfornecedor" id="codfornecedor">
                                <?php
                                $executor->optionExecutor('f', $equipamentop["codfornecedor"]);
                                ?>
                            </select>
                        </div>
                    </div>  
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="tipo">Executor Manutenção</label>
                            <select class="form-control" required name="codexecutor" id="codexecutor">
                                <?php
                                $executor->optionExecutor('e', $equipamentop["codexecutor"]);
                                ?>                              
                            </select>
                        </div>
                    </div>     
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="tipo">Localização</label>
                            <select class="form-control" required name="codlocal" id="codlocal">
                                <?php
                                $reslocal = $conexao->comando("select codlocal, nome from localequipamento where codempresa = {$_SESSION["codempresa"]} order by nome");
                                $qtdlocal = $conexao->qtdResultado($reslocal);
                                if ($qtdlocal > 0) {
                                    echo ' <option value="">--Selecione--</option>';
                                    while ($local = $conexao->resultadoArray($reslocal)) {
                                        if (isset($local) && $local["codlocal"] != NULL && $local["codlocal"] == $equipamentop["codlocal"]) {
                                            echo ' <option selected value="', $local["codlocal"], '">', $local["nome"], '</option>';
                                        } else {
                                            echo ' <option value="', $local["codlocal"], '">', $local["nome"], '</option>';
                                        }
                                    }
                                }
                                ?>                                
                            </select>
                        </div>
                    </div> 
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="tipo">Serviços</label>
                            <select class="form-control selectpicker" required name="codservico[]" id="codservico" multiple>
                                <?php
                                    $servico->optionServico($equipamentop["codservico"], true);
                                ?>                                
                            </select>
                        </div>
                    </div> 
                    <div class="col-md-12">                        
                        <div class="form-group">
                            <label for="descricao">Observação</label>
                            <textarea class="form-control" maxlength="240" name="descricao" id="descricao" placeholder="Digite descrição"><?php
                                if (isset($equipamentop["descricao"])) {
                                    echo $equipamentop["descricao"];
                                }
                                ?></textarea>
                        </div>
                    </div>                      
                    
                    <div class="col-md-6">   
                        <input type="file" required name="imagem" id="input_imagem" value="imagem"><br> 
                        <?php
                        if (isset($equipamentop["imagem"]) && $equipamentop["imagem"] != NULL && $equipamentop["imagem"] != "") {
                            $caminhoImagem = LOCAL_ARQUIVO . "{$equipamentop["imagem"]}";
                        } else {
                            $caminhoImagem = "../visao/recursos/img/sem_imagem.png";
                        }
                        ?>
                        <img width="150" class="img-responsive" id="img_preview" src="<?= $caminhoImagem ?>" alt="Imagem equipamento"/><br>
                        <?php if(isset($_GET["codequipamento"]) && $_GET["codequipamento"] != NULL && $_GET["codequipamento"] != ""){?>
                        <button class="btn btn-primary" onclick="abreTiraFoto(<?= $equipamentop["codequipamento"] ?>)" style="margin-bottom: 15px;">Inserir por webcam</button>
                        <?php }?>
                    </div>   
                    
                    <div id="div_qrcode" class="col-md-6" style="display: none">
                        <img class="img-responsive" id="imgQrCode" src="" alt="Imagem equipamento"/> 
                    </div>   
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php
                            if ($nivelp["inserir"] == 1 || $nivelp["atualizar"] == 1) {
                                echo '<input type="submit" name="submit" id="submit" value="Salvar" class="btn btn-primary"/> ';
                            }
                            if ($nivelp["excluir"] == 1 && isset($_GET["codigo"])) {
                                echo '<button class="btn btn-primary" id="btexcluirEquipamento" onclick="excluirEquipamento()">Excluir</button>  ';
                            }
                            echo '<a style="color: white" class="btn btn-primary" href="javascript: botaoNovoReload()">Novo</a> ';
                            ?>
                        </div>  
                    </div>

                </div>
            </div>
        </div>
        <!--/.col (right) -->
    </div>

</form>