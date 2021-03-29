<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="../Css/navbar.css">
   </head>
   <body>
      <nav class="menu">
        <ul>
           <li><a href="index.php">Accueil</a></li>
           <li><a href="articles?id=<?php echo $id = 0; ?>.php">Articles</a></li>
           <?php if(isset($_SESSION['user'])){ ?>
             <li><a href="pays.php">Pays</a></li>
             <li><a href="gestions.php">Gestion des articles</a></li>
           <?php } ?>
           <?php if(empty($_SESSION['user'])) {?>
            <li class="right"><a href="../Pages/login.php">Connexion</a></li>
           <?php } ?>
           <?php if(isset($_SESSION['user'])){?>
             <li class="right"><a href="../DataBase/logout.php">Deconnexion</a></li>
             <li class="right"><?= $_SESSION['user']['firstname'], " ", $_SESSION['user']['lastname']?></li>
           <?php } ?>
        </ul>
      </nav>
   </body>
</html>
