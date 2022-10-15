<?php
include("include/_inc_parametres.php"); 
include("include/_inc_connexion.php");
if (isset ($_GET['action']))
{
	if ($_GET['action'] == 'modifier')
	{
		// préparation de la requête : recherche d'un formateur particulier
		$req_pre = $cnx->prepare("UPDATE Formateur SET NomFormateur=:Nom, PrenomFormateur=:Prenom, NoFormateur= :id ");
		// liaison de la variable à la requête préparée
		$req_pre->bindValue(':Nom', utf8_encode($_POST['NomFormateur']), PDO::PARAM_STR);
		$req_pre->bindValue(':Prenom', $_POST['PrenomFormateur'], PDO::PARAM_STR);
		$req_pre->bindValue(':id', $_POST['numero'], PDO::PARAM_INT);
		$req_pre->execute();
		
		
		?>
		<html>
		<head>
			 <meta http-equiv="refresh" content="0 ; url=../admin/formateur.php"> 
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
		$resultat = $cnx->query("select MAX(NoFormateur) + 1 num FROM Formateur ");
		$resultat->setFetchMode(PDO::FETCH_OBJ);
		$ligne = $resultat->fetch();
		$id = $ligne->num;
		
		// préparation de la requête : recherche d'un formateur particulier
		$req_pre = $cnx->prepare("INSERT INTO Formateur (NoFormateur,NomFormateur, PrenomFormateur) 
		VALUES (:id,:Nom, :Prenom)");
		// liaison de la variable à la requête préparée
		$req_pre->bindValue(':id', $id, PDO::PARAM_INT);
		$req_pre->bindValue(':Nom', utf8_encode($_POST['NomFormateur']), PDO::PARAM_STR);
		$req_pre->bindValue(':Prenom', $_POST['PrenomFormateur'], PDO::PARAM_STR);
		$req_pre->execute();
		
		?>
		<html>
		<head>
			  <meta http-equiv="refresh" content="0 ; url=../admin/formateur.php">
		</head> 
		<body> 
		</body> 
		</html>
		<?php
	}
	if ($_GET['action'] == 'supprimer')
	{
		// préparation de la requête : recherche d'un formateur particulier
		$req_pre = $cnx->prepare("DELETE FROM formateur WHERE NoFormateur = :id");
		// liaison de la variable à la requête préparée
		$req_pre->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
		$req_pre->execute();
		
		?>
		<html>
		<head>
			  <meta http-equiv="refresh" content="0 ; url=../admin/formateur.php"> 
		</head> 
		<body> 
		</body> 
		</html>
		<?php
	}
}