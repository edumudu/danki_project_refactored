<?php

namespace DevWeb\Control\Panel;

use DevWeb\Model\Depoiment;

class DepoimentosController extends ControllerPanel
{
  protected $base_uri = '/depoiments';
  protected $edit_level = 1;

  public function __construct()
  {
    parent::__construct();
    $this->depoiment = new Depoiment;
  }

  /**
   * 
   */
  public function index () 
  {
    $view = $this->view('Panel\\ViewPanel');

    $currentPage = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $total_pages = ceil(count($this->depoiment->all(['id'])) / $this->perPage);
    $depoiments = $this->depoiment->all(
      ['*'],
      null,
      'order_id ASC',
      ($currentPage - 1) * $this->perPage,
      $this->perPag
    );

    $view->render('templates/list-template', [
      "can_edit"    => $this->cargo >= $this->edit_level,
      "base_uri"    => $this->base_uri,
      "data" => [
        "total_pages" => $total_pages,
        "results"     => $depoiments,
        "currentPage" => $currentPage,
        "columns"     => $this->depoiment->getFields()
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
      "columns"     => $this->depoiment->getFields()
    ]);
  }

  public function store ()
  {
    if (!isset($_POST)) return;

    $data['name'] = $_POST['name'];
    $data['depoimento'] = $_POST['depoimento'];

    $this->depoiment->create($data);

    return self::redirect('/panel' . $this->base_uri . '/create');
  }

  public function edit ()
  {
    if ( $this->cargo <= $this->edit_level )
      return;

    $view = $this->view('Panel\\ViewPanel');

    if(isset($_GET['id'])){
      $id = (int)$_GET['id'];
      $depoiment = $this->depoiment->selectSingle(['id' => $id]);
    }else {
      die(Painel::alert('error','Você precisa pasar o parametro id.'));
    }

    $view->render('templates/edit-template', [
      "menus"     => $this->menus_actives,
      "columns"   => $this->depoiment->getFields(),
      "item"      => $depoiment
    ]);
  }

  public function update ()
  {
    if (!isset($_POST)) return;

    $data['name'] = $_POST['name'];
    $data['depoimento'] = $_POST['depoimento'];

    $this->depoiment->update($data, ['id' => (int)$_GET['id']]);

    return self::redirect('/panel' . $this->base_uri);
  }

  public function destroy ()
  {
    if (isset($_GET['excluir'])) {
      $id = (int)$_GET['excluir'];

      $this->depoiment->delete(['id' => $id]);
    }
  }

  public function order () {
    $order = $_POST['order'];
    $id = $_POST['id'];

    if(!($order && $id))
      return;

    $this->depoiment->order($id, $order);
  }
}

// EOF
