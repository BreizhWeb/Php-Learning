<?php session_start(); ?>
<html>
<head>
	<!-- titre de la page -->
		<title>Société Dutoit</title>
		<!-- type d'encodage de la page -->
		<meta charset="utf-8" />
		<!-- taille et échelle de la page -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0 ">
		<!-- liens avec les fichiers css de bootstrap -->
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
		<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet"> 
		<link rel="stylesheet" href="../styles/style.css">
</head>
<body>
<div id=conteneur>
	
  		<?php include ("include/menu.htm");	?>
	

	<div id=contenu>
	<?php 
	if ($_SESSION['connect'] == true)
		{ ?>
		<h2>Accueil</h2>
		<h4>Bienvenue dans l'espace administrateur. </h4></br></br>
		Cliquez sur les onglets pour gérer les stages, les logiciels, les niveaux, les formateurs ou les utilisateurs. </br></br></br>
		Par sécurité, n'oubliez pas de cliquer sur le lien "Déconnexion" une fois vos tâches accomplies.
		
		<?php }
	else
		{ ?>
		<h2>Erreur</h2>
		<p>Mot de passe incorrect (attention au majuscule/minuscule).</p>
		
		<?php 
		include ("login.php");
		} ?>
	</div>
	
	<p id=footer>Société Dutoit</p>
</div>

<!-- Obligatoirement avant la balise de fermeture de l'élément body  -->
	<!-- Intégration de la libraire jQuery -->
	<script src="bootstrap/js/jquery.js"></script>
	<!-- Intégration de la libraire de composants du Bootstrap -->
	<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>