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
				// sur clic du bouton pour modifier un formateur sélectionné
				{ 
				include("include/_inc_parametres.php"); 
				include("include/_inc_connexion.php");
				
				// préparation de la requête : recherche d'un formateur particulier
				$req_pre = $cnx->prepare("SELECT * FROM Formateur WHERE NoFormateur = :id");
				// liaison de la variable à la requête préparée
				$req_pre->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
				$req_pre->execute();
				//le résultat est récupéré sous forme d'objet
				$formateur=$req_pre->fetch(PDO::FETCH_OBJ);
				?>

				<h2>Formateur</h2>
				<p>Sur cette page, vous pouvez modifier un formateur existant.

				<form method="post" action="formateur_action.php?action=modifier">
				<!-- numéro du formateur sélectionné caché -->
				<input type="hidden" name="numero" value="<?php echo $formateur->NoFormateur; ?>" />
				<table>

					
					<tr>
						<td>NomFormateur :</td>
						<td>
	   					<?php
						include("include/_inc_parametres.php"); 
						include("include/_inc_connexion.php");
						
						//	on récupère toutes les lignes de la table Formateur
						$resultat = $cnx->query("select * FROM Formateur ORDER BY NomFormateur ;");
						//le résultat est récupéré sous forme d'objet
						$resultat->setFetchMode(PDO::FETCH_OBJ);
					
						$Chaine = "";
						$Select='<select size="1" name="formateur">';
						// tant qu'il y a des niveaux
						while ($ligne = $resultat->fetch() )	{
							$Chaine = $Chaine."<option value=".$ligne->NoFormateur.">".utf8_encode($ligne->NoFormateur)."</option>";
						}
						echo $Select.$Chaine.'</select></br>';
						?>
       					</td>
					</tr>
						
					<tr>
						<td>PrenomFormateur :</td>
						<td>
	    				<?php
						include("include/_inc_parametres.php"); 
						include("include/_inc_connexion.php");
						
						//	on récupère toutes les lignes de la table Formateur
						$resultat = $cnx->query("select * FROM Formateur ;");
						//le résultat est récupéré sous forme d'objet
						$resultat->setFetchMode(PDO::FETCH_OBJ);
						
						$Chaine = "";
						$Select='<select size="1" name="logiciel">';
						// tant qu'il y a des lignes
						while ($ligne = $resultat->fetch() )	{
							$Chaine = $Chaine."<option value=".$ligne->NoFormateur.">".utf8_encode($ligne->NoFormateur)."</option>";
						}
			
						echo $Select.$Chaine.'</select>';
						?>
					</tr>
					
					
					
					
					
					<tr>
						<td></td>
						<td><input type='submit' value='Modifier' /></td>
					</tr>
				</table>
				</form><?php 
				}
			if ($_GET['action'] == 'nouveau') 
				// sur clic du lien ajouter un formateur
				{ ?>
				<h2>formateur</h2>
				<p>Sur cette page, vous pouvez ajouter un formateur.

				<form method="post" action="formateur_action.php?action=ajouter" enctype="multipart/form-data" >
				<input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>" />
				<table class="table table-striped">
					<tr>
						<td>NomFormateur :</td>
						<td><input type='text' name='NomFormateur' size="30" required></td>
					</tr>
					<tr>
    				  	<td>PrenomFormateur :</td>
						<td><input type='text' name='PrenomFormateur' required ></td>
					</tr>
					<tr>
						<td></td>
						<td><input type='submit' value='Modifier' /></td>
					</tr>
				</table>
				</form><?php
				}
			}
		else 
			{
			// affichage lors du clic sur Formateur dans la page accueil.php
			include("include/_inc_parametres.php"); 
			include("include/_inc_connexion.php");
			
			
			//	on récupère toutes les lignes de la vue
			$resultat = $cnx->query("select * FROM Formateur ");
			//le résultat est récupéré sous forme d'objet
			$resultat->setFetchMode(PDO::FETCH_OBJ);
			
			?>
			<h2>Formateur</h2>
			<p>A partir de cette page, vous pouvez ajouter, modifier ou supprimer des formateurs.
			<a href="formateur.php?action=nouveau">Ajouter un formateur</a> </p>
		
			<table class="table table-striped">
			<thead><tr class="success">
				<td>NomFormateur</td>
				<td>PrenomFormateur</td>
				<td>Modifier</td>
				<td>Supprimer</td>
			</tr></thead>

			<?php 
			$formateur = $resultat->fetch();
			while ($formateur) { ?>
				<tr>
				<td><?php echo utf8_encode($formateur->NomFormateur); ?></td>
				<td><?php echo $formateur->PrenomFormateur; ?></td>
				<td><a href= 'formateur.php?action=modifier&id=<?php echo $formateur->NoFormateur; ?>'><span class="glyphicon glyphicon-pencil" style="color:orange"></span></a></td>
				<td><a href='formateur_action.php?action=supprimer&id=<?php echo $formateur->NoFormateur; ?>' onclick ="return confirm('Etes-vous vraiment sûr ?');"><span class="glyphicon glyphicon-remove" style="color:red"></span></a></td>
				</tr>
				<?php 
				// lecture du formateur suivant
				$formateur = $resultat->fetch();
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