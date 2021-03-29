<?php require '../DataBase/config.php';
  $sql = "SELECT * FROM countries";
  $pre = $bdd->prepare($sql);
  $pre->execute();
  $countries = $pre->fetchAll();
?>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <title>Countries List</title>
    </head>
    <body>
      <?php require '../Components/NavBar.php'; ?>
      <h1>Choissisez un pays</h1>
      <div>
        <h2>Pays :</h2>
        <?php foreach ($countries as $cnts) { ?>
            <a href="article.php?id=<?= $cnts['id']; ?>"><?= $cnts['name']; ?></a>
        <?php } ?>
      </div>
    </body>
  </html>
