<?php

session_start();
if(isset($_POST['pseudo']) && isset($_POST['mdp']))
{
  
 include("../bdd.php");
    
    // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
    // pour éliminer toute attaque de type injection SQL et XSS
    $pseudo = $_POST['pseudo']; 
    $mdpCrypte = $_POST['mdp'];
    $mdp = md5($mdpCrypte);
   
    if($pseudo !== "" && $mdp !== "")
    {
            $requete =$bdd->prepare("SELECT count(*) as compteur FROM utilisateur where 
              pseudo = :pseudo and mdp = :mdp") ;

      $requete->bindParam(':pseudo', $pseudo);
      $requete->bindParam(':mdp', $mdp);
        
      $requete->execute();
        
      $reponse = $requete->fetch();
        
        if($reponse['compteur'] !=0)
      {
        $requete2 =$bdd->prepare("SELECT role_id FROM utilisateur where 
              pseudo = :pseudo and mdp = :mdp ");
        
        $requete2->bindParam(':pseudo', $pseudo);
        $requete2->bindParam(':mdp', $mdp);
        
        $requete2->execute();
        
        $reponse = $requete2->fetch();
        $_SESSION['pseudo'] = $_POST['pseudo'];
        $_SESSION['mdp'] = $_POST['mdp'];

        if($reponse['role_id'] == 1){
        header('location: ../visiteur/compte_visiteur.php');
        }
        
        if($reponse['role_id'] == 2){
        header('location: ../comptable/listeUtilisateur.php');
        }
        
        if($reponse['role_id'] == 3){
        header('location: ../admin/listeUtilisateur.php');
        }

      }
      else{
        header('Location: ../index.php?erreur=1'); // utilisateur ou mot de passe incorrect
      }
        
       
           
        

    
    }
    else
    {
       header('Location: ../index.php?erreur=2'); // utilisateur ou mot de passe vide
    }
}
else
{
   header('Location: .../index.php');
}
mysqli_close($bdd); // fermer la connexion
?>