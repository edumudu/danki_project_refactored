<?php

namespace DevWeb\Model;

class Online extends Model
{
  protected $tb = 'tb_admin.online';

  public function limparUsersOnline(){
    $date = date('Y-m-d H:i:s');
    $sql = mySQL::connect()->exec("DELETE FROM `$this->tb` WHERE `ultima_acao` < '$date' - INTERVAL 1 MINUTE");
}
}

// EOF
