<?php
/*
    Todo: Variavel global cargos.
*/

    session_start();
    date_default_timezone_set('America/Sao_Paulo');

    $autoload = function($class){
        if($class == "Email"){
            require_once("classes/PHPMailer/src/Exception.php");
            require_once("classes/PHPMailer/src/PHPMailer.php");
            require_once("classes/PHPMailer/src/SMTP.php");
        }
        
        include('classes/'.$class.'.php');
    };

    spl_autoload_register($autoload);

    define('INCLUDE_PATH', 'http://localhost/Curso_Desenvolvimento_Web_Completo/Projetos/Projeto_01/');
    define('INCLUDE_PATH_PANEL',INCLUDE_PATH.'panel/');

    define('BASE_DIR_PANEL', __DIR__.'/panel/');

    //Database
    define('HOST','localhost');
    define('USER','root');
    define('PASSWORD','');
    define('DATABASE','projeto_01');

    //Constantes para o painle de controle
    define('NOME_EMPRESA','Danki Code');    

    //Funcoes do painel
    function getCargo($cargo){
        return Painel::$cargos[$cargo];
    }

    function selectedMenu($par){
        $url = explode('/',@$_GET['url'])[0];
        if($url == $par){
            echo 'class="active"';
        }
    }

    function recoverPost($key){
        if(isset($_POST[$key])){
            echo $_POST[$key];
        }
    }

?>