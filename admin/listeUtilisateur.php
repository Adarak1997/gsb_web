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
    <link rel="stylesheet" type="text/css" media="screen" href="../css/style.css" />
    <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>

    <body>

        <table class="table">
            <thead class="thead">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Rôle</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Date de naissance</th>
                    <th scope="col">E-mail</th>
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
        <a class="btn btn-primary" href="ajoutUtilisateur.php" role="button">Retour inscription</a>
    </body>
</html>