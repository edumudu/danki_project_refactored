<?php
/*
    Todo: Variavel global cargos.
*/

    session_start();
    date_default_timezone_set('America/Sao_Paulo');

    define('PATH', 'http://localhost:8000/');
    define('INCLUDE_PATH_PANEL', PATH.'panel/');

    define('BASE_DIR', __DIR__);

    //Database
    define('HOST','127.0.0.1');
    define('USER','root');
    define('PASSWORD','password');
    define('DATABASE','projeto_01');

    //Constantes para o painle de controle
    define('NOME_EMPRESA','Danki Code');    

    function recoverPost($key){
        if(isset($_POST[$key])){
            echo $_POST[$key];
        }
    }

?>