<?php
	require_once 'include/engine.php';
	// Si non connecté
	if(!isset($_SESSION['id'])) 
		REDIRECT('login.php');
	
	$start = $_GET["start"];
	$end = $_GET["end"];
	
	$events = array();
	date('d/m/Y', 1234567890);
	$requete = SQL('select ev.* from EVENEMENT ev, PARTICIPE pa 
					where pa.idUtilisateur = "'.$_SESSION['id'].'" and
					pa.idEvenement = ev.idEvenement and
					ev.dateDebut >= '.date('Y-m-d', $start).' and
					ev.dateDebut <= '.date('Y-m-d', $end));
	while($result = $requete->fetch_object())
	{
		$eventArray['title'] = $row['libelleEvenement'];
		$eventArray['start'] = $row['dateDebut'];
		$eventsArray['allDay'] = "";
		$events[] = $eventArray;
	}
	
	header('Content-type: application/json');


	echo json_encode($events);
	

?>
