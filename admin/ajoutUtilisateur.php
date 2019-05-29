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
        </head>
    <body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>

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
            <h1>Inscription utilisateur</h1>
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
                    <label for="labelForm">Mot de passe</label>
                    <input type="password" name="mdp" class="form-control" placeholder="Entrez votre mot de passe..." required>
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
                    <label for="labelForm">Pseudo</label>
                    <input type="text" name="pseudo" class="form-control" placeholder="Entrez pseudo..." required>
                </div>

                <div class="form-group">
                    <label for="labelForm">Date d'embauche</label>
                    <input type="date" name="date_embauche" class="form-control" placeholder="jj/mm/aaaa" required>
                </div>
                <input class="btn btn-primary btnAjout" type="submit" value="Valider"/><br>
            </form>
                <a href="listeUtilisateur.php">Accéder à la liste des utilisateurs</a>
        </section>
    </body>
</html> 
