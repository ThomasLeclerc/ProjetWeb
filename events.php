<?php

	require_once 'include/engine.php';

	

	$year = date('Y');
	$month = date('m');

	echo json_encode(array(
	
		array(
			'id' => 111,
			'title' => "Event1",
			'start' => "$year-$month-10",
			'url' => "http://yahoo.com/"
		),
		
		array(
			'id' => 222,
			'title' => "Event2",
			'start' => "2014-01-20",
			'end' => "2014-01-22",
			'url' => "http://yahoo.com/"
		)
	
	));

?>
