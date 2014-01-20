<?php

require_once("__configuration__.php");

$timeStart=microtime(true);

/*=======================================================================================================================================*/
/* SESSION */
/*=======================================================================================================================================*/
// Lancement des sessions
session_start();

/*=======================================================================================================================================*/
/* GESTIONNAIRE D'ERREUR */
/*=======================================================================================================================================*/

function Gestionnaire_Erreurs($errno="", $errstr="", $errfile="", $errline="",$errcontext="")
{
	// Liste des types d'erreur/information et les r�gles d'arr�t
	switch($errno)
	{
		case E_USER_ERROR:		$Type="Erreur User";			$Died=1;		break;
		case E_USER_WARNING:    	$Type="Attention User";			$Died=1;		break;
		case E_USER_NOTICE:		$Type="Information User";		$Died=0;		break;
		case E_ERROR:			$Type="Erreur ";			$Died=1;		break;
		case E_WARNING:			$Type="Attention ";			$Died=1;		break;
		case E_NOTICE:			$Type="Information ";			$Died=0;		break;
		default:			$Type="Erreur ($errno)";		$Died=1;		break;
	}

	// Pr�cision du debug via les inclusions
	$Qui=debug_backtrace();
	//$errfile=$Qui[0]['file'];
	//$errline=$Qui[0]['line'];

	// Enregistrement dans les fichiers de log
	// Version simplifi�
	 //error_log(date('H\:i\:s d/m/y').'	'.($Died?'1':'0').'	['.$Type.']	'.$errstr.'	Ligne:'.$errline.'	Fichier:'.$errfile, 3, RACINE.'log/Log_'.date('Y-m-d').'.txt');
	// Version trace
	 //error_log(date('H\:i\:s d/m/y').'	'.($Died?'1':'0').'	['.$Type.']	'.$errstr.'	Ligne:'.$errline.'	Fichier:'.$errfile."\n".print_r(debug_backtrace(),1)."\n\n", 3, RACINE.'log/Log_trace_'.date('Y-m-d').'.txt');
	// Version ultra d�tail�
	 //error_log(date('H\:i\:s d/m/y').'	'.($Died?'1':'0').'	['.$Type.']	'.$errstr.'	Ligne:'.$errline.'	Fichier:'.$errfile."\n".print_r($errcontext,1)."\n".print_r(debug_backtrace(),1)."\n\n", 3, RACINE.'log/Log_ultra_'.date('Y-m-d').'.txt');
	
	if(!DEVELOPPEMENT)	// Affichage du message d'erreur en mode administratif
		echo "<br><b>Une Erreur s'est produite:</b><br>Elle a �t� enregistr�e dans le journal: <br /><b><font color=".($Died?'red':'orange').">[".$Type."] le ".date('H:i:s d/m/Y')."</font><br>Merci de bien vouloir ressayer ult�rieurement et alerter l'�quipe de d�veloppement.";
	else
	{	// Affichage du message d'erreur
		echo "<div class='erreur' style='color:".($Died?'red':'orange')."''>
			<h3>[".$Type."] ".$errstr."</a></h3>
			Ligne: ".$errline."<br>
			Fichier: ".$errfile."<br />
			<pre>".print_r(debug_backtrace(),1)."</pre>
			</div>";
	}

	// Stop le script si cela est n�cessaire par rapport au type d'erreur
	if($Died)
		die();
}

// Associe le gestionnaire d'erreur
set_error_handler("Gestionnaire_Erreurs", E_ALL);

/*=======================================================================================================================================*/
/* CHARGEUR DE CLASS */
/*=======================================================================================================================================*/

/*function __autoload($nom)
{
	require_once(INCLUDE_DIR.'class/'.$nom.'.php');
}*/

/*=======================================================================================================================================*/
/* FORMAT DATE */
/*=======================================================================================================================================*/
// Affichage de la date ou d'une diff�rence de date
function DateFormat($Time=0, $Complete=false)
{
	if(!$Complete)
		return date('d/m/Y � H:i',$Time);
	else
	{
		$Jour = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi","Samedi");
		$Mois = array("Janvier", "F�vrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Ao�t", "Septembre", "Octobre", "Novembre", "D�cembre");
		return $Jour[date("w",$Time)]." ".date("d",$Time)." ".$Mois[date("n",$Time)]." ".date("Y",$Time)." � ".date('H\hi',$Time);
	}
}
function DateCountDown($Time)
{
	$Jours=$Time/86400;
	$Heures=$Time%86400/3600;
	$Minutes=$Time%86400%3600/60;
	$Secondes=$Time%86400%3600%60;

	// Cr�ation de l'affichage
	$Date_Affichage='';
	if($Jours>0)	$Date_Affichage.=floor($Jours).' J ';
	if($Heures>0)	$Date_Affichage.=floor($Heures).' h ';
	if($Minutes>0)	$Date_Affichage.=floor($Minutes).' m ';
	if($Secondes>0)	$Date_Affichage.=floor($Secondes).' s';

	// Retour de l'affichage de la diff�rence de dur�e
	return $Date_Affichage;
}


/*=======================================================================================================================================*/
/* SECURISATION PREMIER NIVEAU (FAILLE XSS) */
/*=======================================================================================================================================*/

// S�curisation n�1
// /!\ Magic_quote = d�sactiv� !
// Fonction de protection des carct�res HTML
function Securisation_HTML(&$Groupe)
{
	// On passe en revu tous les �l�ments de l'objets de type string
	if(!is_string($Groupe))
	{
		foreach ($Groupe as &$Elements)
		{
			if(!is_array($Elements))
			{	// L'�l�ment n'est pas un tableau, on le prot�ges des caract�res HTML
				$Elements=htmlentities($Elements, ENT_QUOTES, 'UTF-8');
			}
			else
			{	// L'�l�ment est un tableau, on r�cursive alors
				Securisation_HTML($Elements);
			}
		}
	}
	else
	{
		$Groupe=htmlentities($Groupe, ENT_QUOTES, 'UTF-8');
	}
}

// On passe en revu POST et GET
//Securisation_HTML($_POST);
//Securisation_HTML($_GET);



/*=======================================================================================================================================*/
/* GESTIONNAIRE MYSQL && SECURISATION DEUXIEME NIVEAU (INJECTION SQL) */
/*=======================================================================================================================================*/

/* IMPORTANT */
/*
 * Si la page ne contient aucune requ�te SQL, il faut D�CLARER un define('NO_SQL',1) 
 * AVANT d'inclure le fichier engine.php
 * dans le but d'�viter une connexion automatique � la base de donn�es
 */

// D�sactivation si on ne veut pas de connexion � la BDD
if(!defined('NO_SQL'))
{
	// Variables de statistique
	$BDD_Nombre_Requete=0;
	$BDD_Temps=0;

	// Gestionnaire des erreurs SQL (redirection vers le gestionnaire d'erreur classique avec plus d'information)
	function Gestionnaires_Erreurs_SQL($Sql='')
	{
		// R�cup�ration des informations SQL
		global $Mysql;

		// R�cup�ration du debug (qui appel qui)
		$Details=debug_backtrace();

		// Cr�er l'erreur, qui sera ensuite trait� par Gestionnaires_Erreur();
		Gestionnaire_Erreurs(E_USER_ERROR, 'MYSQL: '.$Mysql->errno.' : '.$Mysql->error.'<br />'.$Sql, $Details[1]['file'], $Details[1]['line']);
	}

	// Connexion � la base de donn�e
	$Mysql = new mysqli(SQL_HOSTNAME, SQL_USER, SQL_PASSWORD, SQL_DATABASE);
	if(SQL_SET_NAME_UTF8)
		$Mysql->query("SET NAMES utf8");

	// V�rifie que la connexion a bien �t� �tablie
	if ($Mysql->connect_error)
		Gestionnaires_Erreurs_SQL();

	// S�curisation n�2
	function Securisation_SQL(&$Groupe)
	{
		global $Mysql;

		// On passe en revu tous les �l�ments de l'objets
		if(is_array($Groupe))
		{
			foreach ($Groupe as &$Elements)
			{
				if(!is_array($Elements))
				{	// L'�l�ment n'est pas un tableau, on le prot�ges des caract�res HTML
					$Elements=$Mysql->real_escape_string(trim($Elements));
				}
				else
				{	// L'�l�ment est un tableau, on r�cursive alors
					Securisation_SQL($Elements);
				}
			}
		}
		else
			$Groupe=$Mysql->real_escape_string(trim($Groupe));
	}

	
	// On passe en revu POST et GET obligatoire (Anti injection SQL)
	Securisation_SQL($_POST);
	Securisation_SQL($_GET);

	function SQL($Requete)
	{
		// R�cup�rations de la BDD et des statisiques
		global $Mysql,$BDD_Nombre_Requete,$BDD_Temps;

		// Compteur de la dur�e � z�ro
		$BDD_Temps_Ini=microtime(1);

		// Affiche la requ�te en mode d�bugage
		if(DEVELOPPEMENT && SQL_AFFICHER_REQUETES)
			echo '<b>Requ�te:</b> '.$Requete.'<br/>';

		// Envoi de la requ�te au serveur
		$Resultat = $Mysql->query($Requete) or Gestionnaires_Erreurs_SQL($Requete);

		// Mise a jour des statistiques
		$BDD_Nombre_Requete++;
		$BDD_Temps+=microtime(1)-$BDD_Temps_Ini;

		// Retourne le r�sultat
		return $Resultat;
	}
	
	function SQL_insert_id() {
		// R�cup�rations de la BDD
		global $Mysql;
		return $Mysql->insert_id;
	}
	function SQL_affected_rows() {
		// R�cup�rations de la BDD
		global $Mysql;
		return $Mysql->affected_rows;
	}
	
	//$Resultat->fetch_assoc();
	//$Resultat->fetch_object();
	//$Resultat->num_rows;
	
	/* Utilisation du SQL */
	/*
	 $age=10;
	 $requete=SQL("SELECT id, nom FROM utilisateurs WHERE age>=".$age);
	 // Boucle sur les r�sultats
	 while($resultat=$requete->fetch_object()){
	 	echo "Id :".$resultat->id."<br/>Nom : ".$resultat->nom."<br/><br/>";
	 }
	 
	 $age=10;
	 $requete=SQL("SELECT id, nom FROM utilisateurs WHERE age>=".$age);
	 echo "Il y a ".$requete->num_rows." utilisateurs : </br>";
	 while($resultat=$requete->fetch_object()){
	 	echo "Id :".$resultat->id."<br/>Nom : ".$resultat->nom."<br/><br/>";
	 }
	 
	 $id=456;
	 $requete=SQL("SELECT id, nom FROM utilisateurs WHERE id=".$id);
	 $resultat=$requete->fetch_object();
	 echo "Id :".$resultat->id."<br/>Nom : ".$resultat->nom."<br/><br/>";
	 
	 $requete=SQL("INSERT ...");
	 */
	
}



/*=======================================================================================================================================*/
/* SIMPLIFICATION PRE-REMPLISSAGE DES FORMULAIRE */
/*=======================================================================================================================================*/

function defaultPost($nom,$default='')
{
	if(isset($_POST[$nom]))
		return $_POST[$nom];
	else
		return $default;
}
function defaultPostArray($nom,$indice,$default='')
{
	if(isset($_POST[$nom][$indice]))
		return $_POST[$nom][$indice];
	else
		return $default;
}

function defaultPostSelected($nom,$valeur,$default=false)
{
	if(isset($_POST[$nom]))
	{
		if($valeur==$_POST[$nom])
			return 'selected="selected"';
	}
	elseif($default)
		return 'selected="selected"';
	
	return '';
}

/*=======================================================================================================================================*/
/* REDIRECTION */
/*=======================================================================================================================================*/

function REDIRECT($page)
{
	header('Location: '.$page);
	exit;
}
/*=======================================================================================================================================*/
/* DECLARATION ERREUR 404, 403 */
/*=======================================================================================================================================*/

function ERREUR($Code_erreur)
{
	require(INCLUDE_DIR.'erreur.php');
	//exit; -> Ex�cut� dans le fichier erreur.php
}


/*=======================================================================================================================================*/
/* HEADER & FOOTER */
/*=======================================================================================================================================*/

function HTML_HEADER($titre, $scripts=array())
{
	require(INCLUDE_DIR.'header.php');
}
function HTML_FOOTER()
{
	global $timeStart;
	require(INCLUDE_DIR.'footer.php');
}

/*=======================================================================================================================================*/
/* DROIT */
/*=======================================================================================================================================*/

function necessiteDroit($numero) {
	if(!isset($_SESSION['droit']) || !in_array($numero, $_SESSION['droit']))
	{
		MessagesService::ajouter(MessagesService::ERREUR, "Vous n'avez pas les droits n�cessaire pour utiliser cette page.<br/><a href='".SHORT_RACINE."login.php'>Connectez-vous</a>");
		HTML_HEADER('Droits insuffisants');
		HTML_FOOTER();
		exit;
	}
}

/*=======================================================================================================================================*/
/* UTILISATEUR */
/*=======================================================================================================================================*/

function whoami() {
	return $_SESSION['nom'].' ['.$_SESSION['service'].'] ('.$_SESSION['telephone'].') ';
}
