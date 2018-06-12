<?php
namespace PhpMaze\Components;

use PhpMaze\DBObject;

class Vertex extends DBObject {
  static protected $table = 'vertices';
    
  protected $fields = ['maze_id', 'text'];
  private $maze_id;
  private $text;
  
  public function set_maze_id(int $int) {
    $this->maze_id = $int;
  }
  
  public function get_maze_id() {
    return $this->maze_id;
  }
  
  public function set_text($string) {
    $clean_text = htmlentities(strip_tags(trim($string)));
    $this->text = $clean_text;
  }  
  
  public function get_text($string) {
    return $this->text;
  }
    
}
