<?php

namespace DevWeb\Control\Panel;

use DevWeb\Model\File;
use DevWeb\Model\Notice;
use DevWeb\Model\Request;

class NoticeController extends ControllerPanel
{
  protected $base_uri = '/notice';
  protected $image_field = 'capa';

  public function __construct()
  {
    parent::__construct();
    $this->notice = new Notice;
  }

  public function index () 
  {
    $request = new Request;
    $view = $this->view('Panel\\ViewPanel');

    $currentPage = $request->query()->get('pagina', 1);
    $total_pages = ceil(count($this->notice->all(['id'])) / $this->perPage);
    $notices = $this->notice
      ->select()
      ->orderBy('order_id')
      ->limit(($currentPage - 1) * $this->perPage, $this->perPage)
      ->get();

    $view->render('templates/list-template', [
      "can_edit"      => $this->cargo >= $this->edit_level,
      "base_uri"      => $this->base_uri,
      "data"         => [
        "total_pages" => $total_pages,
        "results"     => $notices,
        "currentPage" => $currentPage,
        "columns"     => $this->notice->getFields()
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
      "columns"   => $this->notice->getFields(),
      "img_field" => $this->image_field
    ]);
  }

  public function store ()
  {
    $request = new Request;

    $data = $request->only(['title', 'conteudo', 'categoria_ref']);
    $data['slug'] = str_replace(' ', '-', mb_strtolower($data['title']));
    $data['date'] = date("Y-m-d");

    $img = $request->files($this->image_field);;

    if(File::validImg($img, 1500) && $img_name = File::uploadFile($img)) {
      $data[$this->image_field] = $img_name;
    } else {
      return;
    }

    $this->notice->create($data);

    return self::redirect('/panel' . $this->base_uri . '/create');
  }
}

// EOF
