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
		<!-- par défaut les tableaux occupent 100% de la page; le width fixe la largeur à 600 pixels -->
		<style> .boite {border: 2px solid #dea} </style>
	</head>
<body>
<div id=conteneur class="boite">
	<ul id=menu>
  		<?php include ("include/menu.htm");	?>
	</ul>

	<div id=contenu>
	<?php 
	if ($_SESSION['connect'] == true)
		{ 
		if (isset ($_GET['action'])) 
			{
			if ($_GET['action'] == 'modifier') 
				// sur clic du bouton pour modifier un stage sélectionné
				{ 
				include("include/_inc_parametres.php"); 
				include("include/_inc_connexion.php");
				
				// préparation de la requête : recherche d'un stage particulier
				$req_pre = $cnx->prepare("SELECT * FROM niveau WHERE CodeNiveau = :CodeNiveau");
				// liaison de la variable à la requête préparée
				$req_pre->bindValue(':CodeNiveau', $_GET['CodeNiveau'], PDO::PARAM_INT);
				$req_pre->execute();
				//le résultat est récupéré sous forme d'objet
				$niveau=$req_pre->fetch(PDO::FETCH_OBJ);
				?>

				<h2>Niveau</h2>
				<p>Sur cette page, vous pouvez modifier un niveau existant.

				<form method="post" action="niveau_action.php?action=modifier">
				<!-- numéro du stage sélectionné caché -->
				<input type="hidden" name="numero" value="<?php echo $niveau->CodeNiveau; ?>" />
				<table>
					<tr>
						<td>Code Niveau :</td>
						<td><input type='text' name='CodeNiveau' value='<?php echo utf8_encode($niveau->CodeNiveau); ?>'/></td>
					</tr>
					<tr>
						<td>Libelle Niveau :</td>
						<td><input type='text' name='LibelleNiveau' value='<?php echo utf8_encode($niveau->LibelleNiveau); ?>'/></td>
					</tr>
					
					<tr>
						<td>Nombre Participant Maximum :</td>
						<td><input type='text' name='NbPartMaxi' value='<?php echo $niveau->NbPartMaxi; ?>'/></td>
					</tr>
					<tr>
						<td>Nombre Participant Maximum :</td>
						<td><input type='text' name='Prix' value='<?php echo $niveau->Prix; ?>'/></td>
					</tr>

					
					
					<tr>
						<td></td>
						<td><input type='submit' value='Modifier' /></td>
					</tr>
				</table>
				</form><?php 
				}
			if ($_GET['action'] == 'nouveau') 
				// sur clic du lien ajouter un stage
				{ ?>
				<h2>Niveau</h2>
				<p>Sur cette page, vous pouvez ajouter un niveau.

				<form method="post" action="niveau_action.php?action=ajouter" enctype="multipart/form-data" >
				<input type="hidden" name="CodeNiveau" value="<?php echo $_SESSION['CodeNiveau']; ?>" />
				<table class="table table-striped">
					<tr>
						<td>Code Niveau :</td>
						<td><input type='text' name='CodeNiveau' required></td>
					</tr>
					<tr>
						<td>Libelle :</td>
						<td><input type='text' name='LibelleNiveau' required></td>
					</tr>
					<tr>
						<td>Nombre de participant maximum :</td>
						<td><input type='text' name='NbPartMaxi' required></td>
					</tr>
					<tr>
						<td>Prix :</td>
						<td><input type='text' name='Prix' required></td>
					</tr>
					
    				<tr>
   					     <td width="50%" align="right"></td>
   					     <td width="50%"></td>
   					 </tr>
			

					<tr>
						<td></td>
						<td><input type='submit' value='Ajouter' /></td>
					</tr>
				</table>
				</form><?php
				}
			}
		else 
			{
			// affichage lors du clic sur Stage dans la page accueil.php
			include("include/_inc_parametres.php"); 
			include("include/_inc_connexion.php");
			include("../include/dateFrancais.php");
			
			//	on récupère toutes les lignes de la vue
			$resultat = $cnx->query("select * FROM niveau ");
			//le résultat est récupéré sous forme d'objet
			$resultat->setFetchMode(PDO::FETCH_OBJ);
			
			?>
			<h2>Niveau</h2>
			<p>A partir de cette page, vous pouvez ajouter, modifier ou supprimer des niveaux.
			<a href="niveau.php?action=nouveau">Ajouter un niveau</a> </p>
		
			<table class="table table-striped">
			<thead><tr class="success">
				<td>Code Niveau</td>
				<td>Libelle</td>
				<td>Nombre de participant maximum</td>
				<td>Prix</td>
				<td>Modifier</td>
				<td>Supprimer</td>
			</tr></thead>

			<?php 
			$niveau = $resultat->fetch();
			while ($niveau) { ?>
				<tr>
				<td><?php echo utf8_encode($niveau->CodeNiveau); ?></td>
				<td><?php echo utf8_encode($niveau->LibelleNiveau); ?></td>
				<td><?php echo $niveau->NbPartMaxi; ?></td>
				<td><?php echo $niveau->Prix; ?></td>
				<td><a href= 'niveau.php?action=modifier&id=<?php echo $niveau->CodeNiveau; ?>'><span class="glyphicon glyphicon-pencil" style="color:orange"></span></a></td>
				<td><a href='niveau_action.php?action=supprimer&id=<?php echo $niveau->CodeNiveau; ?>' onclick="return confirm('Etes vous vraiment sur ?');"><span class="glyphicon glyphicon-remove" style="color:red"></span></a></td>
				</tr>
				<?php 
				// lecture du stage suivant
				$niveau = $resultat->fetch();
			} ?>
			</table><?php
			}
	 	}
	else
		{ ?>
		<h2>Erreur</h2>
		<p>Merci de vous connectez avant d'accéder à cette page</p>
		
		<?php 
		include ('login.php');
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