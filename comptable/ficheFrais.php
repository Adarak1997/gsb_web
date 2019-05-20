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
            $reponse = $bdd->query('SELECT details_frais_forfait.id,
                                    details_frais_forfait.quantite as quantite, 
                                    fiche_frais.id as fiche_id,
                                    frais_forfait.libelle as libelleFF, 
                                    frais_forfait.id as frais_forfait_id,
                                    frais_forfait.montant as montant, 
                                    FROM fiche_frais 
                                    inner join frais_forfait on details_frais_forfait.frais_forfait_id = frais_forfait.id   
                                    WHERE fiche_frais_id =\'' . $_GET['id'] . '\'');

            while($frais = $reponse -> fetch()) {
                echo $frais['quantite'];
                echo $frais['libelleFF'];
                echo $frais['montant'];
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