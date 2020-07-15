<?php

namespace DevWeb\Control\Panel;

use DevWeb\Model\Slide;
use DevWeb\Model\File;
use DevWeb\Model\Request;

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
    $request = new Request;
    $view = $this->view('Panel\\ViewPanel');

    $currentPage = $request->query()->get('pagina', 1);
    $total_pages = ceil(count($this->slide->all(['id'])) / $this->perPage);
    $slides = $this->slide->all(
      ['*'],
      null,
      'order_id ASC',
      ($currentPage - 1) * $this->perPage,
      $this->perPag
    );

    $view->render('templates/list-template', [
      "can_edit"      => $this->cargo >= $this->edit_level,
      "base_uri"      => $this->base_uri,
      "data"         => [
        "total_pages" => $total_pages,
        "results"     => $slides,
        "currentPage" => $currentPage,
        "columns"     => $this->slide->getFields()
      ],
      "menus"         => $this->menus_actives,
      "img_field"     => $this->image_field
    ]);
  }

  public function create ()
  {
    if ( $this->cargo <= $this->edit_level )
      return self::redirect('/panel/permission-denied');

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
    $request = new Request;

    $img = $request->files('slide');

    if (!File::validImg($img)) {
      return;
    }
    
    $img = File::uploadFile($img);
    $data = $request->only(['name']);
    $data['slide'] = $img ?: null;

    $this->slide->create($data);

    return self::redirect('/panel' . $this->base_uri . '/create');
  }

  public function edit ()
  {
    if ( $this->cargo <= $this->edit_level )
      return;

    $request = new Request;
    $view = $this->view('Panel\\ViewPanel');

    if($id = $request->query()->get('id')){
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
    $request = new Request;

    $img = $request->files('slide');

    if (!File::validImg($img)) {
      return;
    }
    
    $img = File::uploadFile($img);
    $data = $request->only(['name']);
    $data['slide'] = $img;

    $this->slide->update($data, ['id' => (int)$request->query()->get('id')]);

    return self::redirect('/panel' . $this->base_uri);
  }

  public function destroy ()
  {
    $request =  new Request;
    if ($id = $request->query()->get('excluir')) {
      $nameImg = $this->slide->selectSingle(['id' => $id], [$this->image_field]);
      File::deleteFile($nameImg[0]);

      $this->slide->delete(['id' => $id]);
    }
  }

  public function order () {
    $request = new Request;
    $order = $request->get('order');
    $id =  $request->get('id');

    if(!($order && $id))
      return;

    $this->slide->order($id, $order);
  }
}

// EOF
