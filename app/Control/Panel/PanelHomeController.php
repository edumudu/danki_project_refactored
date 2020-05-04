<?php

namespace DevWeb\Control\Panel;

use DevWeb\Model\User;
use DevWeb\Model\Visita;

class PanelHomeController extends ControllerPanel
{
  public function index()
  {
    $user = new User;
    $visita = new Visita;

    $view = $this->view('Panel\\ViewPanel');
    $view->render('home', [
      'title'               => 'Panel',
      'usuariosOnline'      => $user->listUsersOnline(),
      'usuariosCadastrados' => $user->selectAll(),
      'totalVisitas'        => count($visita->selectAll()),
      'visitasHoje'         => count($visita->selectAll(['id'], ['dia' => date('Y-m-d')])),
      'menus'               => $this->menus_actives
    ]);
  }
}

// EOF
