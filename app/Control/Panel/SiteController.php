<?php

namespace DevWeb\Control\Panel;

use DevWeb\Model\Request;
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
    $request = new Request;

    $data = $request->only([
      'name_author',
      'descricao',
      'icone_1',
      'icone_2',
      'icone_3',
      'descricao_1',
      'descricao_2',
      'descricao_3'
    ]);

    $this->site->update($data, ['id' => 1]);

    return self::redirect('/panel' . $this->base_uri);
  }
}

// EOF
