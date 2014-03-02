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
			//ajout d'un événement
			select: function(start, end, allDay) {
				var title = prompt('Titre de l\'evenement : ');
				if(title){
					var description = prompt('Description de l\'evenement : ');
				
					//formatage des dates avant envoie
					start = $.fullCalendar.formatDate( start, 'yyyy-MM-dd');
					end = $.fullCalendar.formatDate( end, 'yyyy-MM-dd');
					
					$.post(	'insertEvent.php', { title: title, start: start, end: end, allDay: allDay, description:description});
					location.reload();
				}
			},
			editable: true,
			//modification d'un événement
			eventDrop: function(event) {
				if (confirm("Etes vous sur de vouloir deplacer cet evenement ?")) {
					start = $.fullCalendar.formatDate( event.start, 'yyyy-MM-dd');
					end = $.fullCalendar.formatDate( event.end, 'yyyy-MM-dd');
					
					$.post(	'updateEvent.php', { action: 'move', id: event.id, start: start, end: end});
				}

			},
			//suppresion d'un événément
			eventClick: function(event){
				if(confirm("Supprimer cet evenement ?")){
					$.post(	'updateEvent.php', { action: 'delete', id: event.id});
					location.reload();
				}
			},
			//récupération des événéments
			eventSources: [
				{
					url: './events.php'
				}
			],
			eventRender: function(event, element) {
				element.qtip({
					content: event.description
				});
			},
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
