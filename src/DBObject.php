<?php

namespace PhpMaze;

class DBObject {
  
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
  
  static public function insert_into_table(array $params) {
    global $cxn;
    
    foreach ($params as $key => $values) {
      $col[] = $key;
    }
    
    $sql = $cxn->prepare(
      "INSERT INTO " . static::$table ." VALUES 
      (" . implode(',', $col) .")" 
    );
    
    return $cxn->lastInsertId();
  }
}
