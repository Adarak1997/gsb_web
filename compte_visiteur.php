<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />

    </head>
    <body style='background:#fff;'>

        <div id="content">

             
            <!-- tester si l'utilisateur est connecté -->


            <table>
        <tr>
          <th>mois</th>
          <th>année</th>
          <th>etat</th>
        </tr>

            <?php
                session_start();
                if(isset($_GET['deconnexion']))
                { 
                   if($_GET['deconnexion']==true)
                   {  
                      session_unset();
                      header("location:login.php");
                   }
                }
                else if($_SESSION['pseudo'] !== "" && $_SESSION['mdp'] !== ""){
                    $user = $_SESSION['pseudo'];
                    
                   
                }

              include("bdd.php");



              $requete = 'SELECT utilisateur.id, role.id as role_id, role.libelle as libel FROM `utilisateur` inner join role on utilisateur.role_id = role.id WHERE `pseudo` =\'' . $_SESSION['pseudo'] . '\'';

             $exec_requete = mysqli_query($db,$requete);
            $reponse = mysqli_fetch_array($exec_requete);
      
      
              $userId = $reponse['id'];
      
               
    ?> 

    <div class="headbox animated fadeInLeft delay-1s" style="background: rgba(240,240,240,1.00);height: 100%; background-color: red;"><a href="#menu-toggle" class="btn btn-secondary" id="menu-toggle"><i id="bar" class="fa fa-times-circle" aria-hidden="true"></i></a> <a href="compte_visiteur.php?deconnexion=true."><button style="background-color: red" class="deco2"><i class="fa fa-power-off"></i> Déconnexion</button></a> <p1  class="compte">(<?php echo $reponse['libel']?>) <?php echo $_SESSION['pseudo'] ?></p1>  <a href="#btnnotif" id="btnnotif" class="notif"><i id="notif" class="fa fa-envelope-open"></i></a></div>

              

<?php
              $sql= "SELECT fiche_frais.id, fiche_frais.mois, fiche_frais.annee, fiche_frais.utilisateur_id as utilisateur_id, etat.id as etat_id, etat.libelle as libelle FROM fiche_frais inner join etat on fiche_frais.etat_id = etat.id WHERE utilisateur_id = '".$userId."' ORDER BY annee DESC, mois DESC";
              $result = $db ->query($sql);
              
              if ($result -> num_rows > 0)
              {
                while ($row = $result-> fetch_assoc())
                {

                  echo "<tr><td>". $row["mois"]."</td><td>". $row["annee"]. "</td><td>". $row["libelle"]. "<td></tr>";
                }
                echo "</table>";
              }
              else {
                echo "0 result";
              }
              $db->close();
            ?>
         </table>  
        </div>
    </body>
</html>