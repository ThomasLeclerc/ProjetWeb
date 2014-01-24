<?php
	require_once 'include/engine.php';
	// Si non connecté
	if(!isset($_SESSION['id'])) 
		REDIRECT('login.php');
	
	$start = $_GET["start"];
	$end = $_GET["end"];
	
	$requete = SQL('select ev.* from EVENEMENT ev, PARTICIPE pa 
					where pa.idUtilisateur = "'.$_SESSION['id'].'" and
					pa.idEvenement = ev.idEvenement and
					ev.dateDebut >= '.$start.' and
					ev.dateDebut <= '.$end);


	echo json_encode($requete->fetchAll());
	

?>
