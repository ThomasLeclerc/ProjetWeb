<?php
require_once '../include/engine.php';
/* Values received via ajax */
$id = $_POST['id'];
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];


 // update the records
$sql = SQL('UPDATE EVENEMENT SET title="'.$title.'", start="'.$start.'", end="'.$end.'" WHERE id='.$id);

?>
