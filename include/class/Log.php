<?php

//require_once '../engine.php';

class Log
{
  public function add($date, $typeOperation, $user, $operation)
  {
    Securisation_SQL($date);
    Securisation_SQL($typeOperation);
    Securisation_SQL($user);
    Securisation_SQL($operation);
    $requete = SQL("INSERT INTO LOG VALUES('', " . $date . ", '" . $typeOperation . "', '" . $user . "', '" . $operation . "')");
  }
}

?>
