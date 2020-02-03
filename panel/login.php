<?php
    if(isset($_COOKIE['lembrar'])){
        $user = $_COOKIE['user'];
        $password = $_COOKIE['password'];

        $info_login = Painel::equalsExisist('tb_admin.users',array('user' => $user, 'password' => $password));
        if($info_login){
            $_SESSION['login'] = true;
            $_SESSION['user'] = $user;
            $_SESSION['password'] = $password;
            $_SESSION['cargo'] = $info_login['cargo'];
            $_SESSION['name'] = $info_login['name'];
            $_SESSION['img'] = $info_login['img'];
            Painel::redirect(INCLUDE_PATH_PANEL);
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Logar | Painel de contrle</title>

        <!--Icon-->
        <link rel="icon" href="<?php echo INCLUDE_PATH;?>favicon.ico" type="iamge/x-icon" />
        <!--CSS-->
        <link rel="stylesheet" href="<?php echo INCLUDE_PATH;?>css/all.min.css" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo INCLUDE_PATH_PANEL;?>css/stylePanel.css" />
    </head>
    <body>
        <div class="box-login">
            <?php
                if(isset($_POST['logar'])){
                    $user = $_POST['username'];
                    $password = $_POST['password'];


                    $info_login = Painel::equalsExisist('tb_admin.users',array('user' => $user, 'password' => $password));
                    
                    if($info_login){
                        if(isset($_POST['remember-login'])){
                            setcookie('lembrar',true, time() + (60*60*24*2), '/');
                            setcookie('user', $user, time() + (60*60*24*2), '/');
                            setcookie('password', $password, time() + (60*60*24*2), '/');
                        }
                        
                        $_SESSION['login'] = true;
                        $_SESSION['user'] = $user;
                        $_SESSION['password'] = $password;
                        $_SESSION['cargo'] = $info_login['cargo'];
                        $_SESSION['name'] = $info_login['name'];
                        $_SESSION['img'] = $info_login['img'];
                        Painel::redirect(INCLUDE_PATH_PANEL);
                    }else{
                        Painel::alert('error','Usuario ou senha incorretos!');
                    }
                    
                }
            ?>


            <h2>Efetue o login:</h2>
            <form method="POST">
                <input type="text" name="username" placeholder="Login" required />
                <input type="password" name="password" placeholder="Senha" required />
                <div class="form-group">
                    <input type="checkbox" name="remember-login" id="remember-login" />
                    <label for="remember-login">Desejo lembrar a senha.</label>
                </div>
                <input class="btn-form" type="submit" name="logar" value="Logar" />
            </form>
        </div><!--box-login-->
    
    </body>
</html>