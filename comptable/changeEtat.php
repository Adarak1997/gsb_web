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

    </head>

    <body>




<h3>Modifier l'état du frais : </h3>

<?php

$etat = $bdd->query('SELECT id,libelle  FROM etat');
while($donnees = $etat->fetch()){

?>
<form method="POST">


              <div class="radio">
                <label><input class="radio-inline" type="radio" name="libelle"  checked><?php echo $donnees['libelle']; ?></label>
              </div>
<?php } ?>
              <input class="btn btn-primary btnModif" href="ficheFrais.php" type="submit" value="Valider"/>
              <br><br>
            </form>


    
<?php 
$idDFHF = $_GET['id'];
if(isset($_POST['libelle'])){




$requete = $bdd->prepare("UPDATE details_frais_non_forfait
						  SET etat_id = '2'
                          WHERE details_frais_non_forfait.id = $idDFHF");
                          
                          

                          $requete->execute();

                          
}


?>

<script src="../js/boostrap.min.js"></script>               
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

</body>
</html>