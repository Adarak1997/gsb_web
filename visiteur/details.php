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
          <th scope="col">Libelle</th>
          <th scope="col">Quantité</th>
          <th scope="col">Montant</th>
          <th scope="col">Etat</th>
        </tr>

            <?php
            

              include("../bdd.php");

              $sql = $bdd->query("SELECT mois, annee, id FROM fiche_frais");
        
            $sql2 = $sql->fetch();
      
            $id_fichefrais = $sql2['id'];

           
            $sql2=$bdd->query("SELECT details_frais_forfait.id, details_frais_forfait.quantite as quantite, frais_forfait.id as frais_forfait_id, frais_forfait.libelle as libelle, frais_forfait.montant as montant, details_frais_forfait.fiche_frais_id as fiche_frais_id, etat.id as etat_id, etat.libelle as libel FROM details_frais_forfait inner join frais_forfait on details_frais_forfait.frais_forfait_id = frais_forfait.id inner join etat on details_frais_forfait.etat_id = etat.id WHERE fiche_frais_id = '".$id_fichefrais."'");
               
               while($row = $sql2->fetch()){

                

                  echo "<tr><td>". $row["libelle"]."</td><td>". $row["quantite"]. "</td><td>". $row["montant"]. "</td><td>".  $row["libel"].  "<td></tr>";

                }
                echo "</table>";
    ?>