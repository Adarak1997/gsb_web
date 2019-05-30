<html>
    <head>
       <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />
        <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body style="background-color:#ccccff;">

        <div id="container-logo">
            <img class="logo" src="image/logo-gsb.png">
        </div>
        <div id="container">
            <!-- zone de connexion -->

            <form action="fonction/verification.php" method="POST">
                <center><h2>Connectez-vous !</h2></center><br>
                <div class="form-group">
                    <label for="exampleInputEmail1">Identifiant</label>
                    <input type="text" class="form-control" name="pseudo" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Mot de passe</label>
                    <input type="password" class="form-control" name="mdp" required>
                </div>
                <input type="submit" class="btn btn-primary" value="CONNEXION">
                <?php
                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1 || $err==2)
                        echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
                }
                ?>
            </form>
        </div>
    </body>
</html>