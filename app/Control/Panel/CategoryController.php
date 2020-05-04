<?php

namespace DevWeb\Control\Panel;

use DevWeb\Model\Category;

class CategoryController extends ControllerPanel
{
  protected $base_uri = '/category';
  protected $edit_level = 1;

  public function __construct()
  {
    parent::__construct();
    $this->category = new Category;
  }

  /**
   * 
   */
  public function index () 
  {
    $view = $this->view('Panel\\ViewPanel');

    $currentPage = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $total_pages = ceil(count($this->category->selectAll(['id'])) / $this->perPage);
    $categorys = $this->category->selectAll(
      ['*'],
      null,
      'order_id ASC',
      ($currentPage - 1) * $this->perPage,
      $this->perPag
    );

    $view->render('templates/list-template', [
      "can_edit"    => $this->cargo >= $this->edit_level,
      "base_uri"    => $this->base_uri,
      "items" => [
        "total_pages" => $total_pages,
        "results"     => $categorys,
        "currentPage" => $currentPage,
        "columns"     => $this->category->getColumns()
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
      "title"       => 'Create category',
      "menus"       => $this->menus_actives,
      "columns"     => $this->category->getFields()
    ]);
  }

  public function store ()
  {
    if (!isset($_POST)) return;

    $data['name'] = $_POST['name'];
    $this->category->insert($data);

    return self::redirect('/panel' . $this->base_uri . '/create');
  }

  public function edit ()
  {
    if ( $this->cargo <= $this->edit_level )
      return;

    $view = $this->view('Panel\\ViewPanel');

    if(isset($_GET['id'])){
      $id = (int)$_GET['id'];
      $service = $this->category->selectSingle(['id' => $id]);
    }else {
      die(Painel::alert('error','Você precisa pasar o parametro id.'));
    }

    $view->render('templates/edit-template', [
      "menus"     => $this->menus_actives,
      "columns"   => $this->category->getFields(),
      "item"      => $service
    ]);
  }

  public function update ()
  {
    if (!isset($_POST)) return;

    $data['name'] = $_POST['name'];

    $this->category->update($data, ['id' => (int)$_GET['id']]);

    return self::redirect('/panel' . $this->base_uri);
  }

  public function destroy ()
  {
    if (isset($_GET['excluir'])) {
      $id = $_GET['excluir'];

      $this->category->delete(['id' => $id]);
    }
  }
}

// EOF
