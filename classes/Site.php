<?php
    class Site{
        public static function updateUserOnline(){
            if(isset($_SESSION['online'])){
                $token = $_SESSION['online'];
                $horarioAtual = date('Y-m-d H:i:s');
                $check = mySQL::connect()->prepare('SELECT id FROM `tb_admin.online` WHERE `token` = ?');
                $check->execute([$token]);

                if($check->rowCount() == 1){
                    Painel::update('tb_admin.online', ['ultima_acao' => $horarioAtual], ['token' => $token]);
                }else{
                    unset($_SESSION['online']);
                    self::updateUserOnline();
                }
            }else{
                $_SESSION['online'] = uniqid();
                $ip = self::getIP();
                $data = [
                    "ip" => $ip, // Ip do usuario que esta vizualiazando
                    "ultima_acao" => date('Y-m-d H:i:s'), // Data e hora atual
                    "token" => $_SESSION['online'] // Token unico
                ];
                Painel::insert('tb_admin.online',$data);
            }
        }

        public static function contador(){
            if(!isset($_COOKIE['visita'])){
                setcookie('visita',true, time() + (60*60*24*14)); // Cookie expira em 14 dias
                Painel::insert('tb_admin.visitas', ['ip' => self::getIP(), 'dia' => date('Y-m-d')]);
            }
        }

        public static function verificaPermissaoMenu($permissao){
            echo $_SESSION['cargo'] >= $permissao ? '' : 'style="display:none;"';
        }

        public static function verificaPermissaoPage($permissao){
            if($_SESSION['cargo'] < $permissao)
                include '../panel/pages/permissao-negada.php';
        }

        public static function verificaPermissaoAcao($permissao){
            if($_SESSION['cargo'] < $permissao)
                die(Painel::alert('error','Você não tem permição para realizar esta ação.'));
        }

        public static function getIP(){
            if(!empty($_SERVER['HTTP_CLIENT_IP'])){
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }else{
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            return $ip;
        }
    }
?>