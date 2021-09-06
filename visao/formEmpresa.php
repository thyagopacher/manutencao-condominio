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
                <form id="fempresa" name="fempresa" method="post" action="../control/SalvarEmpresa.php">
                    <input type="hidden" name="codempresa" id="codempresa" value="<?=$empresap["codempresa"]?>"/>
                    <div class="col-md-4">                        
                        <div class="form-group">
                            <label>Razão</label>
                            <input required type='text' class="form-control" name="razao" id="razao" placeholder="Digite razao" value="<?php if(isset($empresap["razao"])){echo ($empresap["razao"]);}?>">
                        </div>
                    </div>
                    <div class="col-md-4">                        
                        <div class="form-group">
                            <label>
                                <i class="fa fa-link" aria-hidden="true"></i>
                                Site
                            </label>
                            <input type='url' class="form-control url" name="site" id="site" placeholder="http://" value="<?php if(isset($empresap["site"])){echo $empresap["site"];}?>">
                        </div>
                    </div>
                    <div class="col-md-4">                        
                        <div class="form-group">
                            <label>
                                E-mail
                            </label>
                            <input type='email' class="form-control" name="email" id="email" placeholder="Digite email" value="<?php if(isset($empresap["email"])){echo $empresap["email"];}?>">
                        </div>
                    </div>
                    <div class="col-md-4">                        
                        <div class="form-group">
                            <label>
                                Status
                            </label>
                            <select name="codstatus" class="form-control">
                                <?php
                                    $status->optionStatus($empresap["codstatus"]);
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="cnpj">CNPJ</label>
                            <input type='text' class="form-control" name="cnpj" id="cnpj" placeholder="Digite o cnpj" value='<?php
                                if (isset($empresap["cnpj"])) {
                                    echo $empresap["cnpj"];
                                }
                            ?>'>
                        </div>
                    </div>  
                    
                    <div class="col-md-2">                        
                        <div class="form-group">
                            <label>
                                CEP
                            </label>
                            <input required type='text' class="form-control" name="cep" id="cep" placeholder="Digite cep" value="<?php if(isset($empresap["cep"])){echo $empresap["cep"];}?>">
                        </div>
                    </div>                                     
                    <div class="col-md-2">                        
                        <div class="form-group">
                            <label>
                                Tipo Logradouro
                            </label>
                            <input type='text' class="form-control" name="tipologradouro" id="tipologradouro" placeholder="Digite tipo logradouro" value="<?php if(isset($empresap["tipologradouro"])){echo $empresap["tipologradouro"];}?>">
                        </div>
                    </div>                                     
                    <div class="col-md-2">                        
                        <div class="form-group">
                            <label>
                                Logradouro
                            </label>
                            <input type='text' class="form-control" name="logradouro" id="logradouro" placeholder="Digite logradouro" value="<?php if(isset($empresap["logradouro"])){echo $empresap["logradouro"];}?>">
                        </div>
                    </div>                                     
                    <div class="col-md-2">                        
                        <div class="form-group">
                            <label>
                                Número
                            </label>
                            <input type='text' class="form-control" name="numero" id="numero" placeholder="Digite numero" value="<?php if(isset($empresap["numero"])){echo $empresap["numero"];}?>">
                        </div>
                    </div>                                     
                    <div class="col-md-2">                        
                        <div class="form-group">
                            <label>
                                Bairro
                            </label>
                            <input type='text' class="form-control" name="bairro" id="bairro" placeholder="Digite bairro" value="<?php if(isset($empresap["bairro"])){echo $empresap["bairro"];}?>">
                        </div>
                    </div>                                     
                    <div class="col-md-2">                        
                        <div class="form-group">
                            <label>
                                Cidade
                            </label>
                            <input type='text' class="form-control" name="cidade" id="cidade" placeholder="Digite cidade" value="<?php if(isset($empresap["cidade"])){echo $empresap["cidade"];}?>">
                        </div>
                    </div>                                     
                    <div class="col-md-2">                        
                        <div class="form-group">
                            <label>
                                UF
                            </label>
                            <input type='text' class="form-control" name="uf" id="uf" placeholder="Digite uf" value="<?php if(isset($empresap["uf"])){echo $empresap["uf"];}?>">
                        </div>
                    </div>                                     
                    <div class="col-md-2">                        
                        <div class="form-group">
                            <label>
                                Telefone
                            </label>
                            <input type='text' class="form-control telefone" name="telefone" id="telefone" placeholder="Digite telefone" value="<?php if(isset($empresap["telefone"])){echo $empresap["telefone"];}?>">
                        </div>
                    </div>                                     
                    <div class="col-md-2">                        
                        <div class="form-group">
                            <label>
                                Celular
                            </label>
                            <input type='text' class="form-control celular" name="celular" id="celular" placeholder="Digite celular" value="<?php if(isset($empresap["celular"])){echo $empresap["celular"];}?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>
                                <i class="fa fa-picture-o" aria-hidden="true"></i>
                                Logo
                            </label>
                            <input type='file' class="form-control" name="logo" id="input_imagem" accept="image/*">
                            <?php
                            if (isset($empresap["logo"]) && $empresap["logo"] != NULL && $empresap["logo"] != "") {
                                $caminhoImagem = LOCAL_ARQUIVO . "{$empresap["logo"]}";
                            } else {
                                $caminhoImagem = "../visao/recursos/img/sem_imagem.png";
                            }
                            ?>
                            <img width="150" class="img-responsive" id="img_preview" src="<?= $caminhoImagem ?>" alt="Imagem logo"/><br>                            
                        </div>
                    </div>                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php 
                            if($nivelp["inserir"] == 1 || $nivelp["atualizar"] == 1){
                                echo '<input type="submit" id="submit" value="Salvar" class="btn btn-primary"/> ';
                            }
                            if($nivelp["excluir"] == 1 && isset($_GET["codempresa"]) && $nivelp["codpagina"] != 14){
                                echo '<button class="btn btn-primary" id="btexcluirEmpresa" onclick="excluirEmpresa()">Excluir</button>  ';
                            }
                            if($nivelp["codpagina"] != 129){
                                echo '<a style="color: white" class="btn btn-primary" href="javascript: botaoNovoReload()">Novo</a> ';   
                            }
                            ?>
                        </div>                                        
                    </div>                    
                </form>
            </div>
            <div style="display: none" class="row col-md-12 progress">
                <div id="progressbar" class="progress-bar" role="progressbar" aria-valuenow="70"
                     aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                    <span id="sronly" class="sr-only">0% Complete</span>
                </div>
            </div>             
        </div>
    </div>
    <!--/.col (right) -->
</div>