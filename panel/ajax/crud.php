<?php

require_once "../../config.php";

if(!Painel::logado()) die('Você precisa estar logado');

$data = [
    "success" => true,
    "message" => "Cliente Atualizado com suceeso"
];

if(empty($_POST['action']) || !isset($_POST['action'])) die(json_encode(['success' => false]));
switch($_POST['action']){
    case "delete":
        $info = $_POST['data'];
        $data['success'] = Painel::deleteRegistro($info['tb'], ['id' => $info['id']], $info['img']);
        break;
    case "update":
        $info = $_POST;
        unset($info['id']);
        unset($info['tb']);
        unset($info['action']);

        $info['img'] = $_FILES['img'] ?? $info['img_atual'];
        unset($info['img_atual']);
        $info['cpf_cnpj'] = $info['tipe'] == 'fisico' ? $info['cpf'] : $info['cnpj'];
        /**Para não ter argumentos a mais na hora do insert */
        unset($info['cpf']);
        unset($info['cnpj']);

        foreach($info as $value){
            if(empty($value) || !isset($value)) die(json_encode([
                "success" => false,
                "message" => "Campos vazios não são permitidos"
            ]));
        }

        if(is_array($info['img']))
            $info['img'] = Painel::uploadFile($info['img']);
        

        if(!Painel::update($_POST['tb'], $info, ['id' => $_POST['id']])){
            $data['success'] = false;
            $data['message'] = "Não foi possivel fazer o update, tente novamente mais tarde.";
        }
        break;
}

echo json_encode($data);
?>