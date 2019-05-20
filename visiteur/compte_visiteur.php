<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    </head>
    <body style='background:#fff;'>

        <div id="content">

             
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
              $reponse= $bdd->query("SELECT fiche_frais.id, fiche_frais.mois, fiche_frais.annee, fiche_frais.utilisateur_id as utilisateur_id, etat.id as etat_id, etat.libelle as libelle FROM fiche_frais inner join etat on fiche_frais.etat_id = etat.id WHERE utilisateur_id = '".$userId."' ORDER BY annee DESC, mois DESC");
              
                
             
                
                while($row = $reponse->fetch()){

                $id_fiche_frais = $row['id'];

                  echo "<tr><td>". $row["mois"]."</td><td>". $row["annee"]. "</td><td>". $row["libelle"]. "</td><td>". '<a type="button" class="btn btn-primary" data-toggle="modal" href="./details.php?=.$row["id"].">Détails de la fiche</a>'; "<td></tr>";

                }
                echo "</table>";




              
              
            ?>
           <!--  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
</div> -->


            <thead>
         </table>  

        </div>

       


<!-- Modal -->


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

             <div id="diesel" class="novue">
              <!-- <input placeholder="Quantité" type="number" class="role" style="min-width: 220px;margin-top: 15px;padding: 5px 10px;">-->
               <input id="qts3" name="qtsDiesel" placeholder="kilometrage" type="number" min="0" class="role" style="min-width: 220px;margin-top: 15px;padding: 5px 10px;"><br>
               <center><div class="col-6"><p style="margin:0; margin-top: 20px;text-align: left;">Total remboursé</p></div></center>
              <center><div class="row col-6" style="margin-top: 0px"><div style="text-align: left;padding: 0px 4px;" min="0" class="col-12"><span id="total3">0</span><span> €</span></p></div></div></center>
              
              <button name="submitFicheFrais" type="submit" class="btnplus" style="min-width: 220px">Valider la fiche</button>
            </div>

                          <div id="essence" class="novue"><input id="qts4" name="qtsEssence" placeholder="kilomètreage" type="number" class="role" min="0" style="min-width: 220px;margin-top: 15px;padding: 5px 10px;"><br>
              <center><div class="col-6"><p style="margin:0; margin-top: 20px;text-align: left;">Total remboursé</p></div></center>
              <center><div class="row col-6" style="margin-top: 0px"><div style="text-align: left;padding: 0px 4px;" class="col-12"><span id="total4" min="0">0</span><span> €</span></p></div><div style="text-align: left;padding: 0px 25px;" class="col-6"></div></div></center>
              <button name="submitFicheFrais" type="submit" class="btnplus" style="min-width: 220px">Valider la fiche</button>
              </div>

              <div id="all" class="novue animated fadeIn">
              <input id="qts" name="qtsHotel" placeholder="Quantité" type="number" min="0" class="role" style="min-width: 220px;margin-top: 15px;padding: 5px 10px;"><br>
              <center><div class="col-6"><p style="margin:0; margin-top: 20px;text-align: left;">Total remboursé</p></div></center>
              <center><div class="row col-6" style="margin-top: 0px"><div style="text-align: left;padding: 0px 4px;" class="col-12"><p><span id="total" min="0">0</span><span> €</span></p></div><div style="text-align: left;padding: 0px 15px;" class="col-6"><span> </span></div></div></center>
              
              <button name="submitFicheFrais" type="submit" class="btnplus" style="min-width: 220px">Valider la fiche</button>
            </div>

            <div id="all2" class="novue animated fadeIn">
              
              <input id="qts2" name="qtsRestauration" placeholder="Quantité" type="number" min="0" class="role" style="min-width: 220px;margin-top: 15px;padding: 5px 10px;"><br>
              <center><div class="col-6"><p style="margin:0; margin-top: 20px;text-align: left;">Total remboursé</p></div></center>
              <center><div class="row col-6" style="margin-top: 0px"><div style="text-align: left;padding: 0px 4px;" min="0" class="col-12">
              <span id="total2">0</span><span> €</span></p></div></div></center>
              
              <button name="submitFicheFrais" type="submit" class="btnplus" style="min-width: 220px">Valider la fiche</button>
            </div>
          </form>
      </div>

     

  
    </body>
</html>