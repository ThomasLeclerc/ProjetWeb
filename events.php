<?php

	require_once 'include/engine.php';

	//affiche les evenements des groupes dont fait partie l'utilisateur
	$query=SQL("	select e.*, u.nomUtilisateur, u.prenomUtilisateur 
					from EVENEMENT e, APPARTIENT a, UTILISATEUR u
					where a.idUtilisateur=".$_SESSION['id']."
					and a.idGroupe=".$_GET['groupe']."
					and e.idGroupe=a.idGroupe
					and u.idUtilisateur=e.idCreateur" );


	$events = array();
	
	while($row=$query->fetch_object()){
	
		array_push($events,array('id'=> $row->id , 
								'title'=>$row->title, 
								'start' => $row->start, 
								'end' => $row->end, 
								'borderColor' => "blue", 
								'description' => "Description : ".$row->description."<br/>créé par ".$row->prenomUtilisateur." ".$row->nomUtilisateur ));
		
	}

	echo json_encode($events);
	
?>
