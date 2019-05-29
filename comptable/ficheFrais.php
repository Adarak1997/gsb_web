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

        <br><br>
        <h2>Frais frofaitisés</h2>
        <table class="table">
            <thead class="thead">
                <tr>
                    <th scope="col">Libelle</th>
                    <th scope="col">Montant</th>
                    <th scope="col">Quantité</th>
                    <th scope="col">Montant Total</th>
                </tr>
        <?php
            $reponse=$bdd->query('SELECT details_frais_forfait.id, details_frais_forfait.quantite as quantite,
             frais_forfait.id as frais_forfait_id, 
             frais_forfait.libelle as libelle, 
             frais_forfait.montant as montant, 
             details_frais_forfait.fiche_frais_id as fiche_frais_id,
             etat.id as etat_id, etat.libelle as libelle_etat 
             FROM details_frais_forfait 
             inner join frais_forfait 
             on details_frais_forfait.frais_forfait_id = frais_forfait.id 
             inner join etat on details_frais_forfait.etat_id = etat.id 
             WHERE fiche_frais_id = \'' . $_GET['id'] . '\'');
               
             while($row = $reponse->fetch()){

                  echo "<tr>
                            <td>". $row["libelle"]."</td>
                            <td>". $row["montant"]."</td>
                            <td>". $row["quantite"]. "</td>
                            <td>". $row["montant"]*$row["quantite"]. "</td>
                        </tr>";
                }
                echo "</table>";
        ?>

        <br><br>
        <h2>Frais non-frofaitisés</h2>
                <table class="table">
                    <thead class="thead">
                        <tr>
                            <th scope="col">Libelle</th>
                            <th scope="col">Montant</th>
                            <th scope="col">Etat</th>
                        </tr>
                <?php
                    $reponse=$bdd->query('SELECT details_frais_non_forfait.id,
                    details_frais_non_forfait.fiche_frais_id as fiche_frais_id,
                    details_frais_non_forfait.libelle as libelle,
                    details_frais_non_forfait.montant as montant,
                    etat.id as etat_id, 
                    etat.libelle as libelle_etat 
                    FROM details_frais_non_forfait 
                    inner join etat on details_frais_non_forfait.etat_id = etat.id 
                    WHERE fiche_frais_id = \'' . $_GET['id'] . '\'');
                    
                    while($row = $reponse->fetch()){

                        echo "<tr>
                                    <td>". $row["libelle"]."</td>
                                    <td>". $row["montant"]."</td>
                                    <td>". $row["libelle_etat"]."<td>
                                    <td><a class='btn btn-primary' href=\"formModifUser.php?id=".$row['id']."\">Modifier</a>
                                    <a class='btn btn-danger' href=\"../fonction/deleteLigneFraisHorsForfait.php?id=".$row['id']."\">Supprimer</a></td>
                                </tr>";
                        }
                        echo "</table>";
                ?>

    </body>
</html>