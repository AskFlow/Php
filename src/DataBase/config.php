<?php session_start();
$bdd = new PDO(
 'mysql:host=localhost;dbname=sitevoyage;',
 'root',
 '',
 array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
);
$bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);

function selectAll($bdd, $table) {
  $sql = "SELECT * FROM $table";
  $pre = $bdd->prepare($sql);
  $pre->execute();
  $_SESSION[$table] = $pre->fetchAll();
}

function selectAllWhithIdFetchAll($bdd, $table, $id) {
  $sql = "SELECT * FROM $table WHERE country_id = ?";
  $pre = $bdd->prepare($sql);
  $pre->execute(array($id));
  $_SESSION[$table] = $pre->fetchAll();
}

function selectAllWhithIdFetch($bdd, $table, $id) {
  $sql = "SELECT * FROM $table WHERE id = ?";
  $pre = $bdd->prepare($sql);
  $pre->execute(array($id));
  $_SESSION[$table] = $pre->fetch();
}

function allWithIdFetch($bdd, $table) {
  $sql = "SELECT * FROM $table WHERE id = ?";
  $pre = $bdd->prepare($sql);
  $pre->execute(array($_GET['id']));
  $_SESSION[$table] = $pre->fetch();
}

function allWithIdFetchAll($bdd, $table) {
  $sql = "SELECT * FROM $table WHERE article_id = ?";
  $pre = $bdd->prepare($sql);
  $pre->execute(array($_GET['id']));
  $_SESSION[$table] = $pre->fetchAll();
}

function lastArticle($bdd, $table) {
  $sql = "SELECT * FROM $table ORDER BY id DESC LIMIT 1";
  $pre = $bdd->prepare($sql);
  $pre->execute();
  $_SESSION[$table] = $pre->fetch();
}

// Connexion de l'administrateur
if(isset($_POST['login'])) {
    if(empty($_POST['mail'])) {
        echo "Le champ Mail est vide.";
    } elseif(empty($_POST['password']))  {
      echo "Le champ Mot de passe est vide.";
    } else {
            $mail = htmlentities($_POST['mail'], ENT_QUOTES, "ISO-8859-1");
            $password = htmlentities($_POST['password'], ENT_QUOTES, "ISO-8859-1");
            $sql ="SELECT * FROM admin WHERE mail = '".$mail."' AND password = '".md5($password)."'";
            $pre = $bdd->prepare($sql);
            $pre->execute();
            $user = $pre->fetch();
            if(empty($user)){
              header("Location:../Pages/login.php");
            } else {
              $_SESSION['user'] = $user;
              setcookie('mail', $user['mail'], time() + 365*24*3600, null, null, false, true);
              if (isset($_COOKIE['mail']))
                   {
                     $_SESSION['mail'] = $_COOKIE['mail'];
                   }
                   header("Location:../Pages/index.php");
                 }
        }
    }

//Ajouter un pays
if(isset($_POST['addcountry'])) {
  $country = htmlentities($_POST['country'], ENT_QUOTES, "ISO-8859-1");
  $adminid = $_SESSION['user']['id'];
  $sql = "INSERT INTO countries(name, admin_id) VALUES ('".$country."','".$adminid."')";
  $pre = $bdd->prepare($sql);
  $pre->execute();
  header("Location: ../Pages/pays.php");
}

//Modifier un pays
if(isset($_POST['updatecountry'])) {
  $newcountry = htmlentities($_POST['newcountry'], ENT_QUOTES, "ISO-8859-1");
  $insert = $bdd->prepare("UPDATE countries SET name = ? WHERE id = ?");
  $insert->execute(array($newcountry, $_POST['countryid']));
  header("Location: ../Pages/pays.php");
}

//Supprimer un pays
if(isset($_POST['deletecountry'])) {
  $pre = $bdd->prepare("SELECT * FROM articles WHERE country_id = ?");
  $pre->execute(array($_POST['countryid']));
  $articles = $pre->fetchAll();
  if(empty($articles)){
    $delete = $bdd->prepare("DELETE FROM countries WHERE id = ?");
    $delete->execute(array($_POST['countryid']));
  }else{
    foreach($articles as $article){
        $delete = $bdd->prepare("DELETE FROM comments WHERE article_id = ?");
        $delete->execute(array($article['id']));
        $delete = $bdd->prepare("DELETE FROM articles WHERE id = ?");
        $delete->execute(array($article['id']));
  }
    $delete = $bdd->prepare("DELETE FROM countries WHERE id = ?");
    $delete->execute(array($_POST['countryid']));
  }
  header("Location: ../Pages/pays.php");
}

//Créer un article
if(isset($_POST['addarticle'])) {
  $image = "../Upload/".$_FILES['image']['name'];
  move_uploaded_file($_FILES['image']['tmp_name'], $image);
  $image = substr($image,3);
  $title = htmlentities($_POST['title'], ENT_QUOTES, "ISO-8859-1");
  $content = htmlentities($_POST['content'], ENT_QUOTES, "ISO-8859-1");
  $contentdate = htmlentities($_POST['contentdate'], ENT_QUOTES, "ISO-8859-1");
  $countryid = $_POST['country'];
  $adminid = $_SESSION['user']['id'];
  $sql = "INSERT INTO articles(title,image,content,content_date,country_id,admin_id) VALUES ('".$title."','../".$image."','".$content."','".$contentdate."','".$countryid."','".$adminid."')";
  $pre = $bdd->prepare($sql);
  $pre->execute();
  $pre = $bdd->prepare("SELECT * FROM newsletter");
  $pre->execute();
  $emails = $pre->fetchAll();
  foreach ($emails as $eml) {
    $email = $eml['email'];
    $objet = "Nouvel article";
    $content = "Un nouvel article a été publié sur notre site !";
    $headers = array(
        'MIME-Version' => 'MIME Version 1.0',
        'Content-type' => 'text/html; charset=utf8',
        'From' => 'support@travel.com'
      );
      if(mail($email,$objet,$content,$headers)) {

      } else{

     }
  }
  header("Location: ../Pages/gestions.php");
}

//Modifier un article
if(isset($_POST['updatearticle'])) {
  $title = htmlentities($_POST['title'], ENT_QUOTES, "ISO-8859-1");
  $content = htmlentities($_POST['content'], ENT_QUOTES, "ISO-8859-1");
  $contentdate = htmlentities($_POST['contentdate'], ENT_QUOTES, "ISO-8859-1");
  $sql = "UPDATE articles SET title = ?, content = ?,content_date = ? WHERE id = ?";
  $pre = $bdd->prepare($sql);
  $pre->execute(array($title, $content, $contentdate,$_POST['articleid']));
  header("Location: ../Pages/gestions.php");
}

//Supprimer un article
if(isset($_POST['deletearticle'])) {
  $pre = $bdd->prepare("SELECT * FROM comments WHERE article_id = ?");
  $pre->execute(array($_POST['articleid']));
  $comments = $pre->fetchAll();
  if(empty($comments)){
    $delete = $bdd->prepare("DELETE FROM articles WHERE id = ?");
    $delete->execute(array($_POST['articleid']));
  } else {
    foreach($comments as $comment){
        $delete = $bdd->prepare("DELETE FROM comments WHERE article_id = ?");
        $delete->execute(array($comment['article_id']));
  }
    $delete = $bdd->prepare("DELETE FROM articles WHERE id = ?");
    $delete->execute(array($_POST['articleid']));
  }
  header("Location: ../Pages/gestions.php");
}

//Créer un avis
if(isset($_POST['addcomment'])) {
  $username = htmlentities($_POST['username'], ENT_QUOTES, "ISO-8859-1");
  $content = htmlentities($_POST['content'], ENT_QUOTES, "ISO-8859-1");
  $articleid = $_POST['articleid'];
  $sql = "INSERT INTO comments(username,content,article_id) VALUES('".$username."','".$content."','".$articleid."')";
  $pre = $bdd->prepare($sql);
  $pre->execute();
  header("Location: ../Pages/Article_Avis.php?id=$articleid");
}

//Ajouter email à la newsletter
if(isset($_POST['newsletter'])) {
  $email = htmlentities($_POST['email'], ENT_QUOTES, "ISO-8859-1");
  $sql = "INSERT INTO newsletter(email) VALUES('".$email."')";
  $pre = $bdd->prepare($sql);
  $pre->execute();
  header("Location: ../Pages/index.php");
}

//Aller voir les articles d'un pays
if (isset($_POST['checkcountry'])) {
  $countryid = $_POST['country'];
  header("Location: ../Pages/articles.php?id=$countryid");
}
