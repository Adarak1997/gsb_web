<?php

session_start();
if(isset($_POST['pseudo']) && isset($_POST['mdp']))
{
  
 include("bdd.php");
    
    // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
    // pour éliminer toute attaque de type injection SQL et XSS
    $pseudo = mysqli_real_escape_string($db,$_POST['pseudo']); 
    $mdp1 = mysqli_real_escape_string($db,$_POST['mdp']);
    $mdp = md5($mdp1);
   
    if($pseudo !== "" && $mdp !== "")
    {
            $requete ="SELECT count(*) as compteur FROM utilisateur where 
              pseudo = '".$pseudo."' and mdp = '".$mdp."' ";

      $exec_requete = mysqli_query($db,$requete);
        $reponse      = mysqli_fetch_array($exec_requete);
        $count = $reponse['count(*)'];
        
        if($reponse['compteur'] !=0)
      {
        $requete2 ="SELECT role_id FROM utilisateur where 
              pseudo = '".$pseudo."' and mdp = '".$mdp."' ";
        $exec_requete2 = mysqli_query($db,$requete2);
        $reponse = mysqli_fetch_array($exec_requete2);
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['mdp'] = $mdp;

        if($reponse['role_id'] == 1){
        header('location: compte_visiteur.php');
        }
        
        if($reponse['role_id'] == 2){
        header('location: compte_comptable.php');
        }
        
        if($reponse['role_id'] == 3){
        header('location: compte_admin.php');
        }

      }
      else{
        header('Location: login.php?erreur=1'); // utilisateur ou mot de passe incorrect
      }
        
       
           
        

    
    }
    else
    {
       header('Location: login.php?erreur=2'); // utilisateur ou mot de passe vide
    }
}
else
{
   header('Location: login.php');
}
mysqli_close($db); // fermer la connexion
?>