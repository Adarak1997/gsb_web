<?php
    session_start();
    include ('../bdd.php');
    if (isset($_POST['role'])  && isset($_POST['nom'])  && isset($_POST['prenom'])  && isset($_POST['date_naissance']) 
    && isset($_POST['email'])  && isset($_POST['mdp'])  && isset($_POST['ville'])   && isset($_POST['adresse']) 
    && isset($_POST['code_postal'])  && isset($_POST['pseudo'])  && isset($_POST['date_embauche']) )
    {
        $role = $_POST['role'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $date_naissance = $_POST['date_naissance'];
        $email = $_POST['email'];
        $mdp = md5($_POST['mdp']);  //hachage du mot de passe
        $ville = $_POST['ville'];
        $adresse = $_POST['adresse'];
        $code_postal = $_POST['code_postal'];
        $pseudo = $_POST['pseudo'];
        $date_embauche = $_POST['date_embauche'];

       /* echo "Rôle: " .$role. "<br><br>";
        echo "Nom: " .$nom. "<br></br>";
        echo "Prénom: " .$prenom. "<br><br>";
        echo "Date de naissance: " .$date_naissance. "<br><br>";
        echo "E-mail: " .$email. "<br><br>";
        echo "Mot de passe: " .$mdp. "<br><br>";
        echo "Ville: " .$ville. "<br><br>";
        echo "Adresse: " .$adresse. "<br><br>";
        echo "Code Postal: " .$code_postal. "<br><br>";
        echo "Pseudo: " .$pseudo. "<br><br>";
        echo "Date d'embauche: " .$date_embauche. "<br><br>";*/

        $query = $bdd ->prepare('INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `email`, `date_naissance`, `adresse`, `ville`,
         `code_postal`, `date_embauche`, `pseudo`, `mdp`, `role_id`) 
        VALUES (id, :nom, :prenom, :email, :date_naissance, :adresse, :ville, :code_postal, :date_embauche,  :pseudo, :mdp,
                :role_id)');
        $query ->bindParam(':role_id', $role);
        $query ->bindParam(':nom', $nom);
        $query ->bindParam(':prenom', $prenom);
        $query ->bindParam(':date_naissance', $date_naissance);
        $query ->bindParam(':email', $email);
        $query ->bindParam(':mdp', $mdp);
        $query ->bindParam(':ville', $ville);
        $query ->bindParam(':adresse', $adresse);
        $query ->bindParam(':code_postal', $code_postal);
        $query ->bindParam(':pseudo', $pseudo);
        $query ->bindParam(':date_embauche', $date_embauche);
        $query->execute();


    
    // Insertion en bdd

     header('Location: ../admin/listeUtilisateur.php');
}

?>