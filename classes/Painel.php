<?php

    class Painel{

        private static $acceptImgsTypes = [
            'image/jpg',
            'image/jpeg',
            'image/png',
            'image/gif'
        ];

        public static $cargos = [
            'Normal',
            'Subadministrador',
            'Administrador'
        ];

        public static function loadJS($files, $page){
            $url = explode('/', @$_GET['url'])[0];
            if($page == $url){
                foreach($files as $file){
                    echo "<script src='".INCLUDE_PATH_PANEL."js/$file'></script>";
                }
            }
        }

        /**
         * @param string uma string com o valor base para o slug
         * 
         * @return string Retorna um slug da string passada
         */

        public static function generateSlug($str){
            $str = mb_strtolower($str); // strtolower() que funciona com utf-8
            $str = preg_replace('/(á|à|ã|â)/', 'a', $str);
            $str = preg_replace('/(é|è|ê)/', 'e', $str);
            $str = preg_replace('/(í|ì|î)/', 'i', $str);
            $str = preg_replace('/(ú|ù|û)/', 'u', $str);
            $str = preg_replace('/(ó|ò|õ|ô)/', 'o', $str);
            $str = preg_replace('/(_|\/|!|\?|#)/', '', $str);
            $str = preg_replace('/( )/', '-', $str);
            $str = preg_replace('/(ç)/', 'c', $str);
            $str = preg_replace('/(,)/', '-', $str);
            $str = preg_replace('/(-[-]{1,})/', '-', $str);
            return $str;
        }

        /**
         * Constroi uma query select com base nas colunas e tabel recebida
         * 
         * @param string $tb Nome da table alvo.
         * @param array $columns Nome das colunas que se deseja resgatar
         * 
         * @return string Query select Pronta
         */

        public static function buildQuerySelect($tb, $columns = ['*']){
            $totalColumns = count($columns);
            $query = "SELECT ";

            foreach($columns as $key => $value){
                $query .= $key == $totalColumns - 1 ? " `$value` " : " `$value`, ";
            }
            return preg_replace('/(`\*`)/', '*', $query." FROM `$tb`");
        }

        /**
         * Cria a parte do WHERE de uma consulta baseado nas colunas passadas
         * 
         * @param array $columns Nome das colunas
         * @param string $operator [optional] informa qual operador deve ser usado para query
         * 
         * @return string Parte WHERE pronta preparada contra mysql injection
         */
        public static function buildQueryWhere($columns, $operator = '='){
            $total = count($columns);
            $query = " WHERE ";
            foreach($columns as $key => $value){
                if($value == '') return false;
                $query .= $total - 1 == $key ? "`$value` $operator :$value " : "`$value` $operator :$value AND ";
            }
            return $query;
        }

        /**
         * @return bool Retorna true se a sessao login existe e flse se não
         */

        public static function logado(){
            return isset($_SESSION['login']);
        }
        /**
         * Destroi as sessões e cookies 
         * @return void
         */

        public static function logout(){
            session_destroy();
            setcookie('lembrar',null, time() - 1, '/');
            setcookie('user', null, time() - 1, '/');
            setcookie('password', null, time() - 1, '/');
            self::redirect(INCLUDE_PATH_PANEL);
        }

        public static function loadpage(){
            if($_GET['url'] !== ''){
                $url = explode('/', $_GET['url']);
                if(file_exists('pages/'.$url[0].'.php'))
                    include 'pages/'.$url[0].'.php';
                else
                    self::redirect(INCLUDE_PATH_PANEL);
            }else{
                include('pages/home.php');
            }
        }

        /**
         * Recupera uma unica linha de dado de acordo com os parametros
         * 
         * @param string $tb Nome da table alvo
         * @param array $where Um dicionario com o nome da coluna como chave e valor associado
         * @param array $columns Colunas que desejam ser resgatadas
         * 
         * @return array O resultado da pesquisa em forma de array ou false caso falhe
         */

        public static function selectSingle($tb, $where, $columns = ['*']){
            $query = self::buildQuerySelect($tb,$columns);
            $query .= self::buildQueryWhere(array_keys($where));

            $sql = mySQL::connect()->prepare($query);

            if($sql->execute($where)){
                return $sql->fetch();
            }
            return false;
        }

        /**
         * 
         * @param string $tb Uma string contendo o nome da tabela alvo
         * @param array $columns Um Array com as colunas que desejam ser resgatadas
         * @param array $where Array com os valores do where
         * @param string $order Qual sera a ordenação desejada
         * @param int $start indice onde se deve comçar a limitação
         * @param int $end Numero de indices que devem ser exibido a partir do start
         * 
         * @return array Todos os registros que batem com as condições ou false caso falhe
         */

        public static function selectAll($tb, $columns = ['*'], $where = null, $order = null, $start = null, $end = null){
            $query = self::buildQuerySelect($tb, $columns);
            $query .= isset($where) ? self::buildQueryWhere(array_keys($where)) : '';
            $query .= isset($order) ? " ORDER BY $order ": " ORDER BY id ASC ";

            if(isset($start) && isset($end)){
                $query .= " LIMIT :start ,:end";
                $limit = true;
            }
            
            $sql = mySQL::connect()->prepare($query);
            if(isset($limit)){
                //Resolver bug do pdo ao usar ? ? na query limit
                $sql->bindParam(':start', $start, PDO::PARAM_INT);
                $sql->bindParam(':end', $end, PDO::PARAM_INT);
            }

            if(isset($where)){
                foreach($where as $key => $value){
                    $sql->bindParam(":$key", $value);
                }
            }

            if(!$sql->execute()) return false;
            return $sql->fetchAll();
        }

        public static function limparUsersOnline(){
            $date = date('Y-m-d H:i:s');
            $sql = mySQL::connect()->exec("DELETE FROM `tb_admin.online` WHERE `ultima_acao` < '$date' - INTERVAL 1 MINUTE");
        }

        /**
         * @param string $type Uma string informando o tipo de alerta que eu desejo imprimir
         * @param string $message Uma string contendo ao menssagem Quer eu devo imprimir
         * 
         * @return void
         */

        public static function alert($type, $message){
            switch($type){
                case 'success':
                    echo '<div class="success"><i class="fas fa-check"></i> '.$message.'</div>';
                    break;
                case 'error':
                    echo '<div class="error"><i class="fas fa-exclamation-circle"></i> '.$message.'</div>';
                    break;
            }
        }

        public static function validImg($img, $maxSize = 300){
            if(in_array($img['type'], self::$acceptImgsTypes)){
                $size = intval($img['size']/1024); // Converte de Bytes para Kb o tamanho da imagem e verifica seu tamanho arredondado
                return $size < $maxSize; 
            }
            return false;
        }

        public static function uploadFile($file){
            $fileFormat = explode('/', $file['type']);
            $imgName = uniqid().'.'.$fileFormat[count($fileFormat) - 1];
            if(move_uploaded_file($file['tmp_name'], BASE_DIR_PANEL.'/uploads/'.$imgName))
                return $imgName;
            return false;
        }

        /**
         * @param string $file Uma string contendo o nome do arquivo
         * @return void
         */

        public static function deleteFile($file){
            @unlink(BASE_DIR_PANEL.'/uploads/'.$file);
        }

        /**
         * Insere valores nos campos da tabela não importando a ordem em que são dados, nem quantidade
         * 
         * Considera que sempre que o id seja auto_increment 
         * 
         * @param string $tb Tabela alvo da inserção
         * @param array $data Valores a serem inseridos em forma dicionario 
         * @param mixed $order_id se diferente de nulo indica que deve ser usando e cadastrado com order_id 
         * 
         * @return bool Um booleano representado o sucesso ou falha da inserção
         */

        public static function insert($tb, $data, $order_id = null){

            $query = "INSERT INTO `$tb` ";
            foreach($data as $key => $value){
                if($value == '') return false;
                if($key == 'acao'){
                    unset($data[$key]);
                    continue;
                }
                $columns_name[] = $key;
                $PDO_keys[] = ":$key";
            }

            if($order_id){
                $PDO_keys[] = ":order";
                $columns_name[] = 'order_id';
                $data = array_merge(
                    $data, 
                    ['order' => (int)mySQL::connect()->query("SELECT max(order_id) as ord FROM `$tb`")->fetch()['ord'] + 1]
                );
            }
            $query .= '(`'.implode('`, `', $columns_name).'`) VALUES( ';
            $query .= implode(', ',$PDO_keys);
            $sql = mySQL::connect()->prepare($query.')');
            return $sql->execute($data);
        }

        public static function update($tb, $values, $where){
            foreach($values as $key => $value){
                if($value == '') return false;
                if($key == "acao"){
                    unset($values[$key]);
                    continue;
                }
                $query [] = "`$key` = :$key";
            }

            $query = "UPDATE `$tb` SET ".implode(", ",$query).self::buildQueryWhere(array_keys($where));                
            $sql = mySQL::connect()->prepare($query);
            return $sql->execute(array_merge($values, $where));
        }

        /**
         * @param string $tb Uma string contendo a tabela alvo
         * @param array $where Um array contendo chave e valor associado
         * @return bool Retorna o item se existir e false se não existir
         */
        public static function equalsExisist($tb, $where, $id = null){
            if(isset($id)){
                $query = self::buildQuerySelect($tb).self::buildQueryWhere(array_keys($where)).' AND `id` != :id';
                $sql = mySQL::connect()->prepare($query);
                $sql->execute(array_merge($where, ['id' => $id]));
                $item = $sql->fetch();
            }else{
                $item = self::selectSingle($tb, $where);
            }
            return $item ? $item : false;
        }

        public static function deleteRegistro($tb, $where = null, $img = false){
            if($where){
                $sql = mySQL::connect()->prepare("DELETE FROM `$tb` ".self::buildQueryWhere(array_keys($where)));
                if($img && is_string($img)){
                    $nameImg = self::selectSingle($tb, $where, [$img]);
                    self::deleteFile($nameImg[$img]);
                }
            }else
                $sql = mySQL::connect()->prepare("DELETE FROM `$tb`");
            
            if($where)
                return $sql->execute($where);
            else
                return $sql->execute();
        }

        public static function redirect($url){
            die('<script>location.href = "'.$url.'";</script>');
        }

        public static function cleanUrlJs($url){
            echo "<script>window.history.pushState('','','$url')</script>";
        }

        public static function orderItem($tb, $orderType, $idItem){
            $item = self::selectSingle($tb, ['id' => $idItem]);
            switch($orderType){
                case 'up':
                    $itemArround = mySQL::connect()->query(self::buildQuerySelect($tb)." WHERE `order_id` < $item[order_id] ORDER BY order_id DESC LIMIT 1");
                    break;
                case 'down':
                    $itemArround = mySQL::connect()->query(self::buildQuerySelect($tb)." WHERE `order_id` > $item[order_id] ORDER BY order_id ASC LIMIT 1");
                    break;
            }

            if($itemArround->rowCount() == 0) return false;
            $itemArround = $itemArround->fetch();
            if(!self::update($tb, ["order_id" => $itemArround['order_id']] ,['id' => $idItem])) return false;
            if(!self::update($tb, ["order_id" => $item['order_id']] ,['id' => $itemArround['id']])) return false;
            return true;
        }

    }

?>