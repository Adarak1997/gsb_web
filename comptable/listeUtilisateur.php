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
            echo "Bonjour $user, vous êtes connecté en tant que comptable.";
          }    
        ?>    
      </div>

        <table style="margin-bottom:38px;" class="table">
            <thead class="thead">
                <tr>
                    <th scope="col">Pseudo</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Téléphone</th>
                    <th scope="col">Ville</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">Code Postal</th>
                </tr>
            </thead>
            <?php

            // Récupération des données de la table utilisateur
            $reponse = $bdd ->query('SELECT * FROM utilisateur');
            
            //Boucle pour Parcourir tous les champs de la table utilisateur
            while($donnees = $reponse -> fetch())
            {
                echo "<tr>".
                        "<td>" .$donnees['pseudo']. "</td>".
                        "<td>" .$donnees['nom']. "</td>".
                        "<td>" .$donnees['prenom']. "</td>".                      
                        "<td>" .$donnees['email']. "</td>".
                        "<td>" .$donnees['tel']. "</td>".
                        "<td>" .$donnees['ville']. "</td>".
                        "<td>" .$donnees['adresse']. "</td>".
                        "<td>" .$donnees['code_postal']. "</td>".
                        "<td><a class='btn btn-primary' href=\"listeFrais.php?id=".$donnees['id']."\">Voir fiches frais</a></td>".
                    "</tr>";        
            }

            //Termine le traitement de la requête
            $reponse->closeCursor();
            ?>

            <!-- Button trigger modal -->

        </table>

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