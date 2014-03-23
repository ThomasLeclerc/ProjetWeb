<?php
require_once 'include/engine.php';
// Si non connecté
if(!isset($_SESSION['id'])) 
    REDIRECT('login.php');
HTML_HEADER('Page perso');
?>


	<script type="text/javascript">
	function selectGroupe(idGroupe, obj){
		$("calendar").html("");
		$(".itemListeGroupes").removeClass("selected");
		$(obj).addClass("selected");
		calendar(idGroupe);
	}


	function calendar(idGroupe){		
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
					
					$.post(	'insertEvent.php', { title: title, start: start, end: end, allDay: allDay, description:description, groupe: idGroupe});
					location.reload();
				}
			},
			editable: true,
			//modification d'un événement
			eventDrop: function(event) {
				if (confirm("Etes vous sur de vouloir deplacer cet evenement ?")) {
					start = $.fullCalendar.formatDate( event.start, 'yyyy-MM-dd');
					end = $.fullCalendar.formatDate( event.end, 'yyyy-MM-dd');
					
					$.post(	'updateEvent.php', { action: 'move', id: event.id, start: start, end: end, groupe: idGroupe});
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
					url: './events.php?groupe='+idGroupe
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
		});
	}// fin calendar(idGroupe)
	
	

	</script>

	<div id="divListeGroupes">
		<ul id="listeGroupes">
		<?php
			$resultGroupes = SQL("SELECT g.libelleGroupe, g.idGroupe FROM GROUPE g, APPARTIENT a WHERE a.idUtilisateur='".$_SESSION['id']."' AND g.idGroupe=a.idGroupe");
			while($groupes = $resultGroupes->fetch_object())
			{
				echo '<li class="itemListeGroupes" onClick="selectGroupe('.$groupes->idGroupe.', this)" >'.$groupes->libelleGroupe.'</li>';
			}
		
		?>
		</ul>
	</div>
	

	<div id='calendar'><h1>Bienvenue dans l'application de gestion d'emploi du temps de groupes</h1></div>

<?php 
HTML_FOOTER();
?>
