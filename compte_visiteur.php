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
          <th>détails</th>
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

    <div class="headbox animated fadeInLeft delay-1s" style="background: rgba(240,240,240,1.00);height: 100%; background-color: red;"><a href="#menu-toggle" class="btn btn-secondary" id="menu-toggle"><i id="bar" class="fa fa-times-circle" aria-hidden="true"></i></a> <a href="compte_visiteur.php?deconnexion=true."><button style="background-color: red" class="deco2"><i class="fa fa-power-off"></i> Déconnexion</button></a> <p1  class="compte">(<?php echo $reponse['libel']?>) <?php echo $_SESSION['pseudo'] ?></p1>  <a href="#btnnotif" id="btnnotif" class="notif"><i id="notif" class="fa fa-envelope-open"></i></a></div>

              

<?php
              $sql= $bdd->query("SELECT fiche_frais.id, fiche_frais.mois, fiche_frais.annee, fiche_frais.utilisateur_id as utilisateur_id, etat.id as etat_id, etat.libelle as libelle FROM fiche_frais inner join etat on fiche_frais.etat_id = etat.id WHERE utilisateur_id = '".$userId."' ORDER BY annee DESC, mois DESC");
              $reponse = $sql ->fetch();
              
              if ($reponse > 0)
              {
                
                

                  echo "<tr><td>". $reponse["mois"]."</td><td>". $reponse["annee"]. "</td><td>". $reponse["libelle"]. "</td><td>". '<button id="showpopup" value="d">Afficher form</button>'; "<td></tr>";

                
                echo "</table>";

              }
              else {
                echo "0 result";
              }
              
            ?>

         </table>  
        </div>



        <div style="background: rgba(212,212,212,0.20);box-shadow: 0px 0px 8px 0px rgba(0,0,0,0.15);">
          <h2>Déclarer un frai forfaitisé</h2>
          <p>crée une demande de remboursement <br>envoyer au service comptable</p>
          <form method="post" style="padding: 0px 0 10px 0px;" action="index.php">
            <SELECT id="liste" style="min-width: 220px;" class="role" name="frais" size="1" onChange="fix()">
              <option class="rolesub">Liste de frais</option>
              <OPTION class="rolesub" value="Hotel">Hotel
              <OPTION class="rolesub" value="Restauration">Restauration
              <OPTION class="rolesub" value="Transport">Transport
            </SELECT><br>
            <div id="petrol" class="novue animated fadeIn">
            <SELECT class="role" style="min-width: 220px;margin-top: 15px;    padding: 5px 40px;" name="petrol" id="liste2" size="1" onChange="gaz()">
                <option class="rolesub" selected>Liste des choix
                <OPTION class="rolesub" value="essence">essence
                <OPTION class="rolesub" value="diesel">diesel
              </SELECT><br>
              
            </div>
      </div>
    </body>
</html>