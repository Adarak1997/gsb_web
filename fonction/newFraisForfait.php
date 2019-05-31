<?php
    session_start();
    include ('../bdd.php');

$moisEnCours = date("m");
$anneeEnCours = date("Y");


  if(isset($_POST['frais_forfait']) && isset($_POST['quantite'])){  

$verifier = $bdd ->query("SELECT COUNT(*) FROM `fiche_frais`
WHERE `utilisateur_id` = '14' AND `mois` ='.$moisEnCours.' AND `annee`='.$anneeEnCours.'");

$donnees = $verifier->fetch();
if($donnees['mois'] == 0 && $donnees['annee'] ==0){

$query= $bdd ->prepare("INSERT INTO `fiche_frais` (`id`, `mois`, `annee`, `etat_id`, `utilisateur_id`)
VALUES (id, $moisEnCours, $anneeEnCours, '1', '14')");
$query->execute();
header('Location: ../visiteur/compte_visiteur.php');
}else{






header('Location: ../visiteur/compte_visiteur.php');
    }  }
?>