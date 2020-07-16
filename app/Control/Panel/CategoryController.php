<?php

namespace DevWeb\Control\Panel;

use DevWeb\Model\Category;
use DevWeb\Model\Request;

class CategoryController extends ControllerPanel
{
  protected $base_uri = '/category';
  protected $edit_level = 1;

  public function __construct()
  {
    parent::__construct();
    $this->category = new Category;
  }

  /**
   * 
   */
  public function index () 
  {
    $request = new Request;
    $view = $this->view('Panel\\ViewPanel');

    $currentPage = $request->query()->get('page', 1);
    $total_pages = ceil(count($this->category->all(['id'])) / $this->perPage);
    $categories = $this->category
      ->select()
      ->orderBy('order_id')
      ->limit(($currentPage - 1) * $this->perPage, $this->perPage)
      ->get();

    $view->render('templates/list-template', [
      "can_edit"    => $this->cargo >= $this->edit_level,
      "base_uri"    => $this->base_uri,
      "data" => [
        "total_pages" => $total_pages,
        "results"     => $categories,
        "currentPage" => $currentPage,
        "columns"     => $this->category->getFields()
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
      "title"       => 'Create category',
      "menus"       => $this->menus_actives,
      "columns"     => $this->category->getFields()
    ]);
  }

  public function store ()
  {
    $request = new Request;
    
    $data = $request->only(['name']);
    $data['slug'] = generateSlug($data['name']);

    $this->category->create($data);

    return self::redirect('/panel' . $this->base_uri . '/create');
  }

  public function edit ()
  {
    if ( $this->cargo <= $this->edit_level )
      return;

    $request = new Request;
    $view = $this->view('Panel\\ViewPanel');

    if($id = $request->query()->get('id')){
      $service = $this->category->selectSingle(['id' => $id]);
    }else {
      die(Painel::alert('error','Você precisa pasar o parametro id.'));
    }

    $view->render('templates/edit-template', [
      "menus"     => $this->menus_actives,
      "columns"   => $this->category->getFields(),
      "item"      => $service
    ]);
  }

  public function update ()
  {
    $request = new Request;

    $data = $request->only(['name']);
    $data['slug'] = generateSlug($data['name']);;

    $this->category->update($data, ['id' => (int)$request->query()->get('id')]);

    return self::redirect('/panel' . $this->base_uri);
  }

  public function destroy ()
  {
    $request = new Request;

    if ($id = $request->query()->get('excluir')) {
      $this->category->delete(['id' => $id]);
    }
  }

  public function order () {
    $request = new Request;
    $order = $request->get('order');
    $id =  $request->get('id');

    if(!($order && $id))
      return;

    $this->category->order($id, $order);
  }
}

// EOF
