<?php
session_start();
include ('../bdd.php');



$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$date_naissance = $_POST['date_naissance'];
$adresse = $_POST['adresse'];
$ville = $_POST['ville'];
$code_postal = $_POST['code_postal'];
$date_embauche = $_POST['date_embauche'];
$pseudo = $_POST['pseudo'];

$requete = $bdd->prepare('UPDATE `utilisateur`
						  SET `nom`=:nom, `prenom`=:prenom, `email`=:email, `date_naissance`=:date_naissance,
							  `adresse`=:adresse, `ville`=:ville, `code_postal`=:code_postal,`date_embauche`=:date_embauche,
							  `pseudo`=:pseudo,');

$requete->bindParam(':id', $_GET['id']);
$requete->bindParam(':nom', $nom);
$requete->bindParam(':prenom', $prenom);
$requete->bindParam(':email', $email);
$requete->bindParam(':date_naissance', $date_naissance);
$requete->bindParam(':adresse', $adresse);
$requete->bindParam(':ville', $ville);
$requete->bindParam(':code_postal', $code_postal);
$requete->bindParam(':date_embauche', $date_embauche);
$requete->bindParam(':pseudo', $pseudo);

header('Location: ../admin/listeUtilisateur.php');
$requete->execute();

?>