<?php 	
session_start();
include '../bdd.php';


$id = $_GET['id'];

$etat = $bdd->prepare("UPDATE details_frais_non_forfait SET etat_id =2 WHERE id =:id");

$etat->bindParam(':id', $id);

$etat->execute();

header('Location : ../comptable/ficheFrais.php');

?>