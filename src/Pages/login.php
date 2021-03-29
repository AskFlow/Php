<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
       <meta charset="utf-8">
       <title>Connexion</title>
    </head>
    <body>
      <?php require '../Components/NavBar.php'; ?>
        <div id="container">
            <form action="../DataBase/config.php" method="POST">
                <h1>Connexion</h1>
                <label><b>Nom d'utilisateur</b></label>
                <input type="text" placeholder="Entrer votre email" name="mail" required>
                <label><b>Mot de passe</b></label>
                <input type="password" placeholder="Entrer le mot de passe" name="password" required>
                <input type="submit" name='login' >
            </form>
        </div>
    </body>
</html>
