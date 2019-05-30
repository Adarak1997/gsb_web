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
		//recupération des informations selon l'id de l'utilisateur se trouvant dans l'url
		$reponse = $bdd->query('SELECT *
								FROM `utilisateur` 
								WHERE `id` =\'' . $_GET['id'] . '\'');	
		$donnees = $reponse->fetch()
			
			?>
				<section  class="container formulaire">
					<center><h1 style="margin-bottom:20px;">Modifier l'utilisateur <?php echo $donnees["pseudo"] ?></h1></center>
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
			if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['tel'])
					&& isset($_POST['date_naissance']) && isset($_POST['adresse']) && isset($_POST['ville']) 
					&& isset($_POST['code_postal']) && isset($_POST['date_embauche']) && isset($_POST['pseudo'])){

					$nom = $_POST['nom'];
					$prenom = $_POST['prenom'];
					$email = $_POST['email'];
					$tel = $_POST['tel'];
					$date_naissance = $_POST['date_naissance'];
					$adresse = $_POST['adresse'];
					$ville = $_POST['ville'];
					$code_postal = $_POST['code_postal'];
					$date_embauche = $_POST['date_embauche'];
					$pseudo = $_POST['pseudo'];


					$requete = $bdd->prepare("UPDATE utilisateur
						  SET nom = :nom,
							  prenom = :prenom,
							  email = :email,
								tel = :tel,
							  date_naissance = :date_naissance,
							  adresse = :adresse,
							  ville = :ville,
							  code_postal = :code_postal,
							  date_embauche = :date_embauche,
							  pseudo = :pseudo
						  WHERE id = :id ");

					$requete->bindparam(':nom',$nom);
					$requete->bindparam(':prenom',$prenom);
					$requete->bindparam(':email',$email);
					$requete->bindparam(':tel',$tel);
					$requete->bindparam(':date_naissance',$date_naissance);
					$requete->bindparam(':adresse',$adresse);
					$requete->bindparam(':ville',$ville);
					$requete->bindparam(':code_postal',$code_postal);
					$requete->bindparam(':date_embauche',$date_embauche);
					$requete->bindparam(':pseudo',$pseudo);
					$requete->bindparam(':id',$_GET['id']);

					$requete->execute();

					header('Location: listeUtilisateur.php');
			}
		?>
	</body>
</html>
