<?php

namespace DevWeb\Control\Panel;

use DevWeb\Model\Slide;
use DevWeb\Model\File;

class SlideController extends ControllerPanel
{
  protected $base_uri = '/slide';
  protected $image_field = 'slide';
  protected $edit_level = 1;

  public function __construct()
  {
    parent::__construct();
    $this->slide = new Slide;
  }

  public function index () 
  {
    $view = $this->view('Panel\\ViewPanel');

    $currentPage = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $total_pages = ceil(count($this->slide->selectAll(['id'])) / $this->perPage);
    $slides = $this->slide->selectAll(
      ['*'],
      null,
      'order_id ASC',
      ($currentPage - 1) * $this->perPage,
      $this->perPag
    );

    $view->render('templates/list-template', [
      "can_edit"      => $this->cargo >= $this->edit_level,
      "base_uri"      => $this->base_uri,
      "items"         => [
        "total_pages" => $total_pages,
        "results"     => $slides,
        "currentPage" => $currentPage,
        "columns"     => $this->slide->getColumns()
      ],
      "menus"         => $this->menus_actives,
      "img_field"     => $this->image_field
    ]);
  }

  public function create ()
  {
    if ( $this->cargo <= $this->edit_level )
      return;

    $view = $this->view('Panel\\ViewPanel');

    $view->render('templates/create-template', [
      "title"     => 'Create depoiment',
      "menus"     => $this->menus_actives,
      "columns"   => $this->slide->getFields(),
      "img_field" => $this->image_field
    ]);
  }

  public function store ()
  {
    if (!isset($_POST)) return;

    $img = $_FILES['slide'];

    if (!File::validImg($img)) {
      return;
    }
    
    $img = File::uploadFile($img);
    $data['name'] = $_POST['name'];
    $data['slide'] = $img ?: null;

    $this->slide->insert($data);

    return self::redirect('/panel' . $this->base_uri . '/create');
  }

  public function edit ()
  {
    if ( $this->cargo <= $this->edit_level )
      return;

    $view = $this->view('Panel\\ViewPanel');

    if(isset($_GET['id'])){
      $id = (int)$_GET['id'];
      $slide = $this->slide->selectSingle(['id' => $id]);
    }else {
      die(Painel::alert('error','Você precisa pasar o parametro id.'));
    }

    $view->render('templates/edit-template', [
      "title"     => "Editar slide",
      "menus"     => $this->menus_actives,
      "columns"   => $this->slide->getFields(),
      "item"      => $slide,
      "img_field" => $this->image_field
    ]);
  }

  public function update ()
  {
    if (!isset($_POST)) return;

    $img = $_FILES['slide'];

    if (!File::validImg($img)) {
      return;
    }
    
    $img = File::uploadFile($img);
    $data['name'] = $_POST['name'];
    $data['slide'] = $img;

    $this->slide->update($data, ['id' => (int)$_GET['id']]);

    return self::redirect('/panel' . $this->base_uri);
  }

  public function destroy ()
  {
    if (isset($_GET['excluir'])) {
      $id = (int)$_GET['excluir'];

      $nameImg = $this->slide->selectSingle(['id' => $id], [$this->image_field]);
      File::deleteFile($nameImg[0]);

      $this->slide->delete(['id' => $id]);
    }
  }
}

// EOF
