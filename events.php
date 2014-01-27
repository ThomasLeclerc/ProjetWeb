<?php

	require_once 'include/engine.php';
/*
	$query=SQL("	select * 
					from EVENEMENT e, APPARTIENT a, UTILISATEUR u, GROUPE g
					where u.loginUtilisateur='cpetracc' 
					and a.idUtilisateur=u.idUtilisateur
					and e.idGroupe=a.idGroupe");
*/
	$query=SQL("select * from EVENEMENT");

	$year = date('Y');
	$month = date('m');

	$events = array();
	
	$row=$query->fetch_object();
	
	array_push($events,array('id'=> 1, 'title'=>$row->title, 'start' => "$year-$month-07"));
	
	$row=$query->fetch_object();
	
	array_push($events,array('id'=> 2, 'title'=>$row->title, 'start' => "2014-01-08"));

	echo json_encode($events);
	
?>
