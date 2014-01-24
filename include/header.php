<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="description" content=""/>
		<title><?=$titre?> - Dynamic Web Project - </title>
		<link rel="stylesheet" type="text/css" href="<?=SHORT_RACINE?>styles/style.css" />
		<!--<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />-->
		<script src="<?=SHORT_RACINE?>scripts/engine.js" type="text/javascript"></script>
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.1.0.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

	</head>
	<body>
		<div id="header">
			<a href="<?=SHORT_RACINE?>index.php"><input type="button" value="Accueil" class="accueil" /></a>
			<h1><?=$titre?></h1>
			<h6>Emploi du temps de groupe</h6>
			<?php if(isset($_SESSION['id'])) { ?>
				<div class="droite">
					<h3><?=$_SESSION['nom']?></h3>
					<a href="<?=SHORT_RACINE?>logout.php" title="Se déconnecter">Se deconnecter</a>
				</div>
			<?php } ?>
		</div>
		<?//MessagesService::afficher();?>
		
