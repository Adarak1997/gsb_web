<?php
session_start();
    //Récupère le fichier bdd
    include ('../bdd.php');
    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Liste des utilisateurs</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/navbar.css" rel="stylesheet">
    <link href="../css/tableau.css" rel="stylesheet">
    
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

      <div class="tableau">
        <center><h1>Liste des utilisateurs</h1></center>       
        <table class="table">
            <thead class="thead">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Rôle</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Date de naissance</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Téléphone</th>
                    <th scope="col">Ville</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">Code Postal</th>
                    <th scope="col">Pseudo</th>
                    <th scope="col">Date d'embauche</th>
                </tr>
            </thead>
<?php

    // Récupération des données de la table utilisateur
    $reponse = $bdd ->query('SELECT * FROM utilisateur');
    
    //Boucle pour Parcourir tous les champs de la table utilisateur
    while($donnees = $reponse -> fetch())
    {
        echo "<tr>".
                "<td>" .$donnees['id']. "</td>".
                "<td>" .$donnees['role_id']. "</td>".
                "<td>" .$donnees['nom']. "</td>".
                "<td>" .$donnees['prenom']. "</td>".
                "<td>" .$donnees['date_naissance']. "</td>".
                "<td>" .$donnees['email']. "</td>".
                "<td>" .$donnees['tel']. "</td>".
                "<td>" .$donnees['ville']. "</td>".
                "<td>" .$donnees['adresse']. "</td>".
                "<td>" .$donnees['code_postal']. "</td>".
                "<td>" .$donnees['pseudo']. "</td>".
                "<td>" .$donnees['date_embauche']. "</td>".
                "<td><a class='btn btn-primary' href=\"formModifUser.php?id=".$donnees['id']."\">Modifier</a></td>".
                "<td><a class='btn btn-danger' href=\"../fonction/deleteUser.php?id=".$donnees['id']."\">Supprimer</a></td>".
            "</tr>";        
    }

    //Termine le traitement de la requête
    $reponse->closeCursor();
?>
        </table>
      </div>

        <script src="js/bootstrap.min.js"></script>
    </body>
</html>