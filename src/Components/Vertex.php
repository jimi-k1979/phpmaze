<?php
namespace PhpMaze\Components;

use PhpMaze\DBObject;

class Vertex extends DBObject {
  static protected $table = 'vertices';
    
  private $columns = ['text'];
  private $text;
    
  public function set_text($string) {
    $clean_text = htmlentities(strip_tags(trim($string)));
    $this->text = $clean_text;
  }  
  
  static public function hello() {
    echo "hello<br>";
  }
    
}
