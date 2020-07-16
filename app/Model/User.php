<?php

namespace DevWeb\Model;

use DevWeb\Model\Online;

class User extends Model
{
  protected $tb = 'tb_admin.users';
  protected $used_fields = ['user', 'name', 'img', 'password', 'cargo'];

  public static function listUsersOnline(){
    $online = new Online;
    $online->limparUsersOnline();

    return $online->all();
  }
}

// EOF
