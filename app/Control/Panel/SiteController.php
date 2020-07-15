<?php

namespace DevWeb\Control\Panel;

use DevWeb\Model\Site;

class SiteController extends ControllerPanel
{

  public function __construct()
  {
    parent::__construct();
    $this->site = new Site;
  }

  public function edit ()
  {
    if ( $this->cargo <= $this->edit_level )
      return;

    $view = $this->view('Panel\\ViewPanel');

    $site = $this->site->selectSingle(['id' => 1]);

    $view->render('templates/edit-template', [
      "menus"     => $this->menus_actives,
      "columns"   => $this->site->getFields(),
      "item"      => $site
    ]);
  }

  public function update ()
  {
    if (!isset($_POST)) return;

    $data['name_author'] = $_POST['name_author'];
    $data['descricao'] = $_POST['descricao'];
    $data['icone_1'] = $_POST['icone_1'];
    $data['icone_2'] = $_POST['icone_2'];
    $data['icone_3'] = $_POST['icone_3'];
    $data['descricao_1'] = $_POST['descricao_1'];
    $data['descricao_2'] = $_POST['descricao_2'];
    $data['descricao_3'] = $_POST['descricao_3'];

    $this->site->update($data, ['id' => 1]);

    return self::redirect('/panel' . $this->base_uri);
  }
}

// EOF
