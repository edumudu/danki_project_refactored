<?php

namespace DevWeb\Model;

use PDO;
use DevWeb\Model\mySQL;

class Painel{
    public static function loadJS($files, $page){
        $url = explode('/', $_GET['url'])[0];
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

    public static function cleanUrlJs($url){
        echo "<script>window.history.pushState('','','$url')</script>";
    }
}

// EOF
