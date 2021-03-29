<?php
  require_once '../DataBase/config.php';
  selectAll($bdd , 'countries');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Pays</title>
  </head>
  <body>
    <?php require '../Components/NavBar.php'; ?>
    <div>
        <form action="../DataBase/config.php" method="POST">
            <h1>Ajouter un pays</h1>
            <label><b>Nom du pays :</b></label>
            <input type="text" placeholder="Entrez le nom d'un pays" name="country" required>
            <input type="submit" name="addcountry">
        </form>
    </div>
    <div>
      <h2>Pays :</h2>
      <?php foreach ($_SESSION['countries'] as $cnts) { ?>
        <form action="../DataBase/config.php" method="POST">
          <input type="hidden" name="countryid" value="<?php echo $cnts['id']; ?>"/>
          <input type="text" name="newcountry" value="<?php echo $cnts['name']; ?>" required/>
          <input type="submit" name="updatecountry" value="Modifier"/>
          <input type="submit" name="deletecountry" value="Supprimer"/>
        </form>
      <?php } ?>
    </div>
  </body>
</html>
