<?php 	
session_start();
include '../bdd.php';

$id = $_GET['id'];

$requete = $bdd->prepare("UPDATE details_frais_non_forfait SET etat_id ='2' WHERE id =:id");

$requete->bindParam(':id', $id);
$requete->execute();

header('Location : ../comptable/ficheFrais.php');

?>