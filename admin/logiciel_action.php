<?php
include("include/_inc_parametres.php"); 
include("include/_inc_connexion.php");
if (isset ($_GET['action']))
{
	if ($_GET['action'] == 'modifier')
	{
		// préparation de la requête : recherche d'un formateur particulier
		$req_pre = $cnx->prepare("UPDATE Logiciel SET NomLogiciel=:Nom, SocieteEditrice=:Societe, NoLogiciel= :id ");
		// liaison de la variable à la requête préparée
		$req_pre->bindValue(':Nom', utf8_encode($_POST['NomLogiciel']), PDO::PARAM_STR);
		$req_pre->bindValue(':Societe', $_POST['SocieteEditrice'], PDO::PARAM_STR);
		$req_pre->bindValue(':id', $_POST['numero'], PDO::PARAM_INT);
		$req_pre->execute();
		
		
		?>
		<html>
		<head>
			 <meta http-equiv="refresh" content="0 ; url=../admin/logiciel.php"> 
		</head> 
		<body> 
		</body> 
		</html>
		<?php
	}
	if ($_GET['action'] == 'ajouter')
	{
		$logo = $_FILES['logo']['name'];
		// emplacement temporaire durant l'exécution du script
		$fichier = $_FILES['logo']['tmp_name'];
		// déplacement de son emplacement temporaire sur le serveur vers une destination finale ici le répertoire images
		move_uploaded_file( $_FILES['logo']['tmp_name'],"../images/".$_FILES['logo']['name']);
		
		// recherche du dernier numéro de formateur
		$resultat = $cnx->query("select MAX(NoLogiciel) + 1 num FROM Logiciel ");
		$resultat->setFetchMode(PDO::FETCH_OBJ);
		$ligne = $resultat->fetch();
		$id = $ligne->num;
		
		// préparation de la requête : recherche d'un formateur particulier
		$req_pre = $cnx->prepare("INSERT INTO Logiciel (NoLogiciel,NomLogiciel, SocieteEditrice) 
		VALUES (:id,:Nom, :Societe)");
		// liaison de la variable à la requête préparée
		$req_pre->bindValue(':id', $id, PDO::PARAM_INT);
		$req_pre->bindValue(':Nom', utf8_encode($_POST['NomLogiciel']), PDO::PARAM_STR);
		$req_pre->bindValue(':Societe', $_POST['SocieteEditrice'], PDO::PARAM_STR);
		$req_pre->execute();
		
		?>
		<html>
		<head>
			  <meta http-equiv="refresh" content="0 ; url=../admin/logiciel.php">
		</head> 
		<body> 
		</body> 
		</html>
		<?php
	}
	if ($_GET['action'] == 'supprimer')
	{
		// préparation de la requête : recherche d'un formateur particulier
		$req_pre = $cnx->prepare("DELETE FROM logiciel WHERE NoLogiciel = :id");
		// liaison de la variable à la requête préparée
		$req_pre->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
		$req_pre->execute();
		
		?>
		<html>
		<head>
			  <meta http-equiv="refresh" content="0 ; url=../admin/logiciel.php"> 
		</head> 
		<body> 
		</body> 
		</html>
		<?php
	}
}