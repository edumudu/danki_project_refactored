<?php

namespace DevWeb\Control\Panel;

use DevWeb\Control\Controller;
use DevWeb\Route;
use DevWeb\Model\Painel;

class ControllerPanel extends Controller
{
  protected $cargo = -1;
  protected $cargo_text = '';
  protected $is_needed_login = true;
  protected $raw_menus = [
    [
      'access_level' => 0,
      'text'         => 'Cadastrar Depoimento',
      'path'         => 'add-depoimento'
    ],
    [
      'access_level' => 1,
      'text'         => 'Cadastrar Serviço',
      'path'         => 'add-servico'
    ],
    [
      'access_level' => 0,
      'text'         => 'Cadastrar Slides',
      'path'         => 'add-slides'
    ],
    [
      'access_level' => 0,
      'text'         => 'Listar Depoimentos',
      'path'         => 'list-depoimentos'
    ],
    [
      'access_level' => 0,
      'text'         => 'Listar Serviços',
      'path'         => 'list-servicos'
    ],
    [
      'access_level' => 0,
      'text'         => 'Listar Slides',
      'path'         => 'list-slides'
    ],
    [
      'access_level' => 0,
      'text'         => 'Editar Usuario',
      'path'         => 'editar-user'
    ],
    [
      'access_level' => 2,
      'text'         => 'Adicionar Usuarios',
      'path'         => 'add-user'
    ],
    [
      'access_level' => 0,
      'text'         => 'Editar Site',
      'path'         => 'edit-site'
    ],
    [
      'access_level' => 0,
      'text'         => 'Cadastrar Categorias',
      'path'         => 'add-categoria'
    ],
    [
      'access_level' => 0,
      'text'         => 'Listar Categorias',
      'path'         => 'list-categorias'
    ],
    [
      'access_level' => 0,
      'text'         => 'Cadastrar Noticias',
      'path'         => 'add-notice'
    ],
    [
      'access_level' => 0,
      'text'         => 'Listar Noticias',
      'path'         => 'list-notices'
    ],
    [
      'access_level' => 0,
      'text'         => 'Cadastrar Clientes',
      'path'         => 'add-clients'
    ],
    [
      'access_level' => 0,
      'text'         => 'Gerenciar Clientes',
      'path'         => 'list-clients'
    ],
  ];
  protected $menus_actives = [];

  public function __construct()
  {
    if (!$is_needed_login && !$_SESSION['login'])
      Route::redirect('panel/login');
    
    $this->cargo = $_SESSION['cargo'];
    $this->cargo_text = Painel::$cargos[$this->cargo];

    $this->menus_actives = array_filter($this->raw_menus, function ($menu) { return $menu['access_level'] >= $cargo; });
  }
}

// EOF