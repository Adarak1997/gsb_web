<?php
session_start();
    //Récupère le fichier bdd
    include ('../bdd.php');
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/navbar.css" rel="stylesheet">
        <link href="../css/tableau.css" rel="stylesheet">

    </head>
    <body style='background:#fff;'>
        <!-- Navbar -->
        <div class="container-navbar">
        <ul>
          <li><img src="../image/logo-gsb.png" style="width:100px; height:auto; margin:5px 50px 5px 5px;"></li>
          <li><a href="listeUtilisateur.php">Liste des utilisateurs</a></li>
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
		$reponse = $bdd->query('SELECT fiche_frais.id as fiche_id, fiche_frais.mois, fiche_frais.annee, fiche_frais.utilisateur_id 
                                as utilisateur_id, utilisateur.pseudo as pseudo, etat.id as etat_id, etat.libelle as libelle
								                FROM `fiche_frais` inner join etat on fiche_frais.etat_id = etat.id 
                                inner join utilisateur on fiche_frais.utilisateur_id = utilisateur.id
                                WHERE `utilisateur_id` =\'' . $_GET['id'] . '\'');
        $utilisateur = $reponse ->fetch();
    ?>	
    <div class="tableau">
        <center><h1>Liste des frais de <?php echo $utilisateur['pseudo']?></h1></center>
        <table class="table">
            <tr class="thead">
                <th scope="col">Mois</th>
                <th scope="col">Année</th>
                <th scope="col">État</th>
            </tr>
    
<?php
while($donnees = $reponse -> fetch())   
{
    echo "<tr>".
            "<td>" .$donnees['mois']. "</td>".
            "<td>" .$donnees['annee']. "</td>".
            "<td>" .$donnees['libelle']. "</td>".
            "<td><a class='btn btn-primary' href=\"ficheFrais.php?id=".$donnees['fiche_id']."\">Détails</a></td>".
        "</tr>";        
}

        //Termine le traitement de la requête
        $reponse->closeCursor();
    ?>
            </table>  
            <input class="btn btn-primary" type="button" value="Retour" style="margin-left:50px;" onclick="history.go(-1)">
        </div>

        <!-- Footer -->
        <footer class="footer">
          <div class="container text-center">
              <div class="row">
                  <div class="col-md-12">
                    <p style="padding-top:20px;">© 2019 - GALAXY SWISS BOURDIN</p>
                  </div>
              </div>
          </div>
      </footer>  
    </body>
</html>