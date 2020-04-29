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
    [
      'access_level' => 0,
      'text'         => 'Cadastrar Depoimento',
      'path'         => 'depoiments/create'
    ],
    [
      'access_level' => 1,
      'text'         => 'Cadastrar Serviço',
      'path'         => 'service/create'
    ],
    [
      'access_level' => 0,
      'text'         => 'Cadastrar Slides',
      'path'         => 'slide/create'
    ],
    [
      'access_level' => 0,
      'text'         => 'Listar Depoimentos',
      'path'         => 'depoiments'
    ],
    [
      'access_level' => 0,
      'text'         => 'Listar Serviços',
      'path'         => 'service'
    ],
    [
      'access_level' => 0,
      'text'         => 'Listar Slides',
      'path'         => 'slide'
    ],
    [
      'access_level' => 0,
      'text'         => 'Editar Usuario',
      'path'         => 'user/edit'
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
      'path'         => 'category/create'
    ],
    [
      'access_level' => 0,
      'text'         => 'Listar Categorias',
      'path'         => 'category'
    ],
    [
      'access_level' => 0,
      'text'         => 'Cadastrar Noticias',
      'path'         => 'notice/create'
    ],
    [
      'access_level' => 0,
      'text'         => 'Listar Noticias',
      'path'         => 'notice'
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
    if ($this->is_needed_login && !$_SESSION['login'])
      Route::redirect('panel/login');
    
    $this->cargo = $_SESSION['cargo'];
    $this->cargo_text = Painel::$cargos[$this->cargo];

    $this->menus_actives = array_filter($this->raw_menus, function ($menu) { return $menu['access_level'] <= $this->cargo; });
  }

  public function getUsedFields()
  {
    $columns = mySQL::getColumnsStats($this->tb);
    $columns = array_filter($columns, fn($val) => in_array($val['COLUMN_NAME'], $this->used_fields));

    return $columns;
  }

  /**
   * 
   */
  public function index () 
  {
    $view = $this->view('Panel\\ViewPanel');

    $currentPage = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $total_pages = ceil(count(Painel::selectAll($this->tb, ['id'])) / $this->perPage);
    $services = Painel::selectAll(
      $this->tb,
      ['*'],
      null,
      'order_id ASC',
      ($currentPage - 1) * $this->perPage,
      $this->perPag
    );

    $view->render('templates/list-template', [
      "tb"          => $this->tb,
      "can_edit"    => $this->cargo >= $this->edit_level,
      "base_uri"    => $this->base_uri,
      "items" => [
        "total_pages" => $total_pages,
        "results"     => $services,
        "currentPage" => $currentPage,
        "columns"     => mySQL::getColumnsStats($this->tb)
      ],
      "menus"         => $this->menus_actives
    ]);
  }

  public function create ()
  {
    if ( $this->cargo <= $this->edit_level )
      return;

    $view = $this->view('Panel\\ViewPanel');

    $view->render('templates/create-template', [
      "menus"   => $this->menus_actives,
      "columns" => $this->getUsedFields()
    ]);
  }

  public function store ()
  {
    if (!isset($_POST)) return;

    $data = array_filter($_POST, fn($key) => in_array($key, $this->used_fields), ARRAY_FILTER_USE_KEY);
    Painel::insert($this->tb, $data, true);

    return Route::redirect('panel/' . $this->base_uri . '/create');
  }

  public function edit ()
  {
    if ( $this->cargo <= $this->edit_level )
      return;

    $view = $this->view('Panel\\ViewPanel');

    if(isset($_GET['id'])){
      $id = (int)$_GET['id'];
      $service = Painel::selectSingle($this->tb, ['id' => $id]);
    }else {
      die(Painel::alert('error','Você precisa pasar o parametro id.'));
    }

    $view->render('templates/edit-template', [
      "menus"   => $this->menus_actives,
      "columns" => $this->getUsedFields(),
      "item"    => $service
    ]);
  }

  public function update ()
  {
    if (!isset($_POST)) return;

    $data = array_filter($_POST, fn($key) => in_array($key, $this->used_fields), ARRAY_FILTER_USE_KEY);
    Painel::update($this->tb, $data, ['id' => (int)$_GET['id']]);

    return Route::redirect('panel/' . $this->base_uri);
  }

  public function destroy ()
  {
    if (isset($_GET['excluir']))
      Painel::deleteRegistro($this->tb, ['id' => $_GET['excluir']]);
  }
}

// EOF