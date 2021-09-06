<?php

include "validacaoLogin.php";

if(isset($_GET["codmanutencao"]) && $_GET["codmanutencao"] != NULL && $_GET["codmanutencao"] != ""){
    $sql = "select imginicio, imgfim
    from manutencao
    where codempresa = {$_SESSION["codempresa"]} 
    and codmanutencao = {$_GET["codmanutencao"]}";
    $manutencaop = $conexao->comandoArray($sql);
}
?>  
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Imagens da Manutenção</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/visao/recursos/css/fileinput.min.css">

        <style>
            /* Remove the navbar's default margin-bottom and rounded borders */ 
            .navbar {
                margin-bottom: 0;
                border-radius: 0;
            }

            /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
            .row.content {height: 450px}

            /* Set gray background color and 100% height */
            .sidenav {
                padding-top: 20px;
                background-color: #f1f1f1;
                height: 100%;
            }

            /* Set black background color, white text and some padding */
            footer {
                background-color: #555;
                color: white;
                padding: 15px;
            }

            .texto_foto{
                text-align: center;
            }

            .foto{
                border: 1px solid;  
            }
            .clearfix{
                height: 540px;
            }
            .kv-preview-thumb{
                height: 500px;
                width: 515px;
            }
            .kv-file-content{
                height: 370px !important;
            }

            /**imagem 1 - input*/
            .kv-file-content img{
                width: 500px !important;
                height: 350px !important;
            }

            /**img - preview*/
            .kv-zoom-body img{

            }

            /* On small screens, set height to 'auto' for sidenav and grid */
            @media screen and (max-width: 767px) {
                .sidenav {
                    height: auto;
                    padding: 15px;
                }
                .row.content {height:auto;} 
            }
        </style>
    </head>
    <body>
        <input type="hidden" name="codmanutencao" id="codmanutencao" value="<?= $_GET["codmanutencao"] ?>">
        <div class="container-fluid text-center">    
            <div class="row content">
                <div class="col-sm-6 foto"> 
                    <br><input type="file" class="form-control file" name="imginicio" id="imginicio" value="<?php if(isset($manutencaop["imginicio"])){echo LOCAL_ARQUIVO .$manutencaop["imginicio"];}?>"><br>
                    <h3 class="texto_foto">Antes Manutençao</h3>
                </div>
                <div class="col-sm-6 text-left foto"> 
                    <br><input type="file" class="form-control file" name="imgfim" id="imgfim" value="<?php if(isset($manutencaop["imgfim"])){echo $manutencaop["imgfim"];}?>"><br>                
                    <h3 class="texto_foto">Após Manutençao</h3>
                </div>
            </div>
        </div>
        <script src="/visao/recursos/js/jquery.min.js"></script>
        <script src="/visao/recursos/js/bootstrap.min.js"></script>
        <script src="/visao/recursos/js/fileinput.min.js"></script>
        <script src="/visao/recursos/js/locales/pt-BR.js"></script>
        <script>
            var footerTemplate = '<input type="hidden" name="codmanutencao" class="kv-input kv-new form-control input-sm text-center {TAG_CSS_NEW}" value="<?=$_GET["codmanutencao"]?>" placeholder="Enter caption...">';
            $(".file").fileinput({
                language: "pt-BR",
                key: 100,
                layoutTemplates: {footer: footerTemplate, size: '<samp><small>({sizeText})</small></samp>'},
                extra: {id: 100},
                uploadUrl: "/control/SalvarManutencao.php",
                allowedFileExtensions: ["jpg", "png", "gif"],
                uploadExtraData: function () {  // callback example
                    var out = {}, key, i = 0;
                    $('.kv-input').each(function () {
                        $el = $(this);
                        key = $el.prop('name');
                        out[key] = $el.val();
                        i++;
                    });
                    return out;
                }                         
            });
        </script>
    </body>
</html>
