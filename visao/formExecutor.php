
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
                <form id="fexecutor" name="fexecutor" method="post" action="../control/SalvarExecutor.php">
                    <input type="hidden" name="codexecutor" id="codexecutor" value="<?= $_GET["codexecutor"] ?>"/>
                    
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="tipo">FUNÇÃO</label>
                            <select class="form-control" required name="funcao" id="funcao">
                                <?php $executor->optionFuncoes($executorp["funcao"]);?>
                            </select>
                        </div>
                    </div>     
                    <div class="col-md-3">                        
                        <div class="form-group">
                            <label for="tipo">Tipo</label>
                            <select class="form-control" required name="tipo" id="tipo">
                                <?php $executor->optionTipos($executorp["tipo"]);?>
                            </select>
                        </div>
                    </div> 
                    <?php 
                    
                        if($executorp["tipo"] == "e"){
                            echo '<input type="hidden" name="codempresa" id="codempresa" value="', $executorp["codempresa2"] ,'"/>';
                        }elseif($executorp["tipo"] == "p"){
                            echo '<input type="hidden" name="codpessoa" id="codpessoa" value="', $executorp["codpessoa"] ,'"/>';
                        }
                        montaStatus($executorp["status"]);
                    ?>                                                           
                    <div class="col-md-6 profissional" style="display: none;">                        
                        <div class="form-group">
                            <label for="nome">Nome Profissional</label>
                            <input type='text' class="form-control" name="nome" id="nome" maxlength="60" minlength="10" placeholder="Digite nome" value="<?php
                            if (isset($executorp["nome"])) {
                                echo $executorp["nome"];
                            }
                            ?>">
                        </div>
                    </div>                   
                    
                    <div class="box-body">
                        <div class="col-md-6 empresa">
                            <div class="form-group">
                                <label for="nome">RAZÃO</label>
                                <input type='text' class="form-control" name="razao" id="razao" placeholder="Digite razão social" value="<?php
                                if (isset($executorp["razao"])) {
                                    echo $executorp["razao"];
                                }
                                ?>">
                            </div>
                        </div>
                        <div class="col-md-3 funcionario">
                            <div class="form-group">
                                <label for="localnascimento">CEP</label>
                                <input type='text' class="form-control cep" name="cep" id="cep" maxlength="9" placeholder="Digite cep ele busca endereço" value='<?php
                                if (isset($executorp["cep"])) {
                                    echo $executorp["cep"];
                                }elseif(isset($executorp["cep_pessoa"])){
                                    echo $executorp["cep_pessoa"];
                                }
                                ?>'>
                            </div>
                        </div>
                        <div class="col-md-3 funcionario">
                            <div class="form-group">
                                <label for="localnascimento">Tip. Logradouro</label>
                                <input type='text' class="form-control" name="tipologradouro" id="tipologradouro" maxlength="8" placeholder="Digite tipo logradouro" value='<?php
                                if (isset($executorp["tipologradouro"])) {
                                    echo $executorp["tipologradouro"];
                                }elseif(isset($executorp["tipologradouro_pessoa"])){
                                    echo $executorp["tipologradouro_pessoa"];
                                }
                                ?>'>
                            </div>
                        </div>
                        <div class="col-md-6 funcionario">
                            <div class="form-group">
                                <label for="localnascimento">Logradouro</label>
                                <input type='text' class="form-control" name="logradouro" id="logradouro" placeholder="Digite logradouro" value='<?php
                                if (isset($executorp["logradouro"])) {
                                    echo $executorp["logradouro"];
                                }elseif(isset($executorp["logradouro_pessoa"])){
                                    echo $executorp["logradouro_pessoa"];
                                }
                                ?>'>
                            </div>
                        </div>
                        <div class="col-md-3 funcionario">
                            <div class="form-group">
                                <label for="numero">Número</label>
                                <input type='text' class="form-control" name="numero" id="numero" placeholder="Digite numero" value='<?php
                                if (isset($executorp["numero"])) {
                                    echo $executorp["numero"];
                                }elseif(isset($executorp["numero_pessoa"])){
                                    echo $executorp["numero_pessoa"];
                                }
                                ?>'>
                            </div>
                        </div>
                        <div class="col-md-3 funcionario">
                            <div class="form-group">
                                <label for="bairro">Bairro</label>
                                <input type='text' class="form-control" name="bairro" id="bairro" placeholder="Digite bairro" value='<?php
                                if (isset($executorp["bairro"])) {
                                    echo $executorp["bairro"];
                                }elseif(isset($executorp["bairro_pessoa"])){
                                    echo $executorp["bairro_pessoa"];
                                }
                                ?>'>
                            </div>
                        </div>
                        <div class="col-md-3 funcionario">
                            <div class="form-group">
                                <label for="cidade">Cidade</label>
                                <input type='text' class="form-control" name="cidade" id="cidade" placeholder="Digite cidade" value='<?php
                                if (isset($executorp["cidade"])) {
                                    echo $executorp["cidade"];
                                }elseif(isset($executorp["cidade_pessoa"])){
                                    echo $executorp["cidade_pessoa"];
                                }
                                ?>'>
                            </div>
                        </div>
                        <div class="col-md-3 funcionario">
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <input type='text' class="form-control" name="estado" id="estado" placeholder="Digite estado" value='<?php
                                if (isset($executorp["uf"])) {
                                    echo $executorp["uf"];
                                }elseif(isset($executorp["uf_pessoa"])){
                                    echo $executorp["uf_pessoa"];
                                }
                                ?>'>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>
                                    <i class="fa fa-phone-square" aria-hidden="true"></i>
                                    Tel. Fixo
                                </label>
                                <input type='text' class="form-control telefone" name="telefone1" id="telefone1" placeholder="Digite telefone fixo" value='<?php
                                if (isset($executorp["telefone"])) {
                                    echo $executorp["telefone"];
                                }elseif(isset($executorp["telefone_pessoa"])){
                                    echo $executorp["telefone_pessoa"];
                                }
                                ?>'>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>
                                    <i class="fa fa-mobile" aria-hidden="true"></i>
                                    Celular
                                </label>
                                <input type='text' class="form-control celular" required name="telefone2" id="telefone2" placeholder="Digite telefone Celular" value='<?php
                                if (isset($executorp["celular"])) {
                                    echo $executorp["celular"];
                                }elseif(isset($executorp["celular_pessoa"])){
                                    echo $executorp["celular_pessoa"];
                                }
                                ?>'>
                            </div>
                        </div>
                        <div class="col-md-6 funcionario">
                            <div class="form-group">
                                <label for="siteurl">Site</label>
                                <input type='url' class="form-control" name="siteurl" id="siteurl" placeholder="Digite url do site" value='<?php
                                if (isset($executorp["site"])) {
                                    echo $executorp["site"];
                                }elseif(isset($executorp["site_pessoa"])){
                                    echo $executorp["site_pessoa"];
                                }
                                ?>'>
                            </div>
                        </div>
                        <div class="col-md-6 empresa">
                            <div class="form-group">
                                <label for="cnpj">CNPJ</label>
                                <input type='text' class="form-control" name="cnpj" id="cnpj" placeholder="Digite o cnpj" value='<?php
                                if (isset($executorp["cnpj"])) {
                                    echo $executorp["cnpj"];
                                }
                                ?>'>
                            </div>
                        </div>
                        <div class="col-md-6 profissional" style="display: none;">
                            <div class="form-group">
                                <label for="cpf">CPF</label>
                                <input type='text' class="form-control" name="cpf" id="cpf" placeholder="Digite o cpf" value='<?php
                                if (isset($executorp["cpf"])) {
                                    echo $executorp["cpf"];
                                }
                                ?>'>
                            </div>
                        </div>                         
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                    E-mail
                                </label>
                                <input type="email" required class="form-control" name='email1' id="email1" placeholder="Digite e-mail 1" value='<?php
                                if (isset($executorp["email"])) {
                                    echo $executorp["email"];
                                }elseif(isset($executorp["email_pessoa"])){
                                    echo $executorp["email_pessoa"];
                                }
                                ?>'>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>
                                    <i class="fa fa-skype" aria-hidden="true"></i>
                                    Skype
                                </label>
                                <input type="text" class="form-control" name='skype' id="skype" placeholder="Digite skype" value='<?php
                                if (isset($executorp["skype"])) {
                                    echo $executorp["skype"];
                                }elseif(isset($executorp["skype_pessoa"])){
                                    echo $executorp["skype_pessoa"];
                                }
                                ?>'>
                            </div>
                        </div>
                                               
                    </div>                    


                    <div class="col-md-6">   
                        <div class="form-group">
                            <label for="nome">Imagem</label>
                            <input type="file" name="imagemexecutor" id="input_imagem"><br> 
                            <?php
                            
                            if (isset($executorp["imagemexecutor"]) && $executorp["imagemexecutor"] != NULL && $executorp["imagemexecutor"] != "") {
                                $caminhoImagem = LOCAL_ARQUIVO . "{$executorp["imagemexecutor"]}";
                            }elseif(isset($executorp["logo"]) && $executorp["logo"] != NULL && $executorp["logo"] != ""){
                              $caminhoImagem = LOCAL_ARQUIVO . "{$executorp["logo"]}";
                            }  else {
                                $caminhoImagem = "../visao/recursos/img/sem_imagem.png";
                            }
                            ?>
                            <img width="250" id="img_preview" class="img-responsive" src="<?= $caminhoImagem ?>" alt="Imagem equipamento"/><br>
                            <?php if(isset($_GET["codigo"]) && $_GET["codigo"] != NULL && $_GET["codigo"] != ""){?>
                            <button class="btn btn-primary" onclick="abreTiraFoto(<?= $executorp["codexecutor"] ?>)">
                                <i class="fa fa-camera"></i>
                                Inserir por webcam
                            </button>
                            <?php }?>
                        </div>
                    </div> 

                    <div class="col-md-12">
                        <div class="form-group">
                            <?php
                            if ($nivelp["inserir"] == 1 || $nivelp["atualizar"] == 1) {
                                echo '<input type="submit" name="submit" id="submit" value="Salvar" class="btn btn-primary"/> ';
                            }
                            if ($nivelp["excluir"] == 1 && isset($_GET["codexecutor"])) {
                                echo '<button class="btn btn-primary" id="btexcluirExecutor" onclick="excluirExecutor()">Excluir</button>  ';
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