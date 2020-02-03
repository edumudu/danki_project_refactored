<?php

class mySQL{

    private static $pdo;
    private static $schemaPdo;
    public static function connect(){
        if(!isset(self::$pdo)){
            try{    
                self::$pdo = new PDO(
                    'mysql:host='.HOST.';dbname='.DATABASE, USER, PASSWORD,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
                );
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //self::$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE); Resolve o problema de querys preparadas
            }catch(Exception $e){
                echo "Erro ao conectar ao banco de dados";
            }
        }
        return self::$pdo;
    }

    public static function getColumnsName($tb){
        try{    
            self::$schemaPdo = new PDO(
                'mysql:host='.HOST.';dbname=INFORMATION_SCHEMA', USER, PASSWORD,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
            self::$schemaPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return self::$schemaPdo->query("SELECT `COLUMN_NAME` FROM `COLUMNS` WHERE `TABLE_NAME` = '$tb'")->fetchAll();
        }catch(Exception $e){
            echo "Erro ao conectar ao banco de dados";
            return false;
        }
    }
}

?>