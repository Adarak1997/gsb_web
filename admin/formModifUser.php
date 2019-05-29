<?php
session_start();
include ('../bdd.php');

/*$queryRole = $bdd ->query('select * from role');
$roles = $queryRole -> fetchAll();*/
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Modifier utilisateur</title>
		<link rel="stylesheet" type="text/css" media="screen" href="../css/style.css" />
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<link href="../css/navbar.css" rel="stylesheet">
	</head>
	<body>

 <!-- Navbar -->
 <div class="container-navbar">
        <ul>
          <li><img src="../image/logo-gsb.png" style="width:100px; height:auto; margin:5px 50px 5px 5px;"></li>
          <li><a href="listeUtilisateur.php">Liste des utilisateurs</a></li>
          <li><a href="ajoutUtilisateur.php" role="button">Ajouter nouvel utilisateur</a></li>
          <li></li>
          <li style="float:right"><a href='../index.php?deconnexion=true'><span>Déconnexion</span></a></li>
        </ul>
      </div>

      <!--Teste si l'utilisateur est connecté et affiche ses informations -->
      <div style="background-color:#66A3D3; font-size: 1.1em; margin-bottom:20px;">
        <?php
          if(isset($_GET['deconnexion'])) { 
            if($_GET['deconnexion']==true) {  
              session_unset();
              header("location:../index.php");
            }
          }
          else if($_SESSION['pseudo'] !== ""){
            $user = $_SESSION['pseudo'];
            // afficher un message
            echo "Bonjour $user, vous êtes connecté en tant qu'administrateur.";
          }    
        ?>    
      </div>

		<?php
		//recupération de tous les id des utilisateurs
		$reponse = $bdd->query('SELECT *
								FROM `utilisateur` 
								WHERE `id` =\'' . $_GET['id'] . '\'');	
		while ($donnees = $reponse->fetch()){
			
			?>
				<section  class="container formulaire">
					<center><h1 style="margin-bottom:20px;">Modifier l'utilisateur <?php echo $donnees["pseudo"] ?></h1></center>
					<form action="../fonction/modifUser.php" method="POST">
						<div class="form-group">
							<label>Nom</label>
							<input type="text" class="form-control" name="nom" value="<?php echo $donnees["nom"]?>">
						</div>		
						<div class="form-group">
							<label>Prenom</label>
							<input type="text" class="form-control" name="prenom" value="<?php echo $donnees["prenom"]?>">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="text" class="form-control" name="email" value="<?php echo $donnees["email"]?>">
						</div>
						<div class="form-group">
							<label>Téléphone</label>
							<input type="text" class="form-control" name="tel" value="<?php echo $donnees["tel"]?>">
						</div>
						<div class="form-group">
							<label>Date de naissance</label>
							<input type="text" class="form-control" name="date_naissance" value="<?php echo $donnees["date_naissance"]?>">
						</div>
						<div class="form-group">
							<label>Adresse</label>
							<input type="text" class="form-control" name="adresse" value="<?php echo $donnees["adresse"]?>">
						</div>
						<div class="form-group">
							<label>Ville</label>
							<input type="text" class="form-control" name="ville" value="<?php echo $donnees["ville"]?>">
						</div>
						<div class="form-group">
							<label>Code Postal</label>
							<input type="text" class="form-control" name="code_postal" value="<?php echo $donnees["code_postal"]?>">
						</div>
						<div class="form-group">
							<label>Date d'embauche</label>
							<input type="text" class="form-control" name="date_embauche" value="<?php echo $donnees["date_embauche"]?>">
						</div>
						<div class="form-group">
							<label>Pseudo</label>
							<input type="text" class="form-control" name="pseudo" value="<?php echo $donnees["pseudo"]?>">
						</div>
						<input class="btn btn-primary btnModif" type="submit" value="Valider"/>
					</form>
				</div>
		<?php
		//fermeture du while
			}
		?>
	</body>
</html>
