<form action="../control/SalvarPessoa.php" name="fpessoa" id="fpessoa" method="post">
    <div class="row">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dados Cadastrais</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <input type="hidden" name="codempresa" id="codempresa" value="<?=$empresap["codempresa"]?>"/>
                    <input type="hidden" name="codpessoa" id="codpessoa" value="<?= $pessoap["codpessoa"] ?>"/>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nivel</label>
                            <select name="codnivel" required id="codnivel" class="form-control">
                                <?php
                                    if($_SESSION["codnivel"] != 1){
                                        $and = " and codnivel <> 1";
                                    }
                                    $resnivel = $conexao->comando("select codnivel, nome from nivel where 1 = 1 {$and} order by nome");
                                    $qtdnivel = $conexao->qtdResultado($resnivel);
                                    if($qtdnivel > 0){
                                        echo '<option value="">--Selecione--</option>';
                                        while($nivel = $conexao->resultadoArray($resnivel)){
                                            if($nivel["codnivel"] == $pessoap["codnivel"]){
                                                echo '<option selected value="',$nivel["codnivel"],'">',$nivel["nome"],'</option>';
                                            }else{
                                                echo '<option value="',$nivel["codnivel"],'">',$nivel["nome"],'</option>';
                                            }
                                        }
                                    }else{
                                        echo '<option value="">--Nada encontrado--</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php montaStatus($pessoap["status"])?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type='text' class="form-control" required name="nome" id="nome" placeholder="" value="<?php if (isset($pessoap["nome"]) && $pessoap["nome"] != NULL && $pessoap["nome"] != "") {echo $pessoap["nome"];} ?>">
                        </div>
                    </div>
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" required class="form-control" name='email' id="email" placeholder="" value="<?php if (isset($pessoap["email"])) {echo $pessoap["email"];
                                   } ?>">
                        </div>  
                    </div>
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="senha">Senha </label>
                            <input type="password" required class="form-control" name='senha' id="senha" readonly onfocus="this.removeAttribute('readonly');" placeholder="" value="<?php if (isset($pessoap["senha"])) {echo base64_decode($pessoap["senha"]);} ?>">
                        </div>  
                    </div>
                    

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="imagem">
                                <i class="fa fa-file-image-o"></i> Imagem
                                <?php
                                if(isset($_GET["codpessoa"]) && $_GET["codpessoa"] != NULL && $_GET["codpessoa"] != ""){
                                    echo '<a title="Clique para tirar foto da pessoa" href="javascript: abreTiraFoto(',$_GET["codpessoa"],')">';
                                    echo '<i class="fa fa-camera" aria-hidden="true"></i>';
                                    echo '</a> ';
                                }
                                ?>                                
                            </label>
                            <input type='file' class="form-control" name="imagem" id="input_imagem" accept="image/*"/>
                            <?php
                            if (isset($pessoap["imagem"]) && $pessoap["imagem"] != NULL && $pessoap["imagem"] != "") {
                                $caminhoImagem = LOCAL_ARQUIVO . "{$pessoap["imagem"]}";
                            } else {
                                $caminhoImagem = "../visao/recursos/img/sem_imagem.png";
                            }
                            ?>
                            <img name="img_previewPessoa" width="150" class="img-responsive" id="img_preview" src="<?= $caminhoImagem ?>" alt="Imagem logo"/><br>                                 

                        </div>                                        
                    </div><!-- /.col -->

                </div>
            </div>
        </div>
        <!--/.col (right) -->
    </div>
    
    <!-- /.row -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?php
                if ($nivelp["inserir"] == 1 || $nivelp["atualizar"] == 1) {
                    echo '<input type="submit" name="submit" value="Salvar" class="btn btn-primary"/> ';
                    echo '<a href="javascript: btNovoPessoa()" id="btnovoPessoa"  class="btn btn-primary">Novo</a>';
                }
                ?>
            </div>                                        
        </div>
    </div>      
</form>