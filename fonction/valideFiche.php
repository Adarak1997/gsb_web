<?php 	
session_start();
include '../bdd.php';


$id = $_GET['id'];

$etat = $bdd->prepare("UPDATE fiche_frais SET etat_id =2 WHERE id =:id");

$etat->bindParam(':id', $id);

$etat->execute();

header('Location : ../comptable/ficheFrais.php');

?>