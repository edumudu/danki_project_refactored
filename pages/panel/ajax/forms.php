<?php

include_once "../../config.php";

/* Codigo a partir daqui */

if(!Painel::logado()) die("Você não esta logado.");

$data = [
    'success' => true,
    'message' => 'Cliente Cadastradado com successo'
];

sleep(2);
$formData = $_POST;

$img = $_FILES['img'] ?? null;
$identificacao = $formData['cpf_cnpj'] = $formData['tipe'] == 'fisico' ? $formData['cpf'] : $formData['cnpj'];
/**Para não ter argumentos a mais na hora do insert */
unset($formData['cpf']);
unset($formData['cnpj']);

foreach($formData as $value){
    if(empty($value)) die(
        json_encode([
            'success' => false,
            'message' => 'Campos vazios não são permitidos'
        ])
    );
}


if(isset($img)){
    $data['success'] = Painel::validImg($img);
}else{
    $data['success'] = false;
    $data['message'] = "Imagem invalida ou vazia";
}

if($data['success']){
    /**Realizar o cadastro */
    $formData['img'] = Painel::uploadFile($img);
    if(!Painel::insert('tb_admin.clientes', $formData)){
        $data['success'] = false;
        $data['message'] = "Ocorreu algum problem ao adicionar o cliente no banco de dados, favor tentar novamente mais tarde";
    }
        
}

echo json_encode($data);

die();

?>