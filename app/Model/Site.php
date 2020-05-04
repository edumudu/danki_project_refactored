<?php

namespace DevWeb\Model;

class Site extends Model
{
  protected $tb = 'tb_site.config';

    public static function verificaPermissaoPage($permissao){
        if($_SESSION['cargo'] < $permissao)
            include '../panel/pages/permissao-negada.php';
    }

    public static function verificaPermissaoAcao($permissao){
        if($_SESSION['cargo'] < $permissao)
            die(Painel::alert('error','Você não tem permição para realizar esta ação.'));
    }
}

// EOF
