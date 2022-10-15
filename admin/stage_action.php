<?php
include("include/_inc_parametres.php"); 
include("include/_inc_connexion.php");
if (isset ($_GET['action']))
{
	if ($_GET['action'] == 'modifier')
	{
		// préparation de la requête : recherche d'un stage particulier
		$req_pre = $cnx->prepare("UPDATE Stage SET Sujet=:Nom, DateDebut=:Deb, DateFin=:Fin,
		CodeNiveau=:Niv, NoLogiciel=:Log WHERE NoStage= :id ");
		// liaison de la variable à la requête préparée
		$req_pre->bindValue(':Nom', utf8_encode($_POST['sujet']), PDO::PARAM_STR);
		$req_pre->bindValue(':Deb', $_POST['datDeb'], PDO::PARAM_STR);
		$req_pre->bindValue(':Fin', $_POST['datFin'], PDO::PARAM_STR);
		$req_pre->bindValue(':Niv', utf8_encode($_POST['niveau']), PDO::PARAM_STR);
		$req_pre->bindValue(':Log', utf8_encode($_POST['logiciel']), PDO::PARAM_INT);
		$req_pre->bindValue(':id', $_POST['numero'], PDO::PARAM_INT);
		$req_pre->execute();
		
		
		?>
		<html>
		<head>
			 <meta http-equiv="refresh" content="0 ; url=../admin/stage.php"> 
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
		
		// recherche du dernier numéro de stage
		$resultat = $cnx->query("select MAX(NoStage) + 1 num FROM Stage ");
		$resultat->setFetchMode(PDO::FETCH_OBJ);
		$ligne = $resultat->fetch();
		$id = $ligne->num;
		
		// préparation de la requête : recherche d'un stage particulier
		$req_pre = $cnx->prepare("INSERT INTO Stage (NoStage,Sujet, Datedebut, DateFin, CodeNiveau, NoLogiciel, NoFormateur, Logo) 
		VALUES (:id,:Nom, :Deb, :Fin,:Niv,:Log, :Form, :Img )");
		// liaison de la variable à la requête préparée
		$req_pre->bindValue(':id', $id, PDO::PARAM_INT);
		$req_pre->bindValue(':Nom', utf8_encode($_POST['sujet']), PDO::PARAM_STR);
		$req_pre->bindValue(':Deb', $_POST['datDeb'], PDO::PARAM_STR);
		$req_pre->bindValue(':Fin', $_POST['datFin'], PDO::PARAM_STR);
		$req_pre->bindValue(':Niv', utf8_encode($_POST['niveau']), PDO::PARAM_STR);
		$req_pre->bindValue(':Log', $_POST['logiciel'], PDO::PARAM_INT);
		$req_pre->bindValue(':Form', $_POST['formateur'], PDO::PARAM_INT);
		$req_pre->bindValue(':Img', utf8_encode($logo), PDO::PARAM_STR);
		$req_pre->execute();
		
		?>
		<html>
		<head>
			  <meta http-equiv="refresh" content="0 ; url=../admin/stage.php">
		</head> 
		<body> 
		</body> 
		</html>
		<?php
	}
	if ($_GET['action'] == 'supprimer')
	{
		// préparation de la requête : recherche d'un stage particulier
		$req_pre = $cnx->prepare("DELETE FROM stage WHERE NoStage = :id");
		// liaison de la variable à la requête préparée
		$req_pre->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
		$req_pre->execute();
		
		?>
		<html>
		<head>
			  <meta http-equiv="refresh" content="0 ; url=../admin/stage.php"> 
		</head> 
		<body> 
		</body> 
		</html>
		<?php
	}
}