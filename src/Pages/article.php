<?php
  require '../DataBase/config.php';
  selectAllWhithIdFetch($bdd, 'countries', $_GET['id']);
  selectAllWhithIdFetchAll($bdd, 'articles', $_GET['id']);
?>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="../Css/index.css">
      <title>Coutries Articles</title>
    </head>
    <body>
      <?php require '../Components/NavBar.php'; ?>
      <div>
        <h2>Articles à propos du pays : <?= $_SESSION['countries']['name'];?></h2>
        <?php foreach ($_SESSION['articles'] as $artc) { ?>
          <a href='Article_Avis.php?id=<?= $artc['id'] ?>'>
            <div class="container">
              <h3><?= $artc['title']; ?><h3>
                <p>Article publié le : <?= $artc['publication_date'] ?> </br> Date voyage: <?= $artc['content_date'] ?></p>
                </div>
          </a>
        <?php } ?>
      </div>
    </body>
  </html>
