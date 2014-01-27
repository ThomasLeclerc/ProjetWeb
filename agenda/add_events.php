<?php
require_once '../include/engine.php';
// Values received via ajax
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];
$url = $_POST['url'];


// insert the records
$sql = SQL('INSERT INTO EVENEMENT (title, start, end, url, idCreateur) VALUES ("'.$title.'", "'.$start.'", "'.$end.'", "'.$url.'", "'.$_SESSION["id"].'")');

?>
