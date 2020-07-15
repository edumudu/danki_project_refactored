<?php

namespace DevWeb\Control\Panel;

use DevWeb\Model\File;
use DevWeb\Model\User;

class UserController extends ControllerPanel
{
  protected $base_uri = '/user';
  protected $image_field = 'img';

  public function __construct()
  {
    parent::__construct();
    $this->user = new User;
  }

  public function create ()
  {
    if ( $this->cargo <= $this->edit_level )
      return;

    $view = $this->view('Panel\\ViewPanel');

    $view->render('templates/create-template', [
      "title"     => 'Create user',
      "menus"     => $this->menus_actives,
      "columns"   => $this->user->getFields(),
      "img_field" => $this->image_field
    ]);
  }

  public function store ()
  {
    if (!isset($_POST)) return;

    $img = $_FILES[$this->image_field];

    if (!File::validImg($img)) {
      return;
    }
    
    $img = File::uploadFile($img);
    $data['name'] = $_POST['name'];
    $data['user'] = $_POST['user'];
    $data['password'] = $_POST['password'];
    $data['cargo'] = $_POST['cargo'];
    $data[$this->image_field] = $img ?: null;

    $this->user->create($data);

    return self::redirect('/panel' . $this->base_uri . '/create');
  }

  public function edit ()
  {
    if ( $this->cargo <= $this->edit_level )
      return;

    $view = $this->view('Panel\\ViewPanel');

    $view->render('templates/edit-template', [
      "menus"     => $this->menus_actives,
      "columns"   => $this->user->getFields(),
      "item"      => $_SESSION['auth']['user'],
      "img_field" => $this->image_field
    ]);
  }

  public function update ()
  {
    $img = $_FILES[$this->image_field];

    if (!File::validImg($img)) {
      return;
    }

    $img = File::uploadFile($img);
    $data['name'] = $_POST['name'];
    $data['user'] = $_POST['user'];
    $data['password'] = $_POST['password'];
    $data['cargo'] = $_POST['cargo'];
    $data['img'] = $img;
    
    if($this->user->update($data, ['id' => auth()->user->id])) {
      $_SESSION['auth']['user']['img'] = $img;
    }

    self::redirect(INCLUDE_PATH_PANEL);
  }
}

// EOF
