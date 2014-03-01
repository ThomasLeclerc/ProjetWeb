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
			selectable: true,
			selectHelper: true,
			select: function(start, end, allDay) {
				var title = prompt('Titre de l\'evenement : ');
				if(title){
					var description = prompt('Description de l\'evenement : ');
				
					//formatage des dates avant envoie
					start = $.fullCalendar.formatDate( start, 'yyyy-MM-dd');
					end = $.fullCalendar.formatDate( end, 'yyyy-MM-dd');
					
					$.post(	'insertEvent.php', { title: title, start: start, end: end, allDay: allDay, description:description});
					

					calendar.fullCalendar('renderEvent',
						{
							title: title,
							start: start,
							end: end,
							allDay: allDay
						}
					);
					
					calendar.fullCalendar('unselect');
				}
			},
			editable: true,
			eventSources: [
				// events source (ajax)
				{
					url: './events.php', // use the `url` property
					color: 'red',    // an option!
					textColor: 'black'  // an option!
				}
			],
			loading: function(bool) {
				if (bool) $('#loading').show();
				else $('#loading').hide();
			}	
		})
	});

	</script>

	<div id='calendar'></div>

<?php 
HTML_FOOTER();
?>
