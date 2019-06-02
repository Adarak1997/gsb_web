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

        <div id="content">

             
            <!-- tester si l'utilisateur est connecté -->

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
      ?>


 <?php




$reponse=$bdd->query("SELECT details_frais_forfait.id, details_frais_forfait.quantite as quantite,
             frais_forfait.id as frais_forfait_id, 
             frais_forfait.libelle as libelle, 
             frais_forfait.montant as montant, 
             fiche_frais.id as fiche_frais_id,
             fiche_frais.mois, fiche_frais.annee, fiche_frais.utilisateur_id as utilisateur_id,
              etat.id as etat_id, etat.libelle as libel 
              FROM details_frais_forfait 
              inner join frais_forfait 
              on details_frais_forfait.frais_forfait_id = frais_forfait.id 
              inner join etat on details_frais_forfait.etat_id = etat.id 
              inner join fiche_frais on details_frais_forfait.fiche_frais_id = fiche_frais.id
 WHERE fiche_frais.mois = '".$mois."'
 AND fiche_frais.annee = '".$annee."'
 AND utilisateur_id = '".$userId."'");



?> 
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-7 text-center">

      <div class="w3-card-4">
          <header class="w3-container w3-blue">
            <h1>Fiche Frais du mois en cours : <?php echo $lemois[$mois-1]  ?> <?php echo $annee ?>  </h1>
          </header>
  
          <div class="w3-container">
            <p> <h1 style="float:left;"><u>Frais Forfaitisés</u> </h1>
                  <table class="table">
                    <thead class="thead">
              <tr>
                <td style="text-decoration: bold;" scope="col">Libelle</td>
                <td scope="col">Quantité</td>
                <td scope="col">Montant</td>
                <td scope="col">Etat</td>
              </tr>
              <?php  while($row = $reponse->fetch()){
              echo "<tr><td>". $row["libelle"]."</td><td>". $row["quantite"]. "</td><td>". $row["montant"]*$row["quantite"]. "</td><td>".  $row["libel"].  "</td></tr>";
  
              }
              echo "</table>";
            ?>
            </p>
            </div>
            <br><br>
            <?php 
            $reponse=$bdd->query("SELECT details_frais_non_forfait.id,
            details_frais_non_forfait.libelle as libelle,
            details_frais_non_forfait.montant as montant,
            fiche_frais.id as fiche_frais_id,
            fiche_frais.mois, fiche_frais.annee, fiche_frais.utilisateur_id as utilisateur_id,
            etat.id as etat_id, 
            etat.libelle as libelle_etat
            FROM details_frais_non_forfait 
            inner join etat on details_frais_non_forfait.etat_id = etat.id
            inner join fiche_frais on details_frais_non_forfait.fiche_frais_id = fiche_frais.id
            WHERE fiche_frais.mois = '".$mois."'
      AND fiche_frais.annee = '".$annee."'
      AND utilisateur_id = '".$userId."'");


  
            ?>
      <div class="w3-container">
  <p><h1 style="float:left;"><u>Frais non forfaitisés</u></h1>
        <table class="table">
        <thead class="thead">
        <tr>
          <th scope="col">Libelle</th>
          <th scope="col">Montant</th>
          <th scope="col">Etat</th>
        </tr>
            
      <?php
  
    while($row = $reponse->fetch()){
  
        
  
      echo "<tr><td>". $row["libelle"]. "</td><td>". $row["montant"]. "</td><td>". $row["libelle_etat"]. "<td></tr>";
  
    }
      echo "</table>";
      ?>
  
  </p>
      </div>
      <br><br>
  

      <?php
$reponse= $bdd->query("SELECT fiche_frais.id, fiche_frais.mois, fiche_frais.annee, 
fiche_frais.utilisateur_id as utilisateur_id
FROM fiche_frais 
WHERE (fiche_frais.mois = '".$mois."' AND fiche_frais.annee = '".$annee."') 
AND utilisateur_id = '".$userId."'");

$sql = $reponse->fetch();
$idFiche = $sql['id'];

?>
      
  
          
        </div>
    </div>
        <div class="col-lg-5 text-center" >
          <div class="w3-card-4">
            <header style="margin-bottom:20px;" class="w3-container w3-blue">
              <h1>Ajout frais forfaitisés</h1>
            </header>
            <form style="margin-bottom:20px;" class="w3-container" action="" method="POST">                                        
                <div class="form-group">
                  <label style="float:left;">Kilomètres</label>
                  <input type="number" min="0"  name="kilometre" class="form-control" placeholder="Rentrez le nombre de kilomètres parcourus">
                </div>
                <input style="padding: 10px 80px;" class="btn btn-primary btnAjout" type="submit" name="ajoutKilometre" value="Valider"/>
                <div class="form-group">
                  <label style="float:left;">Nuits</label>
                  <input type="number" min="0"  name="nuit" class="form-control" placeholder="Rentrez le nombre de nuits">
                </div>
                <input style="padding: 10px 80px;" class="btn btn-primary btnAjout" type="submit" name="ajoutNuit" value="Valider"/>
                <div class="form-group">
                  <label style="float:left;">Repas midi</label>
                  <input type="number" min="0"  name="repas_midi" class="form-control" placeholder="Rentrez le nombre de repas midi">
                </div>
                <input style="padding: 10px 80px;" class="btn btn-primary btnAjout" type="submit" name="ajoutRepas" value="Valider"/>
                <div class="form-group">
                  <label style="float:left;">Relais étape</label>
                  <input type="number" min="0"  name="relais_etape" class="form-control" placeholder="Rentrez le nombre de relais étape">
                </div>
                <input style="padding: 10px 80px;" class="btn btn-primary btnAjout" type="submit" name="ajoutRelais" value="Valider"/>
              </form>

        


            <header style="margin-bottom:20px;" class="w3-container w3-blue">
              <h1>Ajout frais non forfaitisés</h1>
            </header>
            <form style="padding-bottom:20px;" class="w3-container" method="POST" action="">  
                <div class="form-group">
                  <label style="float:left;">Libellé frais</label>
                  <input name="libelle" class="form-control" placeholder="Rentrez le libellé" required>
                </div> 
                        
                <div class="form-group">
                  <label style="float:left;">Montant du frais</label>
                  <input type="number" min="0"  name="montant" class="form-control" placeholder="Rentrez le montant" required>
                </div>
                <input style="padding: 10px 80px;" class="btn btn-primary btnAjout" type="submit" name="submit" value="Valider"/>
            </form>
          </div>
      </div>
    </div>
  </div>

  <?php

  


  if(isset($_POST['libelle']) && isset($_POST['montant'])){
    $libelle = $_POST['libelle'];
    $montant = $_POST['montant'];

    $fiche = $bdd->query("SELECT * FROM fiche_frais WHERE mois = '".$mois."' AND annee ='".$annee."' AND utilisateur_id ='".$userId."'");

    if($fiche->rowCount()<1){
      
      $creer=$bdd->prepare('INSERT INTO `fiche_frais` (`id`, `mois`, `annee`, `etat_id`, `utilisateur_id`)
      VALUES (id, "'.$mois.'", "'.$annee.'", "1", "'.$userId.'")');

      $creer->execute();

      $creer2 = $bdd->lastInsertId();

      $FraisHorsForfait = $bdd->prepare('INSERT INTO `details_frais_non_forfait` (`id`, `libelle`, `montant`, `fiche_frais_id`, `etat_id`)
      VALUES (id, "'.$libelle.'", "'.$montant.'" , "'.$creer2.'" , "1")');
    
    
      $FraisHorsForfait->execute();
    
      echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";

    }else{
    $FraisHorsForfait = $bdd->prepare('INSERT INTO `details_frais_non_forfait` (`id`, `libelle`, `montant`, `fiche_frais_id`, `etat_id`)
    VALUES (id, "'.$libelle.'", "'.$montant.'" , "'.$idFiche.'" , "1")');
    
    
    $FraisHorsForfait->execute();
    
    echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
  
    }
  
}

  if(isset($_POST['ajoutKilometre'])){

  if(isset($_POST['kilometre'])){
    $kilometre = $_POST['kilometre'];

    $fiche = $bdd->query("SELECT * FROM fiche_frais WHERE mois = '".$mois."' AND annee ='".$annee."' AND utilisateur_id ='".$userId."'");

    if($fiche->rowCount()<1){

      $creer=$bdd->prepare('INSERT INTO `fiche_frais` (`id`, `mois`, `annee`, `etat_id`, `utilisateur_id`)
      VALUES (id, "'.$mois.'", "'.$annee.'", "1", "'.$userId.'")');

      $creer->execute();

      $creer2 = $bdd->lastInsertId();

    $verifier = $bdd->query("SELECT * FROM details_frais_forfait WHERE frais_forfait_id='1' AND fiche_frais_id='".$creer2."'");
    

    if($verifier->rowCount()<1){
      $FraisKilometre = $bdd->prepare('INSERT INTO `details_frais_forfait` (`id`, `quantite`, `frais_forfait_id`, `fiche_frais_id`, `etat_id`)
    VALUES (id, "'.$kilometre.'", "1", "'.$creer2.'", "1")');

    $FraisKilometre->execute();

    echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
    }else{
      $updateKilometre = $bdd->prepare("UPDATE details_frais_forfait SET quantite = quantite + :quantite, frais_forfait_id ='1', fiche_frais_id = :fiche, etat_id ='1' WHERE frais_forfait_id ='1' AND fiche_frais_id ='".$idFiche."'");
      $updateKilometre->bindparam(':quantite',$kilometre);
      $updateKilometre->bindparam(':fiche',$idFiche);
      $updateKilometre->execute();

      echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
    }

    }else{
      $verifier = $bdd->query("SELECT * FROM details_frais_forfait WHERE frais_forfait_id='1' AND fiche_frais_id='".$idFiche."'");
    

    if($verifier->rowCount()<1){
      $FraisKilometre = $bdd->prepare('INSERT INTO `details_frais_forfait` (`id`, `quantite`, `frais_forfait_id`, `fiche_frais_id`, `etat_id`)
    VALUES (id, "'.$kilometre.'", "1", "'.$idFiche.'", "1")');

    $FraisKilometre->execute();

    echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
    }else{
      $updateKilometre = $bdd->prepare("UPDATE details_frais_forfait SET quantite = quantite + :quantite, frais_forfait_id ='1', fiche_frais_id = :fiche, etat_id ='1' WHERE frais_forfait_id ='1' AND fiche_frais_id ='".$idFiche."'");
      $updateKilometre->bindparam(':quantite',$kilometre);
      $updateKilometre->bindparam(':fiche',$idFiche);
      $updateKilometre->execute();

      echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
    }

    }

  }
}
elseif(isset($_POST['ajoutNuit'])){

  if(isset($_POST['nuit'])){
    $nuit = $_POST['nuit'];

    $fiche = $bdd->query("SELECT * FROM fiche_frais WHERE mois = '".$mois."' AND annee ='".$annee."' AND utilisateur_id ='".$userId."'");

    if($fiche->rowCount()<1){

      $creer=$bdd->prepare('INSERT INTO `fiche_frais` (`id`, `mois`, `annee`, `etat_id`, `utilisateur_id`)
      VALUES (id, "'.$mois.'", "'.$annee.'", "1", "'.$userId.'")');

      $creer->execute();

      $creer2 = $bdd->lastInsertId();

    $verifier2 = $bdd->query("SELECT * FROM details_frais_forfait WHERE frais_forfait_id='4' AND fiche_frais_id='".$creer2."'");
    

    if($verifier2->rowCount()<1){
      $FraisNuit = $bdd->prepare('INSERT INTO `details_frais_forfait` (`id`, `quantite`, `frais_forfait_id`, `fiche_frais_id`, `etat_id`)
    VALUES (id, "'.$nuit.'", "4", "'.$creer2.'", "1")');

    $FraisNuit->execute();

    echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
    }else{
      $updateNuit = $bdd->prepare("UPDATE details_frais_forfait SET quantite = quantite + :quantite, frais_forfait_id ='4', fiche_frais_id = :fiche, etat_id ='1' WHERE frais_forfait_id ='4' AND fiche_frais_id ='".$idFiche."'");
      $updateNuit->bindparam(':quantite',$nuit);
      $updateNuit->bindparam(':fiche',$idFiche);
      $updateNuit->execute();

      echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
    }

    }else{
      $verifier2 = $bdd->query("SELECT * FROM details_frais_forfait WHERE frais_forfait_id='4' AND fiche_frais_id='".$idFiche."'");
    

    if($verifier2->rowCount()<1){
      $FraisNuit = $bdd->prepare('INSERT INTO `details_frais_forfait` (`id`, `quantite`, `frais_forfait_id`, `fiche_frais_id`, `etat_id`)
    VALUES (id, "'.$nuit.'", "4", "'.$idFiche.'", "1")');

    $FraisNuit->execute();

    echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
    }else{
      $updateNuit = $bdd->prepare("UPDATE details_frais_forfait SET quantite = quantite + :quantite, frais_forfait_id ='4', fiche_frais_id = :fiche, etat_id ='1' WHERE frais_forfait_id ='4' AND fiche_frais_id ='".$idFiche."'");
      $updateNuit->bindparam(':quantite',$nuit);
      $updateNuit->bindparam(':fiche',$idFiche);
      $updateNuit->execute();

      echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
    }

    }

  }
}

elseif(isset($_POST['ajoutRepas'])){

  if(isset($_POST['repas_midi'])){
    $midi = $_POST['repas_midi'];

    $fiche3 = $bdd->query("SELECT * FROM fiche_frais WHERE mois = '".$mois."' AND annee ='".$annee."' AND utilisateur_id ='".$userId."'");

    if($fiche3->rowCount()<1){

      $creer5=$bdd->prepare('INSERT INTO `fiche_frais` (`id`, `mois`, `annee`, `etat_id`, `utilisateur_id`)
      VALUES (id, "'.$mois.'", "'.$annee.'", "1", "'.$userId.'")');

      $creer5->execute();

      $creer6 = $bdd->lastInsertId();

    $verifier3 = $bdd->query("SELECT * FROM details_frais_forfait WHERE frais_forfait_id='2' AND fiche_frais_id='".$creer6."'");
    

    if($verifier3->rowCount()<1){
      $FraisMidi = $bdd->prepare('INSERT INTO `details_frais_forfait` (`id`, `quantite`, `frais_forfait_id`, `fiche_frais_id`, `etat_id`)
    VALUES (id, "'.$midi.'", "2", "'.$creer6.'", "1")');

    $FraisMidi->execute();

    echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
    }else{
      $updateMidi = $bdd->prepare("UPDATE details_frais_forfait SET quantite = quantite + :quantite, frais_forfait_id ='2', fiche_frais_id = :fiche, etat_id ='1' WHERE frais_forfait_id ='2' AND fiche_frais_id ='".$idFiche."'");
      $updateMidi->bindparam(':quantite',$midi);
      $updateMidi->bindparam(':fiche',$idFiche);
      $updateMidi->execute();

      echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
    }

  }else{
    $verifier3 = $bdd->query("SELECT * FROM details_frais_forfait WHERE frais_forfait_id='2' AND fiche_frais_id='".$idFiche."'");
    

    if($verifier3->rowCount()<1){
      $FraisMidi = $bdd->prepare('INSERT INTO `details_frais_forfait` (`id`, `quantite`, `frais_forfait_id`, `fiche_frais_id`, `etat_id`)
    VALUES (id, "'.$midi.'", "2", "'.$idFiche.'", "1")');

    $FraisMidi->execute();

    echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
    }else{
      $updateMidi = $bdd->prepare("UPDATE details_frais_forfait SET quantite = quantite + :quantite, frais_forfait_id ='2', fiche_frais_id = :fiche, etat_id ='1' WHERE frais_forfait_id ='2' AND fiche_frais_id ='".$idFiche."'");
      $updateMidi->bindparam(':quantite',$midi);
      $updateMidi->bindparam(':fiche',$idFiche);
      $updateMidi->execute();

      echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
    }
  }

  }
}

elseif(isset($_POST['ajoutRelais'])){
  
  if(isset($_POST['relais_etape'])){
    $relais = $_POST['relais_etape'];

    $fiche4 = $bdd->query("SELECT * FROM fiche_frais WHERE mois = '".$mois."' AND annee ='".$annee."' AND utilisateur_id ='".$userId."'");

    if($fiche4->rowCount()<1){

      $creer7=$bdd->prepare('INSERT INTO `fiche_frais` (`id`, `mois`, `annee`, `etat_id`, `utilisateur_id`)
      VALUES (id, "'.$mois.'", "'.$annee.'", "1", "'.$userId.'")');

      $creer7->execute();

      $creer8 = $bdd->lastInsertId();

    $verifier4 = $bdd->query("SELECT * FROM details_frais_forfait WHERE frais_forfait_id='3' AND fiche_frais_id='".$creer8."'");
    

    if($verifier4->rowCount()<1){
      $FraisRelais = $bdd->prepare('INSERT INTO `details_frais_forfait` (`id`, `quantite`, `frais_forfait_id`, `fiche_frais_id`, `etat_id`)
    VALUES (id, "'.$relais.'", "3", "'.$creer8.'", "1")');

    $FraisRelais->execute();

    echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
    }else{
      $updateRelais = $bdd->prepare("UPDATE details_frais_forfait SET quantite = quantite + :quantite, frais_forfait_id ='3', fiche_frais_id = :fiche, etat_id ='1' WHERE frais_forfait_id ='3' AND fiche_frais_id ='".$idFiche."'");
      $updateRelais->bindparam(':quantite',$relais);
      $updateRelais->bindparam(':fiche',$idFiche);
      $updateRelais->execute();

      echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
    }

  }else{
    $verifier4 = $bdd->query("SELECT * FROM details_frais_forfait WHERE frais_forfait_id='3' AND fiche_frais_id='".$idFiche."'");
    

    if($verifier4->rowCount()<1){
      $FraisRelais = $bdd->prepare('INSERT INTO `details_frais_forfait` (`id`, `quantite`, `frais_forfait_id`, `fiche_frais_id`, `etat_id`)
    VALUES (id, "'.$relais.'", "3", "'.$idFiche.'", "1")');

    $FraisRelais->execute();

    echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
    }else{
      $updateRelais = $bdd->prepare("UPDATE details_frais_forfait SET quantite = quantite + :quantite, frais_forfait_id ='3', fiche_frais_id = :fiche, etat_id ='1' WHERE frais_forfait_id ='3' AND fiche_frais_id ='".$idFiche."'");
      $updateRelais->bindparam(':quantite',$relais);
      $updateRelais->bindparam(':fiche',$idFiche);
      $updateRelais->execute();

      echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
    }
  }

  }
}
  
  ?>

        <!-- Footer -->
        <footer>
            <div class="container text-center footer2">
                <p style="padding-top:20px;">© 2019 - GALAXY SWISS BOURDIN</p>
            </div>
        </footer>
  

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>     

    </body>
</html>