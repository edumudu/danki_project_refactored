<?php

namespace DevWeb\Control\Panel;

use DevWeb\Model\File;
use DevWeb\Model\Notice;

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
    $view = $this->view('Panel\\ViewPanel');

    $currentPage = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $total_pages = ceil(count($this->notice->selectAll(['id'])) / $this->perPage);
    $notices = $this->notice->selectAll(
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
        "results"     => $notices,
        "currentPage" => $currentPage,
        "columns"     => $this->notice->getColumns()
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
    if (!isset($_POST)) return;

    $data['title'] = $_POST['title'];
    $data['conteudo'] = $_POST['conteudo'];
    $data['slug'] = str_replace(' ', '-', mb_strtolower($data['title']));
    $data['date'] = date("Y-m-d");

    $img = $_FILES[$this->image_field];

    if(File::validImg($img, 1500) && $img_name = File::uploadFile($img)) {
      $data[$this->image_field] = $img_name;
    } else {
      return;
    }

    $this->notice->insert($this->tb, $data, true);

    return self::redirect('/panel' . $this->base_uri . '/create');
  }
}

// EOF
