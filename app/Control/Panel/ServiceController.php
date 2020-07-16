<?php

namespace DevWeb\Control\Panel;

use DevWeb\Model\Request;
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
    $request = new Request;
    $view = $this->view('Panel\\ViewPanel');

    $currentPage = $request->query()->get('pagina', 1);
    $total_pages = ceil(count($this->service->all(['id'])) / $this->perPage);
    $services = $this->service
      ->select()
      ->orderBy('order_id')
      ->limit(($currentPage - 1) * $this->perPage, $this->perPage)
      ->get();

    $view->render('templates/list-template', [
      "can_edit"    => $this->cargo >= $this->edit_level,
      "base_uri"    => $this->base_uri,
      "data" => [
        "total_pages" => $total_pages,
        "results"     => $services,
        "currentPage" => $currentPage,
        "columns"     => $this->service->getFields()
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
    $request = new Request;

    $data = $request->only(['servico']);
    $this->service->create($data);

    return self::redirect('/panel' . $this->base_uri . '/create');
  }

  public function edit ()
  {
    if ( $this->cargo <= $this->edit_level )
      return;

    $request = new Request;
    $view = $this->view('Panel\\ViewPanel');

    if($id = $request->query()->get('id')){
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
    $request = new Request;

    $data = $request->get('servico');
    $this->service->update($data, ['id' => (int)$request->query()->get('id')]);

    return self::redirect('/panel' . $this->base_uri);
  }

  public function destroy ()
  {
    $request = new Request;
    
    if ($id = $request->query()->get('excluir')) {
      $this->service->delete(['id' => $id]);
    }
  }

  public function order () {
    $request = new Request;
    $order = $request->get('order');
    $id =  $request->get('id');

    if(!($order && $id))
      return;

    $this->service->order($id, $order);
  }
}

// EOF
