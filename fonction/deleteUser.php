<?php 	
session_start();
include '../bdd.php';

	$id = $_GET['id'];

	$requete = $bdd->prepare('DELETE FROM utilisateur WHERE id = :id');
	$requete->bindParam(':id', $id);
	$requete->execute();

	header('Location: ../admin/listeUtilisateur.php');

?>