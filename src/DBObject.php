<?php

namespace PhpMaze;

abstract class DBObject {
  
  protected $id;
  
  public function set_id(int $id) {
    $this->$id = $id;
  }
  
  public function get_id() {
    return $this->id;
  }
  
  static private function create_object(array $row) {
    $object = new static();
    foreach ($row as $key => $value) {
      $method = 'set_'.$key;
      $object->$method($value);
    }
    return $object;
  }

  // CRUD
  
  static public function insert_into_table() {
    global $cxn;
    
    $sql[] = "INSERT INTO ". $this->table;
    $sql[] = "(" . implode(',', $this->fields) . ")";
    
    foreach ($fields as $field) {
      $params[$field] = $this->$field;
      $field_list[] = ":{$field}";
    }
    $sql[] = "VALUES (" . implode(',',$field_list). ")";
    
    $query = $cxn->prepare(implode(' ', $sql));
    $query->execute($params);
    $this->id = $cxn->lastInsertId();
    
    return $query->rowCount();
  }
  
  static public function fetch_all() {
    global $cxn;
    
    $sql = $cxn->query(
      "SELECT * FROM ".static::$table
    );
    
    while ($row = $sql->fetch(\PDO::FETCH_ASSOC)) {
      $return_array[] = static::create_object($row);
    }
    
    return $return_array;
  }
  
  static public function fetch_by_id($id) {
    global $cxn;
    
    $sql = $cxn->prepare(
      "SELECT * FROM " .
      static::$table .
      " WHERE id = :id
        LIMIT 1"
     );
    $sql->execute(['id' => $id]);
    
    $row = $sql->fetch(\PDO::FETCH_ASSOC);
    
    return static::create_object($row);
  }
  
  public function update() {
    global $cxn;
    
    $sql[] = "UPDATE {$this->table} SET";
    foreach ($this->fields as $field) {
      $sql[] = $field . " = :" . $field;
      $params[$field] = $this->$field;
    }
    $sql[] = "WHERE id = :id";
    $params['id'] = $this->id;
    
    $query = $cxn->prepare(implode(' ', $sql));
    $query->execute($params);
    
    return $query->rowCount(); 
  }
  
  public function delete() {
    global $cxn;
    
    $sql = "DELETE FROM {$this->table} WHERE id = {$this->id}";
    $query = $cxn->query($sql);
    
    return $query->rowCount();
  }
  
}
