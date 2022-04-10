<!DOCTYPE html>

<?php
session_start();

$pdo = new PDO('mysql:host=localhost;dbname=espace_formation', 'root', 'root');

if(isset($_GET['id']) AND $_GET['id'] > 0) {
    $get_id = intval($_GET['id']);
    $req_user = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $req_user->execute(array($get_id));
    $user_info = $req_user->fetch();
  
?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/style.css" />
  <title>Profile</title>
</head>

<body>

  <div class="container">
    <h2>Profile de <?php echo $user_info['username'] ?> </h2>
    <?php 
    if(!empty($user_info['photo_profil'])) {
    ?>
    <img src="./utilisateurs/profil/<?php echo $user_info['photo_profil']; ?>" width="100" />
    <?php
  }
  ?>
    <br />
    Pseudo = <?php echo $user_info['username'] ?>
    <br />
    Mail = <?php echo $user_info['email'] ?>
    <br />
    Type = <?php echo $user_info['type'] ?>
    <br />
    <?php
    if(isset($_SESSION['id']) AND $user_info['id'] == $_SESSION['id']) {
      ?>
    <a href="edit_profil.php?id=<?php echo $_SESSION['id'] ?>">Editer mon profil</a><br />
    <a href="deconnexion.php?id=<?php echo $_SESSION['id'] ?>">Se deconnecter</a>
    <?php
    }
    ?>
  </div>
  <h1 align="center">Profile</h1>
</body>

</html>
<?php
}
else {
  header("Location: index.php");
}
?>
</div>
<div class="sucess">
  <h1>Bienvenue <?php echo $_SESSION['username']; ?>!</h1>
  <p>C'est votre espace Administrateur.</p>
  <a href="add_user.php">Ajouter un apprenant/instructeur</a> |
  <a href="../instructeur/index.php">Page Instructeur</a> |
  <a href="../apprenant/index.php">Page Apprenant</a> |
  <a href="../config/logout.php">Déconnexion</a>

</div>