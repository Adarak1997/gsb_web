<html>
    <head>
        <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
    </head>
    <body style='background:#fff;'>
        <div id="content">
            <!-- tester si l'utilisateur est connecté -->
            <a href='compte_visiteur.php?deconnexion=true'><span>Déconnexion</span></a>
            <?php
                session_start();
                if(isset($_GET['deconnexion']))
                { 
                   if($_GET['deconnexion']==true)
                   {  
                      session_unset();
                      header("location:login.php");
                   }
                }
                else if($_SESSION['pseudo'] !== ""){
                    $user = $_SESSION['pseudo'];
                    // afficher un message
                    echo "Bonjour $user, vous êtes connecté comme admin";
                }

                
                    
                
            ?>
            
        </div>
    </body>
</html>