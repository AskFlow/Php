<?php require '../DataBase/config.php';
  allWithIdFetchAll($bdd, 'comments');
  allWithIdFetch($bdd, 'articles');
  allWithIdFetch($bdd, 'countries');
?>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="../Css/index.css">
      <title>Article</title>
    </head>
    <body>
      <?php require '../Components/NavBar.php'; ?>
      <div>
        <h2><?= $_SESSION['articles']['title']; ?></h2>
        <img src="<?php echo $_SESSION['articles']['image'] ?>" class="imgarticle"/>
        <p>Article publié le : <?= $_SESSION['articles']['publication_date'] ?> </br> Date voyage: <?= $_SESSION['articles']['content_date'] ?> </br> Contenu: <?= $_SESSION['articles']['content'] ?></p>
      </div>
      <div>
        <form action="../DataBase/config.php" method="post">
            <h1>Ajouter un commentaire :</h1>
            <input type="hidden" name="articleid" value="<?php echo $_SESSION['articles']['id']; ?>"/>
            <input type="text" placeholder="Username" name="username" required/>
            <input type="text" placeholder="Content" name="content" required/>
            <input type="submit" name="addcomment">
        </form>
        <h1>Commentaires déjà publiés</h1>
        <?php foreach ($_SESSION['comments'] as $cmts) {?>
          <div>
            <h3><?php echo $cmts['username'] ?></h3>
            <p><?php echo $cmts['content'] ?></p>
            <p><?php echo $cmts['date'] ?></p>
          </div>
      <?php  } ?>
      </div>
    </body>
  </html>
