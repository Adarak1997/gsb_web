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

        <?php

            $sql = $bdd->query("SELECT mois, annee, id FROM fiche_frais");
            $sql2 = $sql->fetch();
      
            $id_fichefrais = $sql2['id'];

           
            $sql2=$bdd->query("SELECT details_frais_forfait.id, details_frais_forfait.quantite as quantite, 
                                frais_forfait.id as frais_forfait_id, 
                                frais_forfait.libelle as libelle, 
                                frais_forfait.montant as montant, 
                                details_frais_forfait.fiche_frais_id as fiche_frais_id, 
                                etat.id as etat_id, 
                                etat.libelle as libel 
                                FROM details_frais_forfait inner join frais_forfait 
                                on details_frais_forfait.frais_forfait_id = frais_forfait.id 
                                inner join etat on details_frais_forfait.etat_id = etat.id 
                                WHERE fiche_frais_id = '".$id_fichefrais."'");
               
               while($row = $sql2->fetch()){

                echo $row['libelle'],
                 $row['montant'],
                 $row['quantite'];
            }


        ?>

        <div class="super_container">
            <div class="container">
                <div class="jumbotron">
                <h1 class="display-4">Hello, world!</h1>
                <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
                <hr class="my-4">
                <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
                <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
                </div>
            </div>
        </div>
    </body>
</html>