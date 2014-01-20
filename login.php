<?php
require_once 'include/engine.php';

// V�rification de la connexion
if(isset($_POST['login'],$_POST['password']))
{
	$requete=SQL("  SELECT * 
                        FROM UTILISATEUR
                        WHERE UTILISATEUR.loginUtilisateur='".$_POST['login']."'
                        AND password='".hash("sha1",$_POST['password'])."'   ");
	if($requete->num_rows == 1)
	{
		// Compte autoris�
		$compte=$requete->fetch_object();
		$_SESSION['id']=$compte->idUtilisateur;
		$_SESSION['nom']=$compte->nomUtilisateur." ".$compte->prenomUtilisateur;
                
		// R�cup�ration des groupe li�s � l'utilisateur
		$requete_groupe=SQL("SELECT idGroupe FROM APPARTIENT WHERE idUtilisateur='".$compte->idUtilisateur."'");
		$_SESSION['groupes']=array();
		while($groupes=$requete_groupe->fetch_object()) {
			$_SESSION['groupes'][]=$groupes->idGroupe;
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
