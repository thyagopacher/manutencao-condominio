
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
                <form id="fperfilAcesso" name="fperfilAcesso" method="post" onsubmit="return false;">
                    <input type="hidden" name="codmodulo" id="codmodulo"/>
                    <div class="col-md-12" id="comboNivel"></div>
                    <div class="col-md-12">
                        <button class="btn btn-primary" onclick="marcarPerfil();">Marcar todos</button>
                        <button class="btn btn-primary" onclick="desmarcarPerfil();">Desmarcar todos</button>
                        <button class="btn btn-primary" onclick="salvarPerfil();">Salvar</button>
                    </div>  
                    
                    <div class="row">
                        <div class="col-md-12"  id="listagemPerfilAcesso"></div>
                    </div>                     
                </form>
            </div>

           
        </div>
    </div>
    <!--/.col (right) -->
</div>