<?php
include("include/_inc_parametres.php"); 
include("include/_inc_connexion.php");
if (isset ($_GET['action']))
{
	if ($_GET['action'] == 'modifier')
	{
		// préparation de la requête : recherche d'un utilisateur particulier
		$req_pre = $cnx->prepare("UPDATE utilisateurs SET Ident=:Ident, Mdp=:Mdp");
		// liaison de la variable à la requête préparée
		$req_pre->bindValue(':Ident', utf8_encode($_POST['Ident']), PDO::PARAM_STR);
		$req_pre->bindValue(':Mdp', $_POST['Mdp'], PDO::PARAM_STR);
		$req_pre->execute();
		
		
		?>
		<html>
		<head>
			 <meta http-equiv="refresh" content="0 ; url=../admin/utilisateurs.php"> 
		</head> 
		<body> 
		</body> 
		</html>
		<?php
	}
	if ($_GET['action'] == 'ajouter')
	{
		
		
		// préparation de la requête : recherche d'un formateur particulier
		$req_pre = $cnx->prepare("INSERT INTO utilisateurs (Ident, Mdp) 
		VALUES (:Ident, :Mdp)");
		// liaison de la variable à la requête préparée
		$req_pre->bindValue(':Ident', utf8_encode($_POST['Ident']), PDO::PARAM_STR);
		$req_pre->bindValue(':Mdp', $_POST['Mdp'], PDO::PARAM_STR);
		$req_pre->execute();
		
		?>
		<html>
		<head>
			  <meta http-equiv="refresh" content="0 ; url=../admin/utilisateurs.php">
		</head> 
		<body> 
		</body> 
		</html>
		<?php
	}
	if ($_GET['action'] == 'supprimer')
	{
		// préparation de la requête : recherche d'un formateur particulier
		$req_pre = $cnx->prepare("DELETE FROM utilisateurs WHERE Id = :id");
		// liaison de la variable à la requête préparée
		$req_pre->bindValue(':id', $_GET['Id'], PDO::PARAM_INT);
		$req_pre->execute();
		
		?>
		<html>
		<head>
			  <meta http-equiv="refresh" content="0 ; url=../admin/utilisateurs.php"> 
		</head> 
		<body> 
		</body> 
		</html>
		<?php
	}
}