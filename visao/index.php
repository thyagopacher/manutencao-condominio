<?php
if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != "on" && $_SERVER["REMOTE_ADDR"] != '127.0.0.1'){
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
include "../model/Conexao.php";
$conexao = new Conexao();

if($_SERVER["SERVER_NAME"] == "manutencao.gestccon.com.br"){
    $and = " and codempresa = 29";
}else{
    $and = '';
}
$empresa = $conexao->comandoArray("select logo from empresa where 1 = 1 {$and}");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>GestCCon | Login</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css?1234w56">
        <!-- iCheck -->
        <link rel="stylesheet" href="../../plugins/iCheck/square/blue.css">
        <link rel="stylesheet" href="css/sweet-alert.min.css">
        <meta name="google-site-verification" content="qgGjEMU2O_SW46KBr88NaGrtPYgalqFffXIGlmsA7jE" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            body{
                background: url(/visao/recursos/img/fundo.jpg) #1E5687 repeat center top fixed!important;
            }
            
        </style>
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="https://gestccon.com.br">
                    <img class="img-responsive" src='<?=LOCAL_ARQUIVO. $empresa["logo"]?>' alt='logo empresa'/>
                </a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Iniciar sessão</p>

                <form action="control/Login.php" method="post">
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" name="email" id="email" required placeholder="Email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="senha" id="senha" required placeholder="Senha">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox" name="lembrame" id="lembrame" value="s"> Lembrar-me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="button" id="btlogin" class="btn btn-primary btn-block btn-flat">Entrar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!-- /.social-auth-links -->
                <a href="javascript: esqueceuSenha()">Esqueci minha senha</a><br>
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery 2.2.3 -->
        <script type="text/javascript" src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script type="text/javascript" src="../../bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script type="text/javascript" src="../../plugins/iCheck/icheck.min.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/ajax/Login.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/sweet-alert.min.js"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>
