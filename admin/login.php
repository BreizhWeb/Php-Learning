<?php
if (isset ($_GET['action']))
{
if ( $_GET['action'] == 'connexion' ) 
	// après validation de identifiant et du mot de passe
	{
	if ($_POST['ident'] == '' OR $_POST['password'] == '') 
		{
		echo "Merci de bien renseigner l'ensemble des champs";
		echo "<br />";
		echo "<a href='index.php'>Retour</a>";
		}
	else
		{
		// démarrage de la session et sauvegarde des informations dans 2 variables
		session_start();
		
		include("include/_inc_parametres.php"); 
	    include("include/_inc_connexion.php");
		
		// préparation de la requête : recherche de l'utilisateur
		$req_pre = $cnx->prepare("SELECT Mdp FROM utilisateurs WHERE Ident = :id");
		// liaison de la variable à la requête préparée
		$req_pre->bindValue(':id', $_POST['ident'] , PDO::PARAM_STR);
		$req_pre->execute();
		//le résultat est récupéré sous forme d'objet
		$ligne=$req_pre->fetch(PDO::FETCH_OBJ);
		// récupération du mot de passe
		$mdp = $ligne->Mdp;
		
		// fermeture du curseur associé à un jeu de résultats
		$req_pre->closeCursor();
		
		// la variable de session connect vaut true ou false!!!!!!!!
		$_SESSION['connect'] = $mdp == $_POST['password'];
		
		// $_SESSION['connect'] = $mdp == sha1($_POST['password']);
		$_SESSION['id'] = $_POST['ident'];
		?>
		<html>
		<head>
			<meta http-equiv="refresh" content="0 ; url=accueil.php">  
		</head> 
		<body> 
		</body> 
		</html>
		<?php
		}
	}

elseif ( $_GET['action'] == 'deconnexion' )
	{
	// après avoir cliqué sur le bouton Déconnexion de la page accueil.php 
	// destruction de la session et retour à la page index.php du début du site 
	session_start();
	session_destroy(); ?>
	<html>
	<head>
		<meta http-equiv="refresh" content="0 ; url=../index.php">  
	</head> 
	<body> 
	</body> 
	</html><?php
	}
}
else {
?>
	<!-- aucune action : premier appel à partir de la page index.php -->
	<form method="post" action="login.php?action=connexion">
		<table>
			<tr>
				<td>Identifiant :</td>
				<td><input type="text" name='ident' /></td>
			</tr>
			<tr>
				<td>Mot de passe :</td>
				<td><input type="password" name='password' /></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Connexion"/></td>
			</tr>
		</table>
	</form>
<?php } ?>
