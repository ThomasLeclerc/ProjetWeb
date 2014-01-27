<?php

	require_once 'include/engine.php';

	//affiche les evenements des groupes dont fait partie l'utilisateur
	$query=SQL("	select e.* 
					from EVENEMENT e, APPARTIENT a
					where a.idUtilisateur=".$_SESSION['id']."
					and e.idGroupe=a.idGroupe" );

	$events = array();
	
	while($row=$query->fetch_object()){
	
		array_push($events,array('id'=> $row->id , 'title'=>$row->title, 'start' => $row->start, 'end' => $row->end));
		
	}

	echo json_encode($events);
	
?>
