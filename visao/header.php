<header class="main-header">

    <!-- Logo -->
    <a href="../visao/home.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">GC</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>GestCCon</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php
                        if ($_SESSION["imagem"] != NULL && $_SESSION["imagem"] != "") {
                            echo '<img src="',LOCAL_ARQUIVO, $_SESSION["imagem"], '" class="user-image" alt="Imagem usuário">';
                        } else {
                            echo '<img src="img/sem_imagem.png" class="user-image" alt="Imagem usuário">';
                        }
                        ?>                    
                        <span class="hidden-xs"><?= $_SESSION["nome"] ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?php
                            if ($_SESSION["imagem"] != NULL && $_SESSION["imagem"] != "") {
                                echo '<img src="',LOCAL_ARQUIVO, $_SESSION["imagem"], '" class="user-image" alt="Imagem usuário">';
                            } else {
                                echo '<img src="img/sem_imagem.png" class="user-image" alt="Imagem usuário">';
                            }
                            ?>                             
                            <p>
                                <?= $_SESSION["nome"] ?>
                                <small>
                                    Membro desde
                                    <?php echo date("d/m/Y", strtotime($_SESSION["dtcadastro"]));?>
                                </small>
                                <small>
                                    Perfil <?=$_SESSION["nivel"]?>
                                </small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="/visao/Pessoa.php?codpessoa=<?=  ($_SESSION["codpessoa"])?>" class="btn btn-default btn-flat">Perfil</a>
                            </div>
                            <div class="pull-right">
                                <a href="/visao/Logout.php" class="btn btn-default btn-flat">Sair</a>
                            </div>
                        </li>
                    </ul>
                </li>
<!--                 Control Sidebar Toggle Button 
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>-->
            </ul>
        </div>
    </nav>
</header>