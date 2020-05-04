<?php

namespace DevWeb\Control\Panel;

use DevWeb\Model\Painel;
use DevWeb\Model\User;

class SessionController extends ControllerPanel
{
  protected $is_needed_login = false;

  public function create() {
    $this->verifyCookie();

    if ($_SESSION['login'])
      self::redirect(INCLUDE_PATH_PANEL);

    $view = $this->view('Panel\\ViewPanel');
    $view->render('auth/login', [
      'title' => 'Login',
    ], false);
  }

  public function store ($data)
  {
    $this->verifyCookie();

    $user = new User;

    $username = $data['username'];
    $password = $data['password'];

    $info_login = $user->equalsExisist(['user' => $username, 'password' => $password]);
    
    if($info_login){
      if(isset($data['remember-login'])){
          setcookie('lembrar',true, time() + (60*60*24*2), '/');
          setcookie('user', $username, time() + (60*60*24*2), '/');
          setcookie('password', $password, time() + (60*60*24*2), '/');
      }
      
      $this->setSession($info_login);
      self::redirect(INCLUDE_PATH_PANEL);
    }else{
      Painel::alert('error','Usuario ou senha incorretos!');
    }
  }

  public function destroy()
  {
    session_destroy();
    setcookie('lembrar', null, time() - 1, '/');
    setcookie('user', null, time() - 1, '/');
    setcookie('password', null, time() - 1, '/');
    self::redirect(INCLUDE_PATH_PANEL);
  }

  private function setSession ($info)
  {
    $_SESSION['login'] = true;
    $_SESSION['id'] = $info['id'];
    $_SESSION['user'] = $info['user'];
    $_SESSION['cargo'] = $info['cargo'];
    $_SESSION['name'] = $info['name'];
    $_SESSION['img'] = $info['img'];
  }

  private function verifyCookie ()
  {
    $user = new User;

    if(isset($_COOKIE['lembrar'])){
      $username = $_COOKIE['user'];
      $password = $_COOKIE['password'];

      $info_login = $user->equalsExisist(array('user' => $username, 'password' => $password));

      if($info_login){
        $this->setSession($info_login);
        self::redirect(INCLUDE_PATH_PANEL);
      }
    }
  }
}

// EOF
