<form id="fagendamento" name="fagendamento" method="post" action="../control/SalvarManutencao.php">
    <input type="hidden" name="codmanutencao" id="codmanutencao" value="<?php echo $agendamentop["codmanutencao"]; ?>"/>
    <div class="row">
        <div class="box box-default">
            <div class="box-header with-border nimprimir">
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div id="div_form" class="col-md-3 nimprimir">
                          <div class="form-group">
                            <label>Nome equipamento</label>
                            <select required name="codequipamento" id="codequipamento" class="form-control">
                                <?php 
                                $equipamento->optionEquipamento($agendamentop["codequipamento"]);
                                ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Data Inicial</label>
                            <input required type="date" class="form-control datainicio" name="data" id="data" value="<?php if(isset($agendamentop["data"])){echo $agendamentop["data"];}?>">
                          </div>
                          <div style="display: none" id="div_data_final" class="form-group">
                            <label>Data Final</label>
                            <input type="date" class="form-control datafim" name="datafim" id="datafim" value="<?php if(isset($agendamentop["datafim"])){echo $agendamentop["datafim"];}?>">
                          </div>
                          <div class="form-group">
                            <label>Tipo</label>
                            <select required name="tipo" id="tipo" class="form-control">
                                <option value="">--Selecione--</option>
                                <option value="p" <?php if(isset($agendamentop["tipo"]) && $agendamentop["tipo"] == "p"){echo "selected";}?>>Preventiva</option>
                                <option value="c" <?php if(isset($agendamentop["tipo"]) && $agendamentop["tipo"] == "c"){echo "selected";}?>>Corretiva</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Servico</label>
                            <select required name="codservico[]" id="codservico" class="form-control selectpicker" multiple>
                                <?php
                                    $servico->optionServico($agendamentop["codservico"], true);
                                ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Valor Previsto</label>
                            <input required type="text" class="form-control real" name="valor" id="valor" value="<?php if(isset($agendamentop["valor"])){echo number_format($agendamentop["valor"], 2, ',', '.');}?>">
                          </div>                                                    
                    </div>
                    <a href="javascript: imprimirCalendario()" class="btn btn-primary nimprimir">Imprimir</a>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div id='calendar'></div>
                    </div>
                    <!-- /.col -->
                </div>

                <div class="col-md-12 nimprimir">
                    <div class="form-group">
                        <?php
                        if ($nivelp["inserir"] == 1 || $nivelp["atualizar"] == 1) {
                            echo '<input type="submit" name="submit" id="submit" value="Salvar" class="btn btn-primary"/> ';
                        }
                        if ($nivelp["excluir"] == 1 && isset($_GET["codigo"])) {
                            echo '<button class="btn btn-primary" id="btexcluirAgendamento" onclick="excluirAgendamento()">Excluir</button>  ';
                        }
                        echo '<a style="color: white" class="btn btn-primary" href="javascript: botaoNovoReload()">Novo</a> ';
                        ?>
                    </div>  
                </div>

            </div>
        </div>
        <!--/.col (right) -->
    </div>

</form>