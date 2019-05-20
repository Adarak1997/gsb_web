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
                echo "Bonjour $user, vous êtes connecté en tant que comptable";
            }
            ?>
    </div>
    <div>
        <table class="table">
            <tr class="thead">
                <th scope="col">Mois</th>
                <th scope="col">Année</th>
                <th scope="col">État</th>
            </tr>
    <?php
    //recupération de tous les id des utilisateurs
		$reponse = $bdd->query('SELECT fiche_frais.id as fiche_id, fiche_frais.mois, fiche_frais.annee, fiche_frais.utilisateur_id 
                                as utilisateur_id, etat.id as etat_id, etat.libelle as libelle
								FROM `fiche_frais` inner join etat on fiche_frais.etat_id = etat.id
								WHERE `utilisateur_id` =\'' . $_GET['id'] . '\'');	

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
        </div>
    </body>
</html>