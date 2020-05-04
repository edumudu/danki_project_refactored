<?php

namespace DevWeb\Control\Panel;

use DevWeb\Control\Controller;
use DevWeb\Route;
use DevWeb\Model\Painel;
use DevWeb\Model\mySQL;

class ControllerPanel extends Controller
{
  protected $cargo = -1;
  protected $cargo_text = '';
  protected $is_needed_login = true;
  protected $perPage = 10;
  protected $edit_level = 1;
  protected $used_fields = ['depoimento', 'name'];

  protected $raw_menus = [
    "Cadastro" => [
      [
        'access_level' => 0,
        'text'         => 'Cadastrar Depoimento',
        'path'         => '/depoiments/create'
      ],
      [
        'access_level' => 1,
        'text'         => 'Cadastrar Serviço',
        'path'         => '/service/create'
      ],
      [
        'access_level' => 0,
        'text'         => 'Cadastrar Slides',
        'path'         => '/slide/create'
      ],
      [
        'access_level' => 0,
        'text'         => 'Cadastrar Categorias',
        'path'         => '/category/create'
      ],
      [
        'access_level' => 0,
        'text'         => 'Cadastrar Noticias',
        'path'         => '/notice/create'
      ],
      [
        'access_level' => 0,
        'text'         => 'Cadastrar Clientes',
        'path'         => '/client/create'
      ],
      [
        'access_level' => 2,
        'text'         => 'Cadastrar Usuarios',
        'path'         => '/user/create'
      ],
    ],

    "gestão" => [
      [
        'access_level' => 0,
        'text'         => 'Listar Depoimentos',
        'path'         => '/depoiments'
      ],
      [
        'access_level' => 0,
        'text'         => 'Listar Serviços',
        'path'         => '/service'
      ],
      [
        'access_level' => 0,
        'text'         => 'Listar Slides',
        'path'         => '/slide'
      ],
      [
        'access_level' => 0,
        'text'         => 'Listar Categorias',
        'path'         => '/category'
      ],
      [
        'access_level' => 0,
        'text'         => 'Listar Noticias',
        'path'         => '/notice'
      ],
      [
        'access_level' => 0,
        'text'         => 'Listar Clientes',
        'path'         => '/list-clients'
      ],
    ],

    "configuração geral" => [
      [
        'access_level' => 0,
        'text'         => 'Editar Usuario',
        'path'         => '/user/edit'
      ],
      
      [
        'access_level' => 0,
        'text'         => 'Editar Site',
        'path'         => '/site/edit
      ],
    ]
  ];

  protected $menus_actives = [];

  public function __construct()
  {
    if ($this->is_needed_login && !$_SESSION['login'])
      Route::redirect('/panel/login');
    
    $this->cargo = $_SESSION['cargo'];

    $this->menus_actives = array_filter($this->raw_menus, function ($menu) { return $menu['access_level'] <= $this->cargo; });
  }
}

// EOF