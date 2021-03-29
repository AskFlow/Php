<?php
  require_once '../DataBase/config.php';
  selectAll($bdd , 'articles');
  selectAll($bdd , 'countries');
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Gestions des articles</title>
  </head>
  <body>
    <?php require '../Components/NavBar.php'; ?>
    <div>
        <form action="../DataBase/config.php" method="POST" enctype="multipart/form-data">
            <h1>Ajouter un article :</h1>
            <input type="file" name="image"/>
            <input type="text" placeholder="Titre" name="title" required/>
            <input type="text" placeholder="Contenue" name="content" required/>
            <select name="country">
              <?php foreach ($_SESSION['countries'] as $cnts) { ?>
                <option value="<?php echo $cnts['id']; ?>"><?php echo $cnts['name']; ?></option>
              <?php } ?>
            </select>
            <input type="date" name="contentdate" min="1980-01-01" required/>
            <input type="submit" name="addarticle">
        </form>
    </div>
    <div>
      <h2>Articles :</h2>
      <?php foreach ($_SESSION['articles'] as $artcl) { ?>
        <form action="../DataBase/config.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="articleid" value="<?php echo $artcl['id']; ?>"/>
          <input type="file" name="image"/>
          <input type="text" name="title" value="<?php echo $artcl['title']; ?>" required/>
          <input type="text" name="content" value="<?php echo $artcl['content']; ?>" required/>
          <input type="date" value="<?php echo $artcl['content_date']; ?>" name="contentdate" min="1980-01-01" required/>
          <input type="submit" name="updatearticle" value="Modifier"/>
          <input type="submit" name="deletearticle" value="Supprimer"/>
        </form>
      <?php } ?>
    </div>
  </body>
</html>
