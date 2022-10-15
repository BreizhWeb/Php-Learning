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
				// sur clic du bouton pour modifier un utilisateur sélectionné
				{ 
				include("include/_inc_parametres.php"); 
				include("include/_inc_connexion.php");
				
				// préparation de la requête : recherche d'un utilisateur particulier
				$req_pre = $cnx->prepare("SELECT * FROM utilisateurs WHERE Id = :id");
				// liaison de la variable à la requête préparée
				$req_pre->bindValue(':id', $_GET['Id'], PDO::PARAM_INT);
				$req_pre->execute();
				//le résultat est récupéré sous forme d'objet
				$formateur=$req_pre->fetch(PDO::FETCH_OBJ);
				?>

				<h2>Utilisateurs</h2>
				<p>Sur cette page, vous pouvez modifier un utilisateur existant.

				<form method="post" action="utilisateurs_action.php?action=modifier">
				<!-- numéro du formateur sélectionné caché -->
				<input type="hidden" name="numero" value="<?php echo $utilisateurs->Id; ?>" />
				<table>

					
					<tr>
						<td>Identifiant :</td>
						<td>
	   					<?php
						include("include/_inc_parametres.php"); 
						include("include/_inc_connexion.php");
						
						//	on récupère toutes les lignes de la table Formateur
						$resultat = $cnx->query("select * FROM utilisateurs ORDER BY Ident ;");
						//le résultat est récupéré sous forme d'objet
						$resultat->setFetchMode(PDO::FETCH_OBJ);
					
						$Chaine = "";
						$Select='<select size="1" name="Ident">';
						// tant qu'il y a des niveaux
						while ($ligne = $resultat->fetch() )	{
							$Chaine = $Chaine."<option value=".$ligne->Id.">".utf8_encode($ligne->Id)."</option>";
						}
						echo $Select.$Chaine.'</select></br>';
						?>
       					</td>
					</tr>
						
					<tr>
						<td>Mot de passe :</td>
						<td>
	    				<?php
						include("include/_inc_parametres.php"); 
						include("include/_inc_connexion.php");
						
						//	on récupère toutes les lignes de la table Formateur
						$resultat = $cnx->query("select * FROM utilisateurs ;");
						//le résultat est récupéré sous forme d'objet
						$resultat->setFetchMode(PDO::FETCH_OBJ);
						
						$Chaine = "";
						$Select='<select size="1" name="Mdp">';
						// tant qu'il y a des lignes
						while ($ligne = $resultat->fetch() )	{
							$Chaine = $Chaine."<option value=".$ligne->Id.">".utf8_encode($ligne->Id)."</option>";
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
				<h2>Utilisateurs</h2>
				<p>Sur cette page, vous pouvez ajouter un utilisateur.

				<form method="post" action="utilisateurs_action.php?action=ajouter" enctype="multipart/form-data" >
				<input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>" />
				<table class="table table-striped">
					<tr>
						<td>Identifiant :</td>
						<td><input type='text' name='Ident' required></td>
					</tr>
					<tr>
    				  	<td>Mot de passe :</td>
						<td><input type='text' name='Mdp' required ></td>
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
			// affichage lors du clic sur Formateur dans la page accueil.php
			include("include/_inc_parametres.php"); 
			include("include/_inc_connexion.php");
			
			
			//	on récupère toutes les lignes de la vue
			$resultat = $cnx->query("select * FROM utilisateurs ");
			//le résultat est récupéré sous forme d'objet
			$resultat->setFetchMode(PDO::FETCH_OBJ);
			
			?>
			<h2>Utilisateurs</h2>
			<p>A partir de cette page, vous pouvez ajouter, modifier ou supprimer des utilisateurs.
			<a href="utilisateurs.php?action=nouveau">Ajouter un utilisateur</a> </p>
		
			<table class="table table-striped">
			<thead><tr class="success">
				<td>Identifiant</td>
				<td>Mot de passe</td>
				<td>Modifier</td>
				<td>Supprimer</td>
			</tr></thead>

			<?php 
			$utilisateurs = $resultat->fetch();
			while ($utilisateurs) { ?>
				<tr>
				<td><?php echo utf8_encode($utilisateurs->Ident); ?></td>
				<td><?php echo $utilisateurs->Mdp; ?></td>
				<td><a href= 'utilisateurs.php?action=modifier&id=<?php echo $utilisateurs->Id; ?>'><span class="glyphicon glyphicon-pencil" style="color:orange"></span></a></td>
				<td><a href='utilisateurs_action.php?action=supprimer&id=<?php echo $utilisateurs->Id; ?>' onclick ="return confirm('Etes-vous vraiment sûr ?');"><span class="glyphicon glyphicon-remove" style="color:red"></span></a></td>
				</tr>
				<?php 
				// lecture du formateur suivant
				$utilisateurs = $resultat->fetch();
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