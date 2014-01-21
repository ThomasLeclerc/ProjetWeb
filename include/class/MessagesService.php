<?
/**
 * Classe permétant d'afficher des messages (pile FIFO) à l'utilisateur au travers de plusieurs pages
 */
class MessagesService {
	
	const OK = 0;
	const ERREUR = 1;
	const INFO = 2;

	/**
	 * Affiche la liste des messages en mémoire
	 */
	static function afficher() {
		if(isset($_SESSION['MessagesService']))
		{			
			while(count($_SESSION['MessagesService']))
			{
				$message=array_shift($_SESSION['MessagesService']);
				echo'<div class="msg_'.$message['type'].'">'.$message['message'].'</div>';
			}
		}
	}
	
	/**
	 * Ajoute un message
	 */
	static function ajouter($type, $message) {
		$_SESSION['MessagesService'][]=array('type' => $type, 'message' => $message);
	}
}



