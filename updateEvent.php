<?php	
	require_once 'include/engine.php';
	$action = $_POST['action'];
	
	$id = $_POST['id'];

	
	if($action=='move'){
		$start = $_POST['start'];
		$end = $_POST['end'];
		if($end==null)
			$result = SQL('UPDATE EVENEMENT set start="'.$start.'" where id='.$id);
		else
			$result = SQL('UPDATE EVENEMENT set start="'.$start.'", end="'.$end.'" where id='.$id);

	}else if($action=="delete"){
		$result = SQL('DELETE FROM EVENEMENT WHERE id='.$id);
	}
	
	
?>
