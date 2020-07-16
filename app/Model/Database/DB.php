<?php

namespace DevWeb\Model\Database;

use PDO;
use Exception;

class DB
{
  private static $pdo;
  private static $schemaPdo;

  private $query = '';
  private $parameters = [];
  private $table = '';

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

  public static function getColumns($tb){
    try{    
      self::$schemaPdo = new PDO(
          'mysql:host='.HOST.';dbname=INFORMATION_SCHEMA', USER, PASSWORD,
          array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
      );
      self::$schemaPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $columns = self::$schemaPdo->query("SELECT `COLUMN_NAME` as name, `COLUMN_TYPE` as type FROM `COLUMNS` WHERE `TABLE_NAME` = '$tb'")->fetchAll();
      
      return $columns;
    }catch(Exception $e){
      echo "Erro ao conectar ao banco de dados";
      return false;
    }
  }

  /**
   * Constroi uma query select com base nas colunas e tabela recebida
   * 
   * @param array $columns Nome das colunas que se deseja resgatar
   * 
   * @return string Query select Pronta
   */

  protected function buildQuerySelect(array $columns) : string
  {
    $cols = array_map(fn($value) => " `$value` ", $columns);

    return 'SELECT ' . (implode(', ', $cols) ?: '*') . " FROM `$this->table`";
  }

  /**
   * Cria a parte do WHERE de uma consulta baseado nas colunas passadas
   * 
   * @param array $columns Nome das colunas
   * @param string $operator [optional] informa qual operador deve ser usado para query
   * 
   * @return string Parte WHERE pronta preparada contra mysql injection
   */

  protected function buildQueryWhere(array $columns, string $operator = '=') : string
  {
    $clauses = array_map(fn($key) => "`$key` $operator :$key", $columns);

    return " WHERE " . implode(' AND ', $clauses) . " ";
  }

  public function table(string $table) : DB
  {
    $this->table = $table;

    return $this;
  }

  public function insert($data)
  {
    $columns = array_keys($data);

    $this->query = "INSERT INTO `$this->table` ";
    $this->query .= "(`" . implode('`, `', $columns) . "`) ";
    $this->query .= "VALUES(:" . implode(', :', $columns) . ")";

    $sql = self::connect()->prepare($this->query);    

    return $sql->execute($data);
  }

  public function upgrade ($data) : DB
  {
    $values = array_map(fn($key) => "$key = :$key", array_keys($data));

    $this->query = "UPDATE `$this->table` ";
    $this->query .= "SET " . implode(', ', $values);

    $this->parameters = $data;

    return $this;
  }

  public function where (array $parameters, string $operator = '=') : DB
  {
    $this->parameters = array_merge($this->parameters, $parameters);
    $this->query .= $this->buildQueryWhere(array_keys($parameters), $operator);

    return $this;
  }

  public function select (array $columns = []) : DB
  {
    $this->query = $this->buildQuerySelect($columns);
    $this->parameters = [];

    return $this;
  }

  public function destroy (array $where)
  {
    $this->query = "DELETE FROM `$this->table`";
    $this->parameters = [];
    $this->where($where);

    $sql = self::connect()->prepare($this->query);
    
    return $sql->execute($where);
  }

  public function orderBy (string $column, string $order = 'ASC') : DB
  {
    $this->query .= "ORDER BY $column $order ";

    return $this;
  }

  public function limit (int $start, int $end = null) : DB
  {
    $this->query .= "LIMIT $start";
    if ($end) $this->query .= ", $end";

    return $this;
  }

  public function get() : array
  {
    $sql = self::connect()->prepare($this->query);
    $sql->execute($this->parameters);
    
    return $sql->fetchAll();
  }

  public function save()
  {
    $sql = self::connect()->prepare($this->query);

    return $sql->execute($this->parameters);
  }
}

// EOF
