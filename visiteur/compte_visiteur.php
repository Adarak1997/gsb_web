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
                <th scope="col">Libelle</th>
                <th scope="col">Quantité</th>
                <th scope="col">Montant</th>
                <th scope="col">Etat</th>
              </tr>
              <?php  while($row = $reponse->fetch()){
              echo "<tr><td>". $row["libelle"]."</td><td>". $row["quantite"]. "</td><td>". $row["montant"]*$row["quantite"]. "</td><td>".  $row["libel"].  "<td></tr>";
  
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
  
        
  
        echo "<tr><td>". $row["libelle"]."</td><td>". $row["montant"]. "</td><td>".  $row["libelle_etat"].  "<td></tr>";
  
      }
      echo "</table>";
      ?>
  
            </p>
          </div>
      <br><br>
  
  
          
        </div>
    </div>
        <div class="col-lg-5 text-center" >
          <div class="w3-card-4">
            <header style="margin-bottom:20px;" class="w3-container w3-blue">
              <h1>Ajout frais forfaitisés</h1>
            </header>
            <form style="margin-bottom:20px;" class="w3-container" action="../fonction/newFraisForfait.php" method="POST">  
                <div class="form-group">
                  <label style="float:left;">Choix du frais forfait</label>
                  <select name="frais_forfait" class="form-control">
                    <option selected>Sélectionner un frais forfait</option>
                    <?php  foreach ($fraiss as $frais) { ?>
                    <option value="<?php echo $frais['id']; ?>"><?php echo $frais['libelle']; ?></option>
                    <?php } ?>
                  </select>
                </div> 
                        
                <div class="form-group">
                  <label style="float:left;">Quantité du frais</label>
                  <input type="number" min="0"  name="quantite" class="form-control" placeholder="Rentrez votre quantité" required>
                </div>
                <input style="padding: 10px 80px;" class="btn btn-primary btnAjout" type="submit" value="Valider"/>
              </form>

            <header style="margin-bottom:20px;" class="w3-container w3-blue">
              <h1>Ajout frais non forfaitisés</h1>
            </header>
            <form style="padding-bottom:20px;" class="w3-container" action="../fonction/newFraisForfait.php" method="POST">  
                <div class="form-group">
                  <label style="float:left;">Libellé frais</label>
                  <input name="libelle" class="form-control" placeholder="Rentrez le libellé" required>
                </div> 
                        
                <div class="form-group">
                  <label style="float:left;">Montant du frais</label>
                  <input type="number" min="0"  name="montant" class="form-control" placeholder="Rentrez le montant" required>
                </div>
                <input style="padding: 10px 80px;" class="btn btn-primary btnAjout" type="submit" value="Valider"/>
            </form>
          </div>
      </div>
    </div>
  </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>     

    </body>
</html>