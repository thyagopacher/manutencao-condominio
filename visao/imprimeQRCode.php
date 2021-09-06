<form id="fequipamento" name="fequipamento" method="post" action="../control/SalvarEquipamento.php">
    <input type="hidden" name="codequipamento" value="<?php echo $equipamentop["codequipamento"]; ?>"/>
    <input type="hidden" name="codexecutor" value="<?php echo $executor["codexecutor"]; ?>"/>
    <div class="row">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
 
                    <div class="col-md-12">
                        <img style="display: block; margin-left: auto; margin-right: auto;" class="img-responsive" id="img_preview" src="../visao/recursos/img/Imprimir.png" alt="Imagem equipamento"/> <br>

                    </div>   

                </div>
            </div>
        </div>
        <!--/.col (right) -->
    </div>

</form>