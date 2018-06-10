<?php
require_once('vendor/autoload.php');
require_once('init.php');

use PhpMaze\Components\Vertex;
use PhpMaze\Components\Edge;

echo "<pre>";
print_r(Vertex::fetch_by_id(1));
echo "</pre>";

?>

