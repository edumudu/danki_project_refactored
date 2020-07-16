<?php

namespace DevWeb\Model;

use DevWeb\Model\Database\DB;
use Exception;

class Model extends DB
{
  protected $is_orded_by_id = false;
  protected $hidden = [];

  public function __construct()
  {
    $this->table($this->tb);
  }

  /**
   * Retorna todos os registros que batem com as condições
   * 
   * @param array $columns Um Array com as colunas que desejam ser resgatadas
   * @param array $where Array com os valores do where
    */

  public function all($columns = null, $where = null) : array
  {
    $columns = $columns ?? array_column($this->getFields($this->tb), 'name');
    $params = array_filter($columns, fn($value) => !in_array($value, $this->hidden)) ?? [];

    $this->select($params);

    if ($where) $this->where($where);

    return $this->get();
  }

  /**
   * Recupera uma unica linha de dado de acordo com os parametros
   * 
   * @param array $where Um dicionario com o nome da coluna como chave e valor associado
   * @param array $columns Colunas que desejam ser resgatadas
   * 
   * @return array O resultado da pesquisa em forma de array ou false caso falhe
   */

  public function selectSingle($where, $columns = [])
  {
    try {
      return $this->select($columns)->where($where)->get()[0];
    } catch (Exception $e) {
      return false;
    }
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

  // public function selectAll($columns = ['*'], $where = null, $order = null, $start = null, $end = null){
  //   $query = $this->buildQuerySelect($columns);
  //   $query .= isset($where) ? $this->buildQueryWhere(array_keys($where)) : '';
  //   $query .= isset($order) ? " ORDER BY $order " : " ORDER BY id ASC ";

  //   if(isset($start) && isset($end)){
  //     $query .= " LIMIT :start , :end";
  //     $limit = true;
  //   }
    
  //   $sql = $this->prepare($query);
  //   if(isset($limit)){
  //     //Resolver bug do pdo ao usar ? ? na query limit
  //     $sql->bindParam(':start', $start, PDO::PARAM_INT);
  //     $sql->bindParam(':end', $end, PDO::PARAM_INT);
  //   }

  //   if(isset($where)){
  //     foreach($where as $key => $value){
  //       $sql->bindParam(":$key", $value);
  //     }
  //   }

  //   if(!$sql->execute()) return false;
  //   return $sql->fetchAll();
  // }

  /**
   * Insere valores nos campos da tabela não importando a ordem em que são dados, nem quantidade
   * 
   * Considera que sempre que o id seja auto_increment 
   * 
   * @param array $data Valores a serem inseridos em forma dicionario 
   * 
   * @return bool Um booleano representado o sucesso ou falha da inserção
   */

  public function create($data){

    if($this->is_orded_by_id){
      $data['order_id'] = (int)DB::connect()
        ->query("SELECT max(order_id) as ord FROM `$this->tb`")
        ->fetch()['ord'] + 1;
    }

    return $this->insert($data);
  }

  /**
   * Atualiza valores na tabela com base no array passado para o where
   * 
   * @param array $values Chaves como nome da coluna e valor para o valor da mesma
   * @param array $where Chaves como nome da coluna e valor para o valor da mesma
   * 
   * @return bool Retorna se o update foi bem sucedido ou não
   */

  public function update ($values, $where)
  {
    return $this->upgrade($values)->where($where)->save();
  }

  /**
   * Deleta um registro com base nos parametros passados
   * 
   * @param array $where Chaves como nome da coluna e valor para o valor da mesma
   * 
   * @return bool Retorna se o delete foi bem sucedido ou não
   */

  public function delete($where) : bool
  {
    return $this->destroy($where);
  }

  /**
   * @param array $where Um array contendo chave e valor associado
   * @return bool Retorna o item se existir e false se não existir
   */

  public function equalsExisist($where){
    $item = $this->selectSingle(gettype($where) === 'array' ? $where : ['id' => $where]);

    return $item ? $item : false;
  }

  /**
   * Retorna os campos inseridos pelo usuario
   */

  public function getFields()
  {
    $cols = DB::getColumns($this->tb);

    return array_filter($cols, fn($col) => in_array($col['name'], $this->used_fields));
  }

  /**
   * Altera o orde id do item referente ao id passado
   * 
   * @param int $id id do item que deve ter os order id alterado
   * @param string @orderType Qual a operação deve ser feita
   * 
   * @return bool Se a operação foi bem sucedida ou não
   */

  public function order($id, $orderType){
    $item = $this->selectSingle(['id' => (int)$id]);

    switch($orderType){
      case 'up':
        $operator = '<';
        $sorted = 'DESC';
        break;
      case 'down':
        $operator = '>';
        $sorted = 'ASC';
        break;
    }

    $itemArround = $this->select()->where(['order_id' => $item['order_id']], $operator)->orderBy('order_id', $sorted)->limit(1)->get()[0];
    
    if(count($itemArround) == 0) return false;

    if(!$this->update(["order_id" => $itemArround['order_id']], ['id' => $id])) return false;
    if(!$this->update(["order_id" => $item['order_id']], ['id' => $itemArround['id']])) return false;

    return true;
  }
}

// EOF
