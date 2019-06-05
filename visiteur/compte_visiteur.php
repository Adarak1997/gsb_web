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

    //select les fiches frais de mois et année en cours et de l'utilisateur connecté
    $fiche = $bdd->query("SELECT * FROM fiche_frais WHERE mois = '".$mois."' AND annee ='".$annee."' AND utilisateur_id ='".$userId."'");
    //si <1 soit 0 aucune fiche frais existe
    if($fiche->rowCount()<1){
      //il crée donc la fiche frais avant d'insérer le frais
      $creer=$bdd->prepare('INSERT INTO `fiche_frais` (`id`, `mois`, `annee`, `etat_id`, `utilisateur_id`)
      VALUES (id, "'.$mois.'", "'.$annee.'", "1", "'.$userId.'")');

      $creer->execute();
      //lastInsertId sert à récupérer le dernier id insérer dans la bdd c'est à dire celle de la fiche frais
      $creer2 = $bdd->lastInsertId();
      //crée le frais et mettant dans l'id de la fiche frais la variable qui récupère le lastInsertId
      $FraisHorsForfait = $bdd->prepare('INSERT INTO `details_frais_non_forfait` (`id`, `libelle`, `montant`, `fiche_frais_id`, `etat_id`)
      VALUES (id, "'.$libelle.'", "'.$montant.'" , "'.$creer2.'" , "1")');
    
    
      $FraisHorsForfait->execute();
      //sert à refresh la page pour faire apparaitre directement le frais
      echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";

    }else{
      //sinon si =1 la fiche existe déjà il crée donc directement le frais
    $FraisHorsForfait = $bdd->prepare('INSERT INTO `details_frais_non_forfait` (`id`, `libelle`, `montant`, `fiche_frais_id`, `etat_id`)
    VALUES (id, "'.$libelle.'", "'.$montant.'" , "'.$idFiche.'" , "1")');
    
    
    $FraisHorsForfait->execute();
    //refresh la page 
    echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
  
    }
  
}

  if(isset($_POST['ajoutKilometre'])){

  if(isset($_POST['kilometre'])){
    $kilometre = $_POST['kilometre'];
    //select les fiches frais du mois, année en cours de l'utilisateur co
    $fiche = $bdd->query("SELECT * FROM fiche_frais WHERE mois = '".$mois."' AND annee ='".$annee."' AND utilisateur_id ='".$userId."'");
    //si <1 aucune fiche existe
    if($fiche->rowCount()<1){
      //il crée d'abord la fiche du mois
      $creer=$bdd->prepare('INSERT INTO `fiche_frais` (`id`, `mois`, `annee`, `etat_id`, `utilisateur_id`)
      VALUES (id, "'.$mois.'", "'.$annee.'", "1", "'.$userId.'")');

      $creer->execute();
      //récupére l'id de la fiche crée précedemment
      $creer2 = $bdd->lastInsertId();
      //ensuite il vérifie si un frais id=1 cad kilometrage existe déjà pour la fiche en cours
    $verifier = $bdd->query("SELECT * FROM details_frais_forfait WHERE frais_forfait_id='1' AND fiche_frais_id='".$creer2."'");
    
      //si il existe pas <1
    if($verifier->rowCount()<1){
      //il insert le frais dans la bdd
      $FraisKilometre = $bdd->prepare('INSERT INTO `details_frais_forfait` (`id`, `quantite`, `frais_forfait_id`, `fiche_frais_id`, `etat_id`)
    VALUES (id, "'.$kilometre.'", "1", "'.$creer2.'", "1")');

    $FraisKilometre->execute();
      //refresh
    echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
    //sinon si le frais existe déjà
    }else{
      //update le frais déjà existant en l'ajoutant exemple : si kilometrage avait déjà 20 en quantite et tu entres 50, kilometrage aura 70 mnt
      $updateKilometre = $bdd->prepare("UPDATE details_frais_forfait SET quantite = quantite + :quantite, frais_forfait_id ='1', fiche_frais_id = :fiche, etat_id ='1' WHERE frais_forfait_id ='1' AND fiche_frais_id ='".$idFiche."'");
      $updateKilometre->bindparam(':quantite',$kilometre);
      $updateKilometre->bindparam(':fiche',$idFiche);
      $updateKilometre->execute();
      //refresh
      echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
    }
    //si la fiche existe déjà =1 rebelote
    }else{
      //vérifie si le détails existe
      $verifier = $bdd->query("SELECT * FROM details_frais_forfait WHERE frais_forfait_id='1' AND fiche_frais_id='".$idFiche."'");
    
      //si il existe pas <1
    if($verifier->rowCount()<1){
      //le crée
      $FraisKilometre = $bdd->prepare('INSERT INTO `details_frais_forfait` (`id`, `quantite`, `frais_forfait_id`, `fiche_frais_id`, `etat_id`)
    VALUES (id, "'.$kilometre.'", "1", "'.$idFiche.'", "1")');

    $FraisKilometre->execute();
      //refresh
    echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
    }else{
      //si il existe update la bdd en ajoutant les quantités
      $updateKilometre = $bdd->prepare("UPDATE details_frais_forfait SET quantite = quantite + :quantite, frais_forfait_id ='1', fiche_frais_id = :fiche, etat_id ='1' WHERE frais_forfait_id ='1' AND fiche_frais_id ='".$idFiche."'");
      $updateKilometre->bindparam(':quantite',$kilometre);
      $updateKilometre->bindparam(':fiche',$idFiche);
      $updateKilometre->execute();
      //refresh
      echo "<meta http-equiv='refresh' content=\"0; URL=compte_visiteur.php\">";
    }

    }

  }
}

//la même chose que kilometrage pour les requêtes
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
//la même chose que kilometrage pour les requêtes
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
//la même chose que kilometrage pour les requêtes
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