<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Tirar Fotos</title>
        <?php include 'head.php'; ?>
        <style>
            video { border: 1px solid #ccc; display: block; margin: 0 0 20px 0; }
            #canvas {border: 1px solid #ccc; display: block; }
        </style>
    </head>
    <body>
        <input type="hidden" name="codpessoa" id="codpessoa" value="<?=$_GET["codpessoa"]?>"/>
        <div style="width: 50%; float: left;"><video id="video" width="640" height="480" autoplay></video></div>
        <div style="width: 50%; float: left;"><canvas id="canvas" width="640" height="480"></canvas></div>        
        <div>
            <button id="snap">Tirar Foto</button>
            <button id="save">Salvar Foto</button>
        </div>
        <?php include './javascriptFinal.php'; ?>
        <script type="text/javascript" src="/visao/recursos/js/ajax/SalvarImagemPessoa.js?321354"></script>    
    </body>
</html>