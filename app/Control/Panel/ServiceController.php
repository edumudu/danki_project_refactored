<?php

namespace DevWeb\Control\Panel;

use DevWeb\Model\Service;

class ServiceController extends ControllerPanel
{
  protected $base_uri = '/service';
  protected $edit_level = 1;

  public function __construct()
  {
    parent::__construct();
    $this->service = new Service;
  }

  public function index () 
  {
    $view = $this->view('Panel\\ViewPanel');

    $currentPage = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $total_pages = ceil(count($this->service->selectAll(['id'])) / $this->perPage);
    $services = $this->service->selectAll(
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
        "results"     => $services,
        "currentPage" => $currentPage,
        "columns"     => $this->service->getColumns()
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
      "title"       => 'Create depoiment',
      "menus"       => $this->menus_actives,
      "columns"     => $this->service->getFields()
    ]);
  }

  public function store ()
  {
    if (!isset($_POST)) return;

    $data['servico'] = $_POST['servico'];

    $this->service->insert($data);

    return self::redirect('/panel' . $this->base_uri . '/create');
  }

  public function edit ()
  {
    if ( $this->cargo <= $this->edit_level )
      return;

    $view = $this->view('Panel\\ViewPanel');

    if(isset($_GET['id'])){
      $id = (int)$_GET['id'];
      $service = $this->service->selectSingle(['id' => $id]);
    }else {
      die(Painel::alert('error','Você precisa pasar o parametro id.'));
    }

    $view->render('templates/edit-template', [
      "menus"     => $this->menus_actives,
      "columns"   => $this->service->getFields(),
      "item"      => $service
    ]);
  }

  public function update ()
  {
    if (!isset($_POST)) return;

    $data['servico'] = $_POST['servico'];

    $this->service->update($data, ['id' => (int)$_GET['id']]);

    return self::redirect('/panel' . $this->base_uri);
  }

  public function destroy ()
  {
    if (isset($_GET['excluir'])) {
      $id = (int)$_GET['excluir'];

      $this->service->delete(['id' => $id]);
    }
  }
}

// EOF
