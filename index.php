<?php
require_once 'include/engine.php';
// Si non connect�
if(!isset($_SESSION['id'])) 
    REDIRECT('login.php');
HTML_HEADER('Accueil');
?>
	<div id="content">
		ici agenda
	
	</div>

<?php 
HTML_FOOTER();
?>
