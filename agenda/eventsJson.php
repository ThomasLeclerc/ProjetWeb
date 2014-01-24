<?php
	require_once 'include/engine.php';
	// Si non connecté
	if(!isset($_SESSION['id'])) 
		REDIRECT('login.php');
	
	$start = $_GET["start"];
	$end = $_GET["end"];
	
	$events = array();
	
	$requete = SQL('select ev.* from EVENEMENT ev, PARTICIPE pa 
					where pa.idUtilisateur = "'.$_SESSION['id'].'" and
					

?>
