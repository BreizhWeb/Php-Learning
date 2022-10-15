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
				$req_pre = $cnx->prepare("SELECT * FROM Stage WHERE NoStage = :id");
				// liaison de la variable à la requête préparée
				$req_pre->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
				$req_pre->execute();
				//le résultat est récupéré sous forme d'objet
				$stage=$req_pre->fetch(PDO::FETCH_OBJ);
				?>

				<h2>Stage</h2>
				<p>Sur cette page, vous pouvez modifier un stage existant.

				<form method="post" action="stage_action.php?action=modifier">
				<!-- numéro du stage sélectionné caché -->
				<input type="hidden" name="numero" value="<?php echo $stage->NoStage; ?>" />
				<table>
					<tr>
						<td>Sujet :</td>
						<td><input type='text' name='sujet' value='<?php echo utf8_encode($stage->Sujet); ?>'/></td>
					</tr>
					
					<tr>
						<td>Date début :</td>
						<td><input type='date' name='datDeb' value='<?php echo $stage->DateDebut; ?>'/></td>
					</tr>

					<tr>
						<td>Date fin :</td>
						<td><input type='date' name='datFin' value='<?php echo $stage->DateFin; ?>'/></td>
					</tr>
					
					<tr>
						<td>Niveau :</td>
						<td>
	   					<?php
						include("include/_inc_parametres.php"); 
						include("include/_inc_connexion.php");
						
						//	on récupère toutes les lignes de la table Niveau
						$resultat = $cnx->query("select * FROM Niveau ORDER BY CodeNiveau ;");
						//le résultat est récupéré sous forme d'objet
						$resultat->setFetchMode(PDO::FETCH_OBJ);
					
						$Chaine = "";
						$Select='<select size="1" name="niveau">';
						// tant qu'il y a des niveaux
						while ($ligne = $resultat->fetch() )	{
							$Chaine = $Chaine."<option value=".$ligne->CodeNiveau.">".utf8_encode($ligne->CodeNiveau)."</option>";
						}
						echo $Select.$Chaine.'</select></br>';
						?>
       					</td>
					</tr>
						
					<tr>
						<td>Logiciel :</td>
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
						<td>Formateur :</td>
						<td>
							<?php
								include("include/_inc_parametres.php"); 
								include("include/_inc_connexion.php");
								
								//	on récupère toutes les lignes de la table Logiciel
								$resultat = $cnx->query("select * FROM formateur ;");
								//le résultat est récupéré sous forme d'objet
								$resultat->setFetchMode(PDO::FETCH_OBJ);
								
								$Chaine = "";
								$Select='<select size="1" name="formateur">';
								// tant qu'il y a des lignes
								while ($ligne = $resultat->fetch() )	{
									$Chaine = $Chaine."<option value=".$ligne->NoFormateur.">".utf8_encode($ligne->NoFormateur)."</option>";
								}
					
								echo $Select.$Chaine.'</select>';
							?>  
						</td>
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
				<h2>stage</h2>
				<p>Sur cette page, vous pouvez ajouter un stage.

				<form method="post" action="stage_action.php?action=ajouter" enctype="multipart/form-data" >
				<input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>" />
				<table class="table table-striped">
					<tr>
						<td>Sujet :</td>
						<td><input type='text' name='sujet' size="30" required></td>
					</tr>
					<tr>
    				  	<td>Date début :</td>
						<td><input type='date' name='datDeb' required ></td>
					</tr>
    				<tr>
    					<td>Date fin :</td>
 						<td><input type='date' name='datFin' required></td></br>
					</tr>

    				<tr>
        				<td>Niveau :</td>
        				<td>
	   					<?php
						include("include/_inc_parametres.php"); 
						include("include/_inc_connexion.php");
						
						//	on récupère toutes les lignes de la table Niveau
						$resultat = $cnx->query("select * FROM Niveau ORDER BY CodeNiveau ;");
						//le résultat est récupéré sous forme d'objet
						$resultat->setFetchMode(PDO::FETCH_OBJ);
					
						$Chaine = "";
						$Select='<select size="1" name="niveau">';
						// tant qu'il y a des niveaux
						while ($ligne = $resultat->fetch() )	{
							$Chaine = $Chaine."<option value=".$ligne->CodeNiveau.">".utf8_encode($ligne->LibelleNiveau)."</option>";
						}
						echo $Select.$Chaine.'</select></br>';
						?>
       					</td>
     				</tr>

  					<tr>
   					    <td>Logiciel :</td>
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
							$Chaine = $Chaine."<option value=".$ligne->NoLogiciel.">".utf8_encode($ligne->NomLogiciel)."</option>";
						}
			
						echo $Select.$Chaine.'</select>';
						?>  
     					</td>
     				</tr>

					<tr>
						<td>Formateur :</td>
						<td>
							<?php
								include("include/_inc_parametres.php"); 
								include("include/_inc_connexion.php");
								
								//	on récupère toutes les lignes de la table Logiciel
								$resultat = $cnx->query("select * FROM formateur ;");
								//le résultat est récupéré sous forme d'objet
								$resultat->setFetchMode(PDO::FETCH_OBJ);
								
								$Chaine = "";
								$Select='<select size="1" name="formateur">';
								// tant qu'il y a des lignes
								while ($ligne = $resultat->fetch() )	{
									$Chaine = $Chaine."<option value=".$ligne->NoFormateur.">".utf8_encode($ligne->NomFormateur)."</option>";
								}
					
								echo $Select.$Chaine.'</select>';
							?>  
						</td>
					</tr>
			
					<tr>
						<!-- zone de saisie de type file permettant la sélection d'une photo stockée sur le poste client  -->
						<td>Photo à télécharger (facultative):</td>
						<td><input type = "file" name ="logo" size="40"></td>
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
			$resultat = $cnx->query("select * FROM DetailStages ");
			//le résultat est récupéré sous forme d'objet
			$resultat->setFetchMode(PDO::FETCH_OBJ);
			
			?>
			<h2>Stage</h2>
			<p>A partir de cette page, vous pouvez ajouter, modifier ou supprimer des stages.
			<a href="stage.php?action=nouveau">Ajouter un stage</a> </p>
		
			<table class="table table-striped">
			<thead><tr class="success">
				<td>Sujet</td>
				<td>Date début</td>
				<td>Date fin</td>
				<td>Logiciel</td>
				<td>Niveau</td>
				<td>Modifier</td>
				<td>Supprimer</td>
			</tr></thead>

			<?php 
			$stage = $resultat->fetch();
			while ($stage) { ?>
				<tr>
				<td><?php echo utf8_encode($stage->Sujet); ?></td>
				<td><?php echo $stage->DateDebut; ?></td>
				<td><?php echo $stage->DateFin; ?></td>
				<td><?php echo utf8_encode($stage->NomLogiciel); ?></td>
				<td><?php echo utf8_encode($stage->LibelleNiveau); ?></td>
				<td><a href= 'stage.php?action=modifier&id=<?php echo $stage->NoStage; ?>'><span class="glyphicon glyphicon-pencil" style="color:orange"></span></a></td>
				<td><a href='stage_action.php?action=supprimer&id=<?php echo $stage->NoStage; ?>' onclick ="return.windows.confirm('Etes-vous vraiment sûr ?');"><span class="glyphicon glyphicon-remove" style="color:red"></span></a></td>
				</tr>
				<?php 
				// lecture du stage suivant
				$stage = $resultat->fetch();
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