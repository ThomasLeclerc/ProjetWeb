<?php
require_once 'include/engine.php';
// Si non connecté
/*if(!isset($_SESSION['id'])) 
    REDIRECT('login.php');*/
HTML_HEADER('Page perso');
?>

	<div id='calendar'></div>
	
	<script type="text/javascript">
	$(document).ready(function()
		{
			// page is now ready, initialize the calendar..			
			$('#calendar').fullCalendar({
				// put your options and callbacks here
			})
			
			$('#tabs').tabs({
				show: function (event, ui) {
					$('#calendar').fullCalendar('render');
				}
			});
			
		}
	);
	

	</script>
	
	
<?php 
HTML_FOOTER();
?>
