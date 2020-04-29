<?php

namespace DevWeb\Control\Panel;

use DevWeb\Model\Painel;
use DevWeb\Model\Usuario;

class UserController extends ControllerPanel
{
  protected $tb = 'tb_admin.users';
  protected $used_fields = ['user', 'name', 'img', 'password', 'cargo'];
  protected $base_uri = 'user';

  public function edit ()
  {
    if ( $this->cargo <= $this->edit_level )
      return;

    $view = $this->view('Panel\\ViewPanel');

    $view->render('templates/edit-template', [
      "menus"   => $this->menus_actives,
      "columns" => $this->getUsedFields(),
      "item"    => $_SESSION
    ]);
  }

  public function update ()
  {
    $queryOk = true;

    $data = (object)array_filter($_POST, fn($key) => in_array($key, $this->used_fields), ARRAY_FILTER_USE_KEY);
    unset($data['img']);

    $img = $_FILES['img']['name'] ? $_FILES['img'] : $_POST['img_atual'];

    if(is_array($img)){
      if(Painel::validImg($img)){
        $img = Painel::uploadFile($img);
        if(!$img) $queryOk = false;
        else Painel::deleteFile($_POST['img_atual']);
      }else{
        $queryOk = false;
        Painel::alert('error','O formato da imagem não é valido.');
      } 
    }
    
    if($queryOk){
        $user = new Usuario;
        if($user->updateUser($data->name, $data->password, $img)){
            Painel::alert('success','Atualizado com sucesso!');
            $_SESSION['img'] = $img;
        }
        else
            Painel::alert('error','Ocorreu um erro ao atualizar.'); 
    }
  }
}

// EOF
