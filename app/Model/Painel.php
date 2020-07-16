<?php

namespace DevWeb\Model;

class Painel{
    public static function loadJS($files, $page){
        $url = explode('/', $_GET['url'])[0];
        if($page == $url){
            foreach($files as $file){
                echo "<script src='".INCLUDE_PATH_PANEL."js/$file'></script>";
            }
        }
    }

    /**
     * @param string $type Uma string informando o tipo de alerta que eu desejo imprimir
     * @param string $message Uma string contendo ao menssagem Quer eu devo imprimir
     * 
     * @return void
     */

    public static function alert($type, $message){
        switch($type){
            case 'success':
                echo '<div class="success"><i class="fas fa-check"></i> '.$message.'</div>';
                break;
            case 'error':
                echo '<div class="error"><i class="fas fa-exclamation-circle"></i> '.$message.'</div>';
                break;
        }
    }

    public static function cleanUrlJs($url){
        echo "<script>window.history.pushState('','','$url')</script>";
    }
}

// EOF
