<?php
define('NO_SQL',1);
require_once 'include/engine.php';
// Si non connecté
if(!isset($_SESSION['id'])) 
    REDIRECT('login.php');
HTML_HEADER('Page perso');
?>


	<script type="text/javascript">
	$(document).ready(function()
		{
			$('#calendar').fullCalendar({
				// put your options and callbacks here
				editable: true,
				
				eventSources: [

					// your event source
					{
						url: './events.php', // use the `url` property
						color: 'yellow',    // an option!
						textColor: 'black'  // an option!
					}
				],
				

				loading: function(bool) {
				if (bool) $('#loading').show();
				else $('#loading').hide();
				}
				
			})
		}
	);

	</script>
	<style>

	body {
		margin-top: 40px;
		text-align: center;
		font-size: 14px;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		}

	#calendar {
		width: 900px;
		margin: 0 auto;
		}
		
			#loading {
		position: absolute;
		top: 5px;
		right: 5px;
		}

	</style>
		<div id='calendar'></div>

<?php 
HTML_FOOTER();
?>
