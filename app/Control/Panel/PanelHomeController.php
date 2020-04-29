<?php

namespace DevWeb\Control\Panel;

use DevWeb\Control\Controller;
use DevWeb\Model\Usuario;
use DevWeb\Model\Painel;

class PanelHomeController extends ControllerPanel
{
  public function index()
  {
    $view = $this->view('Panel\\ViewPanel');
    $view->render('home', [
      'title'               => 'Panel',
      'usuariosOnline'      => Usuario::listUsersOnline(),
      'usuariosCadastrados' => Painel::selectAll('tb_admin.users'),
      'totalVisitas'        => count(Painel::selectAll('tb_admin.visitas')),
      'visitasHoje'         => count(Painel::selectAll('tb_admin.visitas', ['id'], ['dia' => date('Y-m-d')])),
      'menus'               => $this->menus_actives,
      'cargo_text'          => $this->cargo_text
    ]);
  }
}

// EOF
