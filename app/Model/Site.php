<?php

namespace DevWeb\Model;

class Site extends Model
{
  protected $tb = 'tb_site.config';
  protected $used_fields = ['name_author', 'descricao', 'icone_1', 'icone_2', 'icone_3', 'descricao_1', 'descricao_2', 'descricao_3'];

    public static function verificaPermissaoPage($permissao){
      if(auth()->user->cargo < $permissao)
        include '../panel/pages/permissao-negada.php';
    }

    public static function verificaPermissaoAcao($permissao){
      if(auth()->user->cargo < $permissao)
        die(Painel::alert('error','Você não tem permição para realizar esta ação.'));
    }
}

// EOF
