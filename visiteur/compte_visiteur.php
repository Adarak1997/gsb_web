<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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

    <div class="headbox animated fadeInLeft delay-1s" style="background: rgba(240,240,240,1.00);height: 100%; background-color: red;"><a href="#menu-toggle" class="btn btn-secondary" id="menu-toggle"><i id="bar" class="fa fa-times-circle" aria-hidden="true"></i></a> <a href="compte_visiteur.php?deconnexion=true."><button style="background-color: red" class="deco2"><i class="fa fa-power-off"></i> Déconnexion</button></a> <p1  class="compte">(<?php echo $reponse['libel']?>) <?php echo $_SESSION['pseudo'] ?></p1>  <a href="#btnnotif" id="btnnotif" class="notif"><i id="notif" class="fa fa-envelope-open"></i></a></div>

              

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

<br><br>

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

<div class="w3-card-4" style="width:50%;">
    <header class="w3-container w3-blue">
      <h1>Fiche Frais du mois en cours : <?php echo $lemois[$mois-1]  ?> <?php echo $annee ?>  </h1>
    </header>

    <div class="w3-container">
      <p> <h1><u>Frais Forfaitisés</u> </h1>
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
       <p><h1><u>Frais non forfaitisés</u></h1>

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
  <section class="container formulaire">
            <h1>Formulaire d'ajout de frais forfait</h1>
            <form action="../fonction/newFraisForfait.php" method="POST">  
            <div class="form-group">
                    <label>Choix du frais forfait</label>
                    <select name="frais_forfait" class="form-control">
                        <option selected>Sélectionner un frais forfait</option>
                        <?php  foreach ($fraiss as $frais) { ?>
                            <option value="<?php echo $frais['id']; ?>"><?php echo $frais['libelle']; ?></option>
                        <?php } ?>
                        </select>
                 </div> 
                 
                 <div class="form-group">
                 <label>Quantité du frais</label>
                    <input type="number" min="0"  name="quantite" class="form-control" placeholder="Rentrez votre quantité" required>
                </div>
                <input class="btn btn-primary btnAjout" type="submit" value="Valider"/>
                        </form>
                        </section>




     
  
    </body>
</html>