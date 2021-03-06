<?php
session_start();
include ('../bdd.php');

$query = $bdd ->query('select * from role');
$roles = $query -> fetchAll();
?>

<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8" />
            <title>Ajout d'utilisateur</title>
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
	
		$reponse = $bdd->query('SELECT role_id, id 
        FROM `utilisateur` 
        WHERE `id` =\'' . $_SESSION['pseudo'] . '\'');
		while ($donnees = $reponse->fetch()){
			
			
			$userId = $donnees['id_user'];
			
			 if($donnees['role_id'] == 1){
				$donnees['role_id'] = "Visiteur";
			}
			elseif($donnees['role_id'] == 2){
				$donnees['role_id'] = "Comptable";
			}else{
                $donnees['role_id'] = "Administrateur";
            }
        }
	  ?>
        <section class="container formulaire">
            <center><h1 style="margin-bottom: 20px;">Inscription utilisateur</h1></center>
            <form action="../fonction/newUser.php" method="POST">
                <div class="form-group">
                    <label>Rôle</label>
                    <select name="role" class="form-control">
                        <option selected>Rôle...</option>
                        <?php  foreach ($roles as $role) { ?>
                            <option value="<?php echo $role['id']; ?>"><?php echo $role['libelle']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="labelForm">Nom</label>
                    <input type="text"  name="nom" class="form-control" placeholder="Entrez votre nom..." required>
                </div>

                <div class="form-group">
                    <label for="labelForm">Prénom</label>
                    <input type="text" name="prenom" class="form-control" placeholder="Entrez votre prénom..." required>
                </div>

                <div class="form-group">
                    <label for="labelForm">Date de naissance</label>
                    <input type="date" name="date_naissance" class="form-control" placeholder="jj/mm/aaaa" required>
                </div>

                <div class="form-group">
                    <label for="labelForm">E-mail</label>
                    <input type="text" name="email" class="form-control" placeholder="Entrez votre E-mail..." required>
                </div>

                <div class="form-group">
                    <label for="labelForm">Téléphone</label>
                    <input type="text" name="tel" class="form-control" placeholder="Entrez votre numéro de téléphone..." required>
                </div>      

                
                <div class="form-group">
                    <label for="labelForm">Ville</label>
                    <input type="text" name="ville" class="form-control" placeholder="Entrez ville..." required>
                </div>
                
                <div class="form-group">
                    <label for="labelForm">Adresse</label>
                    <input type="text" name="adresse" class="form-control" placeholder="Entrez adresse..." required>
                </div>
                
                <div class="form-group">
                    <label for="labelForm">Code postal</label>
                    <input type="text" name="code_postal" class="form-control" placeholder="Entrez code postal..." required>
                </div>
                
                <div class="form-group">
                    <label for="labelForm">Date d'embauche</label>
                    <input type="date" name="date_embauche" class="form-control" placeholder="jj/mm/aaaa" required>
                </div>

                <div class="form-group">
                    <label for="labelForm">Pseudo</label>
                    <input type="text" name="pseudo" class="form-control" placeholder="Entrez pseudo..." required>
                </div>
                

                <div class="form-group">
                    <label for="labelForm">Mot de passe</label>
                    <input type="password" name="mdp" class="form-control" placeholder="Entrez votre mot de passe..." required>
                </div>
                
                <input class="btn btn-primary btnAjout" type="submit" value="Valider"/><br>
            </form>
        </section>

      <!-- Footer -->
        <footer>
            <div class="container text-center footer2">
                <p  style="padding-top:20px;">© 2019 - GALAXY SWISS BOURDIN</p>
            </div>
        </footer>

    </body>
</html> 
