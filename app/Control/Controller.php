<?php

namespace DevWeb\Control;

use DevWeb\Model\Online;
use DevWeb\Model\Visita;

class Controller
{
  public function __construct()
  {
      self::update_users_online();
  }

  public function view($viewname)
  {
      $view = '\DevWeb\View\\' . $viewname;
      return $view = new $view;
  }

  protected static function update_users_online()
  {
    $online = new Online;

    if(isset($_SESSION['online'])){
      $token = $_SESSION['online'];
      $horarioAtual = date('Y-m-d H:i:s');
      $check = $online->equalsExisist(['token' => $token]);

      if($check){
        $online->update(['ultima_acao' => $horarioAtual], ['token' => $token]);
      } else {
        unset($_SESSION['online']);
        self::update_users_online();
      }
    } else {
        $_SESSION['online'] = uniqid();
        $ip = getIP();
        $data = [
            "ip" => $ip, // Ip do usuario que esta vizualiazando
            "token" => $_SESSION['online'] // Token unico
        ];

        $online->insert($data);
    }

    if(!isset($_COOKIE['visita'])){
      $visita = new Visita;
      setcookie('visita', true, time() + (60*60*24*14)); // Cookie expira em 14 dias
      $visita->insert(['ip' => getIP(), 'dia' => date('Y-m-d')]);
    }
  }

  public static function redirect($url){
    die('<script>location.href = "' . $url . '";</script>');
  }
}

// EOF
