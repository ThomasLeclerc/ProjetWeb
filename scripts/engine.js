////////////////////////////////////////////////////// AFFICHAGE //////////////////////////////////////////////////////
/* AFFICHER / MASQUER */
function AfficherMasquer(objId, Force){
	obj=document.getElementById(objId)
	if((obj.className.indexOf('Masquer')!=-1 || Force=='M') && Force!='A')
		removeClass(obj,'Masquer')
	else
		addClass(obj,'Masquer')
}

function updateLabel(valeur, tableau_valeurs, tableau_labels, label_id, constante)
{
	for(i=0; i < tableau_valeurs.length; i++)
	{
		if(valeur==tableau_valeurs[i])
		{
			document.getElementById(label_id).innerHTML=tableau_labels[i];
			if(constante!=undefined)
				document.getElementById(label_id).innerHTML+=constante
			break;
		}		
	}

}



////////////////////////////////////////////////////// AJAX ////////////////////////////////////////////////////// 
function getAjax() {
	ajax=null;
    try { 
		ajax=new XMLHttpRequest(); 
	}            
    catch(e) {
		ajax=new ActiveXObject("Msxml2.XMLHTTP");
	} 
	if(ajax==null)
	{ 
		alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest / Ajax..."); 
		return null;
	}
	else
		return ajax
}

/* Exemple d'utilisation d'AJAX 
function fonction...()
{
	ajax=getAjax()
	
	ajax.onreadystatechange = function()
	{
		if(ajax.readyState == 4)
		{
			if(ajax.status==200)
			{
				document.getElementById('...').innerHTML=ajax.responseText
			}
			else
			{
				alert("Une erreur s'est produite (Err: "+ajax.status+")")
			}
		}
	} 

	ajax.open("GET", 'page.php', true); 
	ajax.send(null)
}*/