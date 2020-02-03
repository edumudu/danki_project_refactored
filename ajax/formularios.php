<?php
    include '../config.php';

    $data = [
        "success" => false
    ];

    if(isset($_POST)){
        $email = $_POST['email'];
        $corpo = '';

        foreach($_POST as $key => $value){
            $corpo .= ucfirst($key).": $value";
            $corpo .= "<hr />";
        }

        $info = [
            "Subject" => "Nova menssagem do site",
            "body" => $corpo
        ];

        if($email != '' && filter_var($email, FILTER_VALIDATE_EMAIL)){
            $mailer = new Email('vps.dankicode.com','testes@dankicode.com','gui123456','Guilherme');
            $mailer->addAdress('contato@dankicode.com','Guilherme');
            $mailer->formatMail($info);
            if($mailer->sendMail()){
                $data["success"] = true;
            }
        }

        die(json_encode($data));  
    }
?>