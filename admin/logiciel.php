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
				// sur clic du bouton pour modifier un logiciel sélectionné
				{ 
				include("include/_inc_parametres.php"); 
				include("include/_inc_connexion.php");
				
				// préparation de la requête : recherche d'un logiciel particulier
				$req_pre = $cnx->prepare("SELECT * FROM Logiciel WHERE NoLogiciel = :id");
				// liaison de la variable à la requête préparée
				$req_pre->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
				$req_pre->execute();
				//le résultat est récupéré sous forme d'objet
				$logiciel=$req_pre->fetch(PDO::FETCH_OBJ);
				?>

				<h2>Logiciel</h2>
				<p>Sur cette page, vous pouvez modifier un logiciel existant.

				<form method="post" action="logiciel_action.php?action=modifier">
				<!-- numéro du logiciel sélectionné caché -->
				<input type="hidden" name="numero" value="<?php echo $logiciel->NoLogiciel; ?>" />
				<table>

					
					<tr>
						<td>NomLogiciel :</td>
						<td>
	   					<?php
						include("include/_inc_parametres.php"); 
						include("include/_inc_connexion.php");
						
						//	on récupère toutes les lignes de la table Logiciel
						$resultat = $cnx->query("select * FROM Logiciel ORDER BY NomLogiciel ;");
						//le résultat est récupéré sous forme d'objet
						$resultat->setFetchMode(PDO::FETCH_OBJ);
					
						$Chaine = "";
						$Select='<select size="1" name="logiciel">';
						// tant qu'il y a des niveaux
						while ($ligne = $resultat->fetch() )	{
							$Chaine = $Chaine."<option value=".$ligne->NoLogiciel.">".utf8_encode($ligne->NoLogiciel)."</option>";
						}
						echo $Select.$Chaine.'</select></br>';
						?>
       					</td>
					</tr>
						
					<tr>
						<td>SocieteEditrice :</td>
						<td>
	    				<?php
						include("include/_inc_parametres.php"); 
						include("include/_inc_connexion.php");
						
						//	on récupère toutes les lignes de la table Logiciel
						$resultat = $cnx->query("select * FROM Logiciel ;");
						//le résultat est récupéré sous forme d'objet
						$resultat->setFetchMode(PDO::FETCH_OBJ);
						
						$Chaine = "";
						$Select='<select size="1" name="logiciel">';
						// tant qu'il y a des lignes
						while ($ligne = $resultat->fetch() )	{
							$Chaine = $Chaine."<option value=".$ligne->NoLogiciel.">".utf8_encode($ligne->NoLogiciel)."</option>";
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
				// sur clic du lien ajouter un logiciel
				{ ?>
				<h2>logiciel</h2>
				<p>Sur cette page, vous pouvez ajouter un logiciel.

				<form method="post" action="logiciel_action.php?action=ajouter" enctype="multipart/form-data" >
				<input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>" />
				<table class="table table-striped">
					<tr>
						<td>NomLogiciel :</td>
						<td><input type='text' name='NomLogiciel' size="30" required></td>
					</tr>
					<tr>
    				  	<td>SocieteEditrice :</td>
						<td><input type='text' name='SocieteEditrice' required ></td>
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
			// affichage lors du clic sur Logiciel dans la page accueil.php
			include("include/_inc_parametres.php"); 
			include("include/_inc_connexion.php");
			
			
			//	on récupère toutes les lignes de la vue
			$resultat = $cnx->query("select * FROM Logiciel ");
			//le résultat est récupéré sous forme d'objet
			$resultat->setFetchMode(PDO::FETCH_OBJ);
			
			?>
			<h2>Logiciel</h2>
			<p>A partir de cette page, vous pouvez ajouter, modifier ou supprimer des logiciel.
			<a href="logiciel.php?action=nouveau">Ajouter un logiciel</a> </p>
		
			<table class="table table-striped">
			<thead><tr class="success">
				<td>NomLogiciel</td>
				<td>SocieteEditrice</td>
				<td>Modifier</td>
				<td>Supprimer</td>
			</tr></thead>

			<?php 
			$logiciel = $resultat->fetch();
			while ($logiciel) { ?>
				<tr>
				<td><?php echo utf8_encode($logiciel->NomLogiciel); ?></td>
				<td><?php echo $logiciel->SocieteEditrice; ?></td>
				<td><a href= 'logiciel.php?action=modifier&id=<?php echo $logiciel->NoLogiciel; ?>'><span class="glyphicon glyphicon-pencil" style="color:orange"></span></a></td>
				<td><a href='logiciel_action.php?action=supprimer&id=<?php echo $logiciel->NoLogiciel; ?>' onclick ="return confirm('Etes-vous vraiment sûr ?');"><span class="glyphicon glyphicon-remove" style="color:red"></span></a></td>
				</tr>
				<?php 
				// lecture du logiciel suivant
				$logiciel = $resultat->fetch();
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