<?php

namespace DevWeb\Control\Panel;

use DevWeb\Control\Controller;
use DevWeb\Model\Painel;

class SessionController extends ControllerPanel
{
  public function __construct() {
    $this->is_needed_login = false;
  }

  public function execute()
  {
    $view = $this->view('Panel\\ViewPanel');

    if(isset($_COOKIE['lembrar'])){
      $user = $_COOKIE['user'];
      $password = $_COOKIE['password'];

      $info_login = Painel::equalsExisist('tb_admin.users',array('user' => $user, 'password' => $password));
      if($info_login){
        $_SESSION['login'] = true;
        $_SESSION['user'] = $user;
        $_SESSION['password'] = $password;
        $_SESSION['cargo'] = $info_login['cargo'];
        $_SESSION['name'] = $info_login['name'];
        $_SESSION['img'] = $info_login['img'];
        Painel::redirect(INCLUDE_PATH_PANEL);
      }
    }

    if ($_SESSION['login'])
      Painel::redirect(INCLUDE_PATH_PANEL);

    $view->render('login', [
      'title'               => 'Login',
    ], false);
  }

  public function create($data) {
    if(isset($data['logar'])){
      $user = $data['username'];
      $password = $data['password'];


      $info_login = Painel::equalsExisist('tb_admin.users', array('user' => $user, 'password' => $password));
      
      if($info_login){
          if(isset($data['remember-login'])){
              setcookie('lembrar',true, time() + (60*60*24*2), '/');
              setcookie('user', $user, time() + (60*60*24*2), '/');
              setcookie('password', $password, time() + (60*60*24*2), '/');
          }
          
          $_SESSION['login'] = true;
          $_SESSION['user'] = $user;
          $_SESSION['password'] = $password;
          $_SESSION['cargo'] = $info_login['cargo'];
          $_SESSION['name'] = $info_login['name'];
          $_SESSION['img'] = $info_login['img'];
          Painel::redirect(INCLUDE_PATH_PANEL);
      }else{
          Painel::alert('error','Usuario ou senha incorretos!');
      }
    }
  }
}

// EOF
