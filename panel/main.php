<?php

    if(isset($_GET['logout'])){
        Painel::logout();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Painel de controle</title>

        <!--Icon-->
        <link rel="icon" href="<?= INCLUDE_PATH;?>favicon.ico" type="iamge/x-icon" />
        <!--CSS-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?= INCLUDE_PATH;?>css/all.min.css" />
        <link rel="stylesheet" href="<?= INCLUDE_PATH_PANEL;?>css/stylePanel.css" />
    </head>
    <body>
        <div class="panel-top">
            <aside>
                <div class="aside-wrapper">
                    <div class="box-user">
                        <?php
                            if($_SESSION['img'] == ''){
                        ?>
                        <div class="avatar-user">
                            <i class="fas fa-user"></i>
                        </div><!--avatar-user-->
                        <?php }else{ ?>
                            <div class="img-user">
                                <img src="<?= INCLUDE_PATH_PANEL.'uploads/'.$_SESSION['img'];?>" />
                            </div><!--avatar-user-->
                        <?php } ?>

                        <div class="username">
                            <p><?= $_SESSION['name'];?></p>
                            <p class="cargo"><?= getCargo($_SESSION['cargo']);?></p>
                        </div>
                    </div><!--box-user-->

                    <div class="menu-items">
                        <h2>Cadastro</h2>
                        <ul class="cadastro">
                            <li <?php Site::verificaPermissaoMenu(1); ?> ><a <?php selectedMenu('add-depoimento'); ?> href="<?= INCLUDE_PATH_PANEL?>add-depoimento">Cadastrar Depoimento</a></li>
                            <li <?php Site::verificaPermissaoMenu(1); ?>><a <?php selectedMenu('add-servico'); ?> href="<?= INCLUDE_PATH_PANEL;?>add-servico">Cadastrar Serviço</a></li>
                            <li><a <?php selectedMenu('add-slides'); ?> href="<?= INCLUDE_PATH_PANEL;?>add-slides">Cadastrar Slides</a></li>
                        </ul>

                        <h2>Gestão</h2>
                        <ul class="gestao">
                            <li><a <?php selectedMenu('list-depoimentos'); ?> href="<?= INCLUDE_PATH_PANEL?>list-depoimentos">Listar Depoimentos</a></li>
                            <li><a <?php selectedMenu('list-servicos'); ?> href="<?= INCLUDE_PATH_PANEL?>list-servicos">Listar Serviços</a></li>
                            <li><a <?php selectedMenu('list-slides'); ?> href="<?= INCLUDE_PATH_PANEL;?>list-slides">Listar Slides</a></li>
                        </ul>

                        <h2>Administração do painel</h2>
                        <ul class="gestao">
                            <li><a <?php selectedMenu('editar-user'); ?> href="<?= INCLUDE_PATH_PANEL;?>editar-user">Editar Usuario</a></li>
                            <li <?php Site::verificaPermissaoMenu(2); ?> ><a <?php selectedMenu('add-user'); ?> href="<?= INCLUDE_PATH_PANEL;?>add-user">Adicionar Usuarios</a></li>
                        </ul>

                        <h2>Configuração geral</h2>
                        <ul class="gestao">
                            <li><a <?php selectedMenu('edit-site'); ?> href="<?= INCLUDE_PATH_PANEL;?>edit-site">Editar Site</a></li>
                        </ul>

                        <h2>Gestão de Noticias</h2>
                        <ul class="gestao">
                            <li><a <?php selectedMenu('add-categoria');?> href="<?= INCLUDE_PATH_PANEL;?>add-categoria">Cadastrar Categorias</a></li>
                            <li><a <?php selectedMenu('list-categorias');?> href="<?= INCLUDE_PATH_PANEL;?>list-categorias">Listar Categorias</a></li>
                            <li><a <?php selectedMenu('add-notice');?> href="<?= INCLUDE_PATH_PANEL;?>add-notice">Cadastrar Noticias</a></li>
                            <li><a <?php selectedMenu('list-notices');?> href="<?= INCLUDE_PATH_PANEL;?>list-notices">Listar Noticias</a></li>
                        </ul>

                        <h2>Gestão de Clientes</h2>
                        <ul class="gestao">
                            <li><a <?php selectedMenu('add-clients');?> href="<?= INCLUDE_PATH_PANEL;?>add-clients">Cadastrar Clientes</a></li>
                            <li><a <?php selectedMenu('list-clients');?> href="<?= INCLUDE_PATH_PANEL;?>list-clients">Gerenciar Clientes</a></li>
                        </ul>
                    </div>
                </div>
            </aside>

            <div>
                <header>

                <div class="container">
                    <div class="menu-btn">
                        <i class="fas fa-bars"></i>
                    </div>

                    

                    <div class="icons-header">
                        <div class="btn-home">
                            <a class="<?= $_GET['url'] == '' ? 'active' : '';?>" href="<?= INCLUDE_PATH_PANEL?>"><i class="fas fa-home"></i> <span>Página inicial</span></a>
                        </div><!--btn-home-->

                        <div class="logout">
                            <a href="<?= INCLUDE_PATH_PANEL;?>?logout"><i class="fas fa-sign-out-alt"></i> <span>Sair</span></a>
                        </div><!--logout-->
                    </div>
                </div>
                </header>
                
                <main>
                    
                    <?php
                        Painel::loadpage();
                    ?>

                </main>
            </div>
        </div>

        <script src="<?= INCLUDE_PATH;?>js/jquery-3.4.1.min.js"></script>
        <script src="<?= INCLUDE_PATH;?>js/jquery.mask.js"></script>
        <script src="<?= INCLUDE_PATH_PANEL;?>js/main.js"></script>
        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script src="<?= INCLUDE_PATH_PANEL;?>js/jquery.form.min.js"></script>
        <script src="<?= INCLUDE_PATH_PANEL;?>js/helperMask.js"></script>
        <script src="<?= INCLUDE_PATH_PANEL;?>js/ajax.js"></script>

        <?php

        Painel::loadJS(['clients.js'], 'list-clients',);

        ?>

        <script>
            tinymce.init({
                selector: '.tinymce',
                plugins: 'image',
                height: 300,
                menubar: 'insert'
            });
        </script>
    </body>
</html>