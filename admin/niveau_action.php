<?php
include("include/_inc_parametres.php"); 
include("include/_inc_connexion.php");
if (isset ($_GET['action']))
{
	if ($_GET['action'] == 'modifier')
	{
		// préparation de la requête : recherche d'un formateur particulier
		$req_pre = $cnx->prepare("UPDATE niveau SET CodeNiveau=:CodeNiveau, LibelleNiveau=:LibelleNiveau, NbPartMaxi=:NbPartMaxi, Prix= :Prix ");
		// liaison de la variable à la requête préparée
		$req_pre->bindValue(':CodeNiveau', $_POST['CodeNiveau'], PDO::PARAM_STR);
		$req_pre->bindValue(':LibelleNiveau', utf8_encode($_POST['LibelleNiveau']), PDO::PARAM_STR);
		$req_pre->bindValue(':NbPartMaxi', $_POST['NbPartMaxi'], PDO::PARAM_STR);
		$req_pre->bindValue(':Prix', $_POST['Prix'], PDO::PARAM_INT);
		$req_pre->execute();
		
		
		?>
		<html>
		<head>
			 <meta http-equiv="refresh" content="0 ; url=../admin/niveau.php"> 
		</head> 
		<body> 
		</body> 
		</html>
		<?php
	}
	if ($_GET['action'] == 'ajouter')
	{
		
		
		
		
		// préparation de la requête : recherche d'un formateur particulier
		$req_pre = $cnx->prepare("INSERT INTO niveau (CodeNiveau, LibelleNiveau, NbPartMaxi,Prix) 
		VALUES (:CodeNiveau,:Libelle,:NbPartMaxi, :Prix)");
		// liaison de la variable à la requête préparée
		$req_pre->bindValue(':CodeNiveau', utf8_encode($_POST['CodeNiveau']), PDO::PARAM_STR);$req_pre->bindValue(':LibelleNiveau', utf8_encode($_POST['LibelleNiveau']), PDO::PARAM_STR);
		$req_pre->bindValue(':NbPartMaxi', utf8_encode($_POST['NbPartMaxi']), PDO::PARAM_STR);
		$req_pre->bindValue(':Prix', $_POST['Prix'], PDO::PARAM_STR);
		$req_pre->execute();
		
		?>
		<html>
		<head>
			  <meta http-equiv="refresh" content="0 ; url=../admin/niveau.php">
		</head> 
		<body> 
		</body> 
		</html>
		<?php
	}
	if ($_GET['action'] == 'supprimer')
	{
		// préparation de la requête : recherche d'un formateur particulier
		$req_pre = $cnx->prepare("DELETE FROM niveau WHERE CodeNiveau = :CodeNiveau");
		// liaison de la variable à la requête préparée
		$req_pre->bindValue(':CodeNiveau', $_GET['CodeNiveau'], PDO::PARAM_INT);
		$req_pre->execute();
		
		?>
		<html>
		<head>
			  <meta http-equiv="refresh" content="0 ; url=../admin/niveau.php"> 
		</head> 
		<body> 
		</body> 
		</html>
		<?php
	}
}