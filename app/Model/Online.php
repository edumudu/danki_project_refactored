<?php

namespace DevWeb\Model;

use DevWeb\Model\Database\DB;

class Online extends Model
{
  protected $tb = 'tb_admin.online';

  public function limparUsersOnline(){
    $date = date('Y-m-d H:i:s');
    DB::connect()->exec("DELETE FROM `$this->tb` WHERE `ultima_acao` < '$date' - INTERVAL 1 MINUTE");
  }
}

// EOF
