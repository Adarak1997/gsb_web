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
    </head>
    <body style='background:#fff;'>
        <div id="content">
            <!-- tester si l'utilisateur est connecté -->
            <a href='compte_visiteur.php?deconnexion=true'><span>Déconnexion</span></a>
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
                    echo "Bonjour $user, vous êtes connecté en tant que comptable";
                }
            ?>            
        </div>

        <table class="table">
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
                        "<td>" .$donnees['nom']. "</td>".
                        "<td>" .$donnees['prenom']. "</td>".
                        "<td>" .$donnees['pseudo']. "</td>".
                        "<td>" .$donnees['email']. "</td>".
                        "<td>" .$donnees['tel']. "</td>".
                        "<td>" .$donnees['ville']. "</td>".
                        "<td>" .$donnees['adresse']. "</td>".
                        "<td>" .$donnees['code_postal']. "</td>".
                        "<td><a class='btn btn-primary' href=\"listeFrais.php?id=".$donnees['id']."\">Voir fiches frais</a></td>".
                    "</tr>";        
            }

            //Termine le traitement de la requête
            $reponse->closeCursor();0
            ?>

            <!-- Button trigger modal -->

        </table>      
    </body>
</html>