<?php
	require_once '../include/engine.php';
	
	
	$start = $_GET["start"];
	$end = $_GET["end"];
	
	$requete = SQL('select ev.id, ev.title, ev.start, ev.end, ev.allDay from EVENEMENT ev, PARTICIPE pa 
					where pa.idUtilisateur = "'.$_SESSION['id'].'" and
					pa.idEvenement = ev.id ORDER BY id');
	$events = array();
	while($ev = $requete->fetch_assoc()){
		$events [] = $ev;
	}
	var_dump(json_encode($events));
	echo json_encode($events);
	

?>
