<?php
require_once 'include/engine.php';

// Vérification de la connexion
if(isset($_POST['login'],$_POST['password']))
{
	$requete=SQL("  SELECT * 
                        FROM UTILISATEUR
                        WHERE UTILISATEUR.loginUtilisateur='".$_POST['login']."'
                        AND mdpUtilisateur='".hash("sha512",$_POST['password'])."'   ");
	
	if($requete->num_rows == 1)
	{
		// Compte autorisé
		$compte=$requete->fetch_object();
		$_SESSION['id']=$compte->idUtilisateur;
		$_SESSION['nom']=$compte->nomUtilisateur." ".$compte->prenomUtilisateur;
                
		// Récupération des droits
		$requete_droit=SQL("SELECT idDroit FROM Detient WHERE idUtilisateur='".$compte->idUtilisateur."'");
		$_SESSION['droit']=array();
		while($droit=$requete_droit->fetch_object()) {
			$_SESSION['droit'][]=$droit->idDroit;
		}
		
		MessagesService::ajouter(MessagesService::OK, "Bienvenue ".$compte->prenomUtilisateur." ".$compte->nomUtilisateur);
		
		REDIRECT('index.php');
	}
	else
		MessagesService::ajouter(MessagesService::ERREUR, "Les identifiants et le mot de passe ne se correspondent pas");
}

HTML_HEADER('Connexion');
?>

<form action="" method="POST">
	<fieldset>
		<legend>Connexion</legend>
		
		<table>
			<tr>
				<td><label for="login">Votre identifiant</label></td>
				<td><input name="login" value="<?=defaultPost('login')?>"/></td>
			</tr>
			<tr>
				<td><label for="password">Votre mot de passe</label></td>
				<td><input type="password" name="password" value=""/></td>
			</tr>
		</table>
		<input type="submit" name="submit" value="Valider" />
	</fieldset>
</form>

<?php 
HTML_FOOTER();
?>