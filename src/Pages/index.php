<?php
require_once '../DataBase/config.php';
lastArticle($bdd, 'articles');
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="../Css/index.css">
      <title>Accueil</title>
  </head>
  <body>
    <?php require '../Components/NavBar.php'; ?>
    <h1>Dernier article publié :</h1>
    <div>
      <h3><?= $_SESSION['articles']['title']; ?><h3>
      <p>Article publié le : <?= $_SESSION['articles']['publication_date'] ?> </br> Date voyage : <?= $_SESSION['articles']['content_date'] ?> </br> Contenue : <?= $_SESSION['articles']['content'] ?></p>
    </div>
    <h2>S'abonner à la newsletter :</h2>
    <form action="../DataBase/config.php" method="post">
      <input type="text" name="email" placeholder="Adresse e-mail"/>
      <input type="submit" name="newsletter">
    </form>
  </body>
</html>
