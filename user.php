<?php
require_once 'include/engine.php';
// Si non connect�
if(!isset($_SESSION['id'])) 
    REDIRECT('login.php');
HTML_HEADER('Page perso');
?>
	<div id="content">
		
		<?php require('/var/www/ProjetWeb/agenda/selectable.php'); ?>
			
	</div>

	
	
	
	
	
<?php 
HTML_FOOTER();
?>
