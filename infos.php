<!DOCTYPE HTML> 
<!-- le navigateur utilisera les règles d'écriture de la DTD selon le standard W3C -->
<html lang="fr">
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
		<link rel="stylesheet" href="styles/style.css">
	</head>
	
    <!-- corps du document -->
	<body>
	<section>
	<section>
	<?php
		include ("include/entetePage.html");
	?>
	
	<!-- Bannière Bienvenue -->
    <!-- le texte sera centré -->
	<div class="text-center" class="page-header">
		<h1>Bienvenue sur notre site ! </h1> 
	</div>
	
	
	<div id=contenu>
		<h2>Editorial</h2>
		<!-- l'image peut avoir plusieurs formes : rounded (coins arrondi), ovale (circle), cadre(thumbnail) -->
		<img src="images/logo.jpg" class="img-circle" alt="Logo Dutoit" />
		
		<!-- la balise <br> unique permet le passage à la ligne du texte -->
		<p>Nous sommes heureux de vous accueillir sur le site de la société de formation continue Dutoit. </p>
		<p>Nos stages s'adressent aussi bien à des débutants qu'à des personnes souhaitant se perfectionner sur des logiciels de bureautique
        MicroSoft principalement.</p>
		
		<h2>Information</h2>
		<p>La liste de nos stages est mise à jour régulièment, n'hésitez pas à la consulter et à nous contacter.</p>
	</div>
	
	

	</section>
	</section>
	
	<!-- Obligatoirement avant la balise de fermeture de l'élément body  -->
	<!-- Intégration de la libraire jQuery -->
	<script src="bootstrap/js/jquery.js"></script>
	<!-- Intégration de la libraire de composants du Bootstrap -->
	<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>
