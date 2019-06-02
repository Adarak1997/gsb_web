<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link href="../css/navbar.css" rel="stylesheet">

    </head>
    <body style='background:#fff;'>

        <div style="margin-bottom:235px;" id="content">

             
            <!-- tester si l'utilisateur est connecté -->
    <table class="table">
        <thead class="thead">

        <tr>
          <th scope="col">mois</th>
          <th scope="col">année</th>
          <th scope="col">etat</th>
          <th scope="col">détails</th>
        </tr>

            <?php
                session_start();
                if(isset($_GET['deconnexion']))
                { 
                   if($_GET['deconnexion']==true)
                   {  
                      session_unset();
                      header("location:../index.php");
                   }
                }
                else if($_SESSION['pseudo'] !== "" && $_SESSION['mdp'] !== ""){
                    $user = $_SESSION['pseudo'];
                    
                   
                }

              include("../bdd.php");

              $query = $bdd ->query('select * from frais_forfait');
              $fraiss = $query -> fetchAll();



              $requete = $bdd->query('SELECT utilisateur.id, role.id as role_id, role.libelle as libel FROM `utilisateur` inner join role on utilisateur.role_id = role.id WHERE `pseudo` =\'' . $_SESSION['pseudo'] . '\'');

             
      while ($reponse = $requete->fetch()){
      
              $userId = $reponse['id'];

        if($reponse['role_id'] == 1){
        $reponse['role_id'] = "Visiteur";
        }
        if($reponse['role_id'] == 2){
        $reponse['role_id'] = "Comptable";
        }
        if($reponse['role_id'] == 3){
        $reponse['role_id'] = "Administrateur";
        }
      }
               
    ?> 

<div class="container-navbar">
        <ul>
          <li><img src="../image/logo-gsb.png" style="width:100px; height:auto; margin:5px 50px 5px 5px;"></li>
          <li><a href="compte_visiteur.php">Ma fiche du mois</a></li>
          <li><a href="listeFicheFrais.php" role="button">Mes fiches de frais</a></li>
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
            echo "Bonjour $user, vous êtes connecté en tant que visiteur.";
          }    
        ?>    
      </div>
              

<?php
$mois = date("m");
$annee = date("Y");
$lemois =['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

              $reponse= $bdd->query("SELECT fiche_frais.id, fiche_frais.mois, fiche_frais.annee, 
              fiche_frais.utilisateur_id as utilisateur_id, 
              etat.id as etat_id, etat.libelle as libelle 
              FROM fiche_frais 
              inner join etat on fiche_frais.etat_id = etat.id 
              WHERE (fiche_frais.mois != '".$mois."' OR fiche_frais.annee != '".$annee."') 
              AND utilisateur_id = '".$userId."' ORDER BY annee DESC, mois DESC");
              
                
             
                
                while($row = $reponse->fetch()){

                

                  echo "<tr><td>". $row["mois"]."</td><td>". $row["annee"]. "</td><td>". $row["libelle"]. "</td><td>". '<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" href="./details.php?id='.$row['id'].'">Détails de la fiche</a>'; "<td></tr>";

                }
                echo "</table>";             
            ?>

              </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
        </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>     

        <!-- Footer -->
        <footer>
          <div class="container text-center footer">
            <p style="padding-top:20px;">© 2019 - GALAXY SWISS BOURDIN</p>
          </div>
        </footer>
    </body>
</html>