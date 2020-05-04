<?php

namespace DevWeb\Model;

use PDO;
use DevWeb\Model\mySQL;

class Model
{
  protected $is_orded_by_id = false;

  /**
   * Retorna o PDO object do prepare
   * 
   * @param string $query Query a ser passada para o banco de dados
   * 
   * @return object Objeto PDO após o prepare
   */
  protected function prepare($query) {
    return mySQL::connect()->prepare($query);
  }

  /**
   * Constroi uma query select com base nas colunas e tabela recebida
   * 
   * @param array $columns Nome das colunas que se deseja resgatar
   * 
   * @return string Query select Pronta
   */

  private function buildQuerySelect($columns = ['*']){
    $cols = $columns[0] === '*' ? $columns : array_map(fn($value) => " `$value` ", $columns);

    return 'SELECT ' . implode(', ', $cols) . " FROM `$this->tb`";
  }

  /**
   * Cria a parte do WHERE de uma consulta baseado nas colunas passadas
   * 
   * @param array $columns Nome das colunas
   * @param string $operator [optional] informa qual operador deve ser usado para query
   * 
   * @return string Parte WHERE pronta preparada contra mysql injection
   */

  private function buildQueryWhere($columns, $operator = '='){
      $clauses = array_map(fn($key) => "$key $operator :$key", $columns);
      return " WHERE " . implode(' AND ', $clauses);
  }

  /**
   * Recupera uma unica linha de dado de acordo com os parametros
   * 
   * @param array $where Um dicionario com o nome da coluna como chave e valor associado
   * @param array $columns Colunas que desejam ser resgatadas
   * 
   * @return array O resultado da pesquisa em forma de array ou false caso falhe
   */

  public function selectSingle($where, $columns = ['*']){
    $query = $this->buildQuerySelect($columns);
    $query .= $this->buildQueryWhere(array_keys($where));

    $sql = $this->prepare($query);

    if($sql->execute($where)){
        return $sql->fetch();
    }

    return false;
  }

  /**
   * Retorna todos os registros que batem com as condições
   * 
   * @param array $columns Um Array com as colunas que desejam ser resgatadas
   * @param array $where Array com os valores do where
   * @param string $order Qual sera a ordenação desejada
   * @param int $start indice onde se deve comçar a limitação
   * @param int $end Numero de indices que devem ser exibido a partir do start
   * 
   * @return array Todos os registros que batem com as condições ou false caso falhe
   */

  public function selectAll($columns = ['*'], $where = null, $order = null, $start = null, $end = null){
    $query = $this->buildQuerySelect($columns);
    $query .= isset($where) ? $this->buildQueryWhere(array_keys($where)) : '';
    $query .= isset($order) ? " ORDER BY $order " : " ORDER BY id ASC ";

    if(isset($start) && isset($end)){
      $query .= " LIMIT :start , :end";
      $limit = true;
    }
    
    $sql = $this->prepare($query);
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
   * Insere valores nos campos da tabela não importando a ordem em que são dados, nem quantidade
   * 
   * Considera que sempre que o id seja auto_increment 
   * 
   * @param array $data Valores a serem inseridos em forma dicionario 
   * 
   * @return bool Um booleano representado o sucesso ou falha da inserção
   */

  public function insert($data){
    $query = 'INSERT INTO `' . $this->tb . '` ';

    if($this->is_orded_by_id){
      $data['order_id'] = (int)mySQL::connect()->query('SELECT max(order_id) as ord FROM `' . $this->tb . '`')->fetch()['ord'] + 1;
    }

    $columns = array_keys($data);

    $query .= '(`' . implode('`, `', $columns) . '`) VALUES( ';
    $query .= ':' . implode(', :', $columns) . ')';
    $sql = $this->prepare($query);

    return $sql->execute($data);
  }

  /**
   * Atualiza valores na tabela com base no array passado para o where
   * 
   * @param array $values Chaves como nome da coluna e valor para o valor da mesma
   * @param array $where Chaves como nome da coluna e valor para o valor da mesma
   * 
   * @return bool Retorna se o update foi bem sucedido ou não
   */

  public function update($values, $where){
    $query = array_map(fn($key) => "`$key` = :$key", array_keys($values));

    $query = 'UPDATE `' . $this->tb . '` SET ' . implode(", ", $query) . self::buildQueryWhere(array_keys($where));                
    $sql = $this->prepare($query);

    return $sql->execute(array_merge($values, $where));
  }

  /**
   * Deleta um registro com base nas calusulas where passadas
   * 
   * @param array $where Chaves como nome da coluna e valor para o valor da mesma
   * 
   * @return bool Retorna se o delete foi bem sucedido ou não
   */

  public function delete($where){
    $sql = $this->prepare('DELETE FROM `' . $this->tb . '` ' . self::buildQueryWhere(array_keys($where)));
    
    return $sql->execute($where);
  }

  /**
   * @param array $where Um array contendo chave e valor associado
   * @return bool Retorna o item se existir e false se não existir
   */

  public function equalsExisist($where){
    $item = $this->selectSingle(gettype($where) === 'array' ? $where : ['id' => $where]);

    return $item ? $item : false;
  }

  public function getColumns() {
    return mySQL::getColumnsStats($this->tb);
  }

  /**
   * Retorna os campos inseridos pelo usuario
   */

  public function getFields()
  {
    $cols = $this->getColumns();
    return array_filter($cols, fn($col) => in_array($col['COLUMN_NAME'], $this->used_fields));
  }
}

// EOF
