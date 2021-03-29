<?php require '../DataBase/config.php';
  selectAll($bdd, 'countries');
  selectAllWhithIdFetchAll($bdd, 'articles', $_GET['id']);
?>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="../Css/index.css">
      <title>Countries List</title>
    </head>
    <body>
      <?php require '../Components/NavBar.php'; ?>
      <h1>Choissisez un pays</h1>
      <div>
        <h2>Pays :</h2>
        <form action="../DataBase/config.php" method="post">
          <select name="country">
            <option value="">Choissisez un pays</option>
            <?php foreach ($_SESSION['countries'] as $cnts) { ?>
              <option <?php if($_GET['id'] == $cnts['id']) { echo 'selected="selected"'; } ?> value="<?php echo $cnts['id']; ?>"><?php echo $cnts['name'];?></option>
            <?php } ?>
          </select>
          <input type="submit" name="checkcountry" value="Valider">
        </form>
      </div>
      <div>
        <h2>Articles à propos de ce pays :</h2>
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
