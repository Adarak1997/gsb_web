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
	</head>
	<body>

	<div id="content">
        <!-- tester si l'utilisateur est connecté -->
        <a href='../index.php?deconnexion=true'><span>Déconnexion</span></a>
        <?php
            if(isset($_GET['deconnexion']))
            { 
                if($_GET['deconnexion']==true)
                {  
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
				<div class="formulaire">
					<form method="POST">
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
