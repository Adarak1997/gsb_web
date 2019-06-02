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
        <link href="../css/card.css" rel="stylesheet">

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
        $tel = $bdd->query("SELECT tel, prenom, nom, email, adresse FROM utilisateur WHERE id = '".$_GET['iduser']."'");
        $affichage = $tel->fetch();
        ?>     
      
      <section class="container">
          <div class="row">
            <div class="col-lg-5">
              <div class="card">
                <div class="card-header">
                <center><h1 ><?php echo $affichage['prenom']," ", $affichage['nom'] ?></h1></center>
                </div>
                <div class="card-body">
                  <p>
                    Téléphone :<?php echo $affichage['tel']?><br>
                    Email: <?php echo $affichage['email']?><br>
                    Adresse: <?php echo $affichage['adresse']?><br>
                  </p>
                </div> 
              </div>
            </div>
          </div>
      </section>

        <br><br>
        <center><h2>Frais forfaitisés</h2></center>
        <div class="tableau">
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
        </div>

        <br><br>
        <center><h2>Frais non-forfaitisés</h2></center>
            <div class="tableau">
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
                                    <td>"."<a class='btn btn-success' href=\"../fonction/valideDetails.php?id=".$row['id']."\">Valider</a>
                                    <a class='btn btn-danger' href=\"../fonction/refuseDetails.php?id=".$row['id']."\">Refusé</a></td>
                                </tr>";
                        }
                        ?>
                </table>
            </div>
              <input class="btn btn-primary" type="button" value="Retour" style="margin-left:50px;" onclick="history.go(-1)">
            </div>

          </div>
        </div>
      </div>

        <!-- Footer -->
        <footer class="footer2">
          <div class="container text-center">
              <div class="row">
                  <div class="col-md-12">
                    <p style="padding-top:20px;">© 2019 - GALAXY SWISS BOURDIN</p>
                  </div>
              </div>
          </div>
      </footer>  

      <script src="../js/boostrap.min.js"></script>               
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    </body>
</html>