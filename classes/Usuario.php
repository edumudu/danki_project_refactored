<?php
    class Usuario{

        public function updateUser($name, $pass, $img){
            $sql = mySQL::connect()->prepare("UPDATE `tb_admin.users` SET `name` = ?, `password` = ?, `img` = ? WHERE user = ?");
            return $sql->execute([$name, $pass, $img, $_SESSION['user']]); // Retorn true ou false
        }

        public static function listUsersOnline(){
            Painel::limparUsersOnline();
            return Painel::selectAll('tb_admin.online');
        }

        public static function userExists($user){
            $sql = mySQL::connect()->prepare('SELECT id FROM `tb_admin.users` WHERE user = ?');
            $sql->execute(array($user));
            return $sql->rowCount() == 1;
        }

        public function addUser($user, $pass, $img, $name, $cargo){
            $sql = mySQL::connect()->prepare('INSERT INTO `tb_admin.users` VALUES(null, ?,?,?,?,?)');
            $sql->execute([$user, $pass, $img, $name, $cargo]);
        }
    }
?>