<?php
session_start();
include ('../bdd.php');

$id = $_GET['id'];

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$date_naissance = $_POST['date_naissance'];
$adresse = $_POST['adresse'];
$ville = $_POST['ville'];
$code_postal = $_POST['code_postal'];
$date_embauche = $_POST['date_embauche'];
$pseudo = $_POST['pseudo'];


$requete = $bdd->prepare("UPDATE utilisateur
						  SET nom = '$nom',
							  prenom = '$prenom',
							  email = '$email',
							  date_naissance = '$date_naissance',
							  adresse = '$adresse',
							  ville = '$ville',
							  code_postal = '$code_postal',
							  date_embauche = '$date_embauche',
							  pseudo = '$pseudo
						  WHERE id = '$id' ");

$requete->execute();

header('Location: ../admin/listeUtilisateur.php');

?>