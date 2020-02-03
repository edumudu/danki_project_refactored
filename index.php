<?php 
    include 'config.php'; 
    $aceptUrls = ['home','sobre', 'servicos'];
    Site::updateUserOnline();
    Site::contador();

    $infoSite = Painel::selectSingle('tb_site.config',['id' => 1]);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $infoSite['titulo'];?></title>
    <meta name="author" content="Eduardo Wesley" />
    <meta name="keywords" content="sistemas web,cursos de programação,desenvolvimento web,HTML5,CSS3, design responsivo" /> <!--Até umas 10 funciona bem-->
    <meta name="description" content="Esse site é desenvolvido pelos alunos da dankicode." />

    <!--Icon-->
    <link rel="icon" href="<?php echo INCLUDE_PATH;?>favicon.ico" type="iamge/x-icon" />
    <!--CSS-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH;?>css/all.min.css" />
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH;?>css/style.css" />
</head>
<body class="site">
    <div class="success">Formulario enviado com sucesso!</div>
    <div class="fail">Algo deu errado e seu formulario não foi enviado, por favor tente novamente mais tarde.</div>
    <div id="ajax-loader"><img src="images/ajax-loader.gif" /></div>

    <header>
        <div class="container flex space">
            <div class="logo">
                <a href="<?php echo INCLUDE_PATH; ?>">logomarca</a>
            </div><!--logo-->
            <nav class="desktop">
                <ul>
                    <li><a title="Home" href="<?php echo INCLUDE_PATH;?>">Home</a></li> <!--title otimiza o SEO-->
                    <li><a title="Sobre" href="<?php echo INCLUDE_PATH;?>sobre">Sobre</a></li>
                    <li><a title="Serviços" href="<?php echo INCLUDE_PATH;?>servicos">Serviços</a></li>
                    <li><a title="Contato" href="<?php echo INCLUDE_PATH;?>contato">Contato</a></li>
                    <li><a title="Noticias" href="<?php echo INCLUDE_PATH;?>news">Noticias</a></li>
                </ul>
            </nav><!--desktop-->

            <nav class="mobile">
                <i class="fas fa-bars"></i>
                <ul>
                <li><a href="<?php echo INCLUDE_PATH; ?>">Home</a></li>
                    <li><a title="Home" href="<?php echo INCLUDE_PATH; ?>sobre">Sobre</a></li>
                    <li><a title="Sobre" href="<?php echo INCLUDE_PATH; ?>servicos">Serviços</a></li>
                    <li><a title="Serviços" href="<?php echo INCLUDE_PATH; ?>contato">Contato</a></li>
                    <li><a title="Contato" href="<?php echo INCLUDE_PATH;?>news">Noticias</a></li>
                    <li><a title="Noticias" href="<?php echo INCLUDE_PATH;?>news">Noticias</a></li>
                </ul>
            </nav><!--mobile-->
        </div>
    </header>

    <main>

    <?php 

        $url = isset($_GET['url']) ? ($_GET['url'] !== '' ? $_GET['url'] : 'home') : 'home';

        if(file_exists("pages/$url.php"))
            include "pages/$url.php";
        else{
            //Podemos fazer oque quiser pois a pagina nao existe
            if(in_array($url, $aceptUrls)){
                echo '<target target='.$url.' />';
                include 'pages/home.php';
            }else{
                $urlPar = explode('/', $_GET['url'])[0];
                if($urlPar != 'news')
                    include "pages/404.php";
                else
                    include 'pages/news.php';
            }
        }
        

    ?>

    </main>

    <footer>
        <div class="container">
            <p>&copy; Todos os direitos reservados</p>
        </div>
    </footer>
    

    <!--scripts-->
    <script src="<?php echo INCLUDE_PATH;?>js/jquery-3.4.1.min.js"></script>
    <script src="<?php echo INCLUDE_PATH;?>js/functions.js"></script>
    <script src="<?php echo INCLUDE_PATH;?>js/slider.js"></script>

    <?php
        if($url == 'contato'){
    ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCB55nVGcJCy6JPUJZdgS9q_5wxsBwVkMw"></script>
    <script src="<?php echo INCLUDE_PATH;?>js/initMap.js"></script>
    <?php }?>
    
    <?php if(in_array($url, $aceptUrls)){?>
    <!--<script src="<?php //echo INCLUDE_PATH;?>js/loadTimer.js"></script>-->
    <?php }?>

    <script src="<?php echo INCLUDE_PATH;?>js/formularios.js"></script>

    <?php
        if(strstr($url,'news') !== false){
    ?>
    <script src="<?php echo INCLUDE_PATH;?>js/news.js"></script>
    <?php }?>
</body>
</html>