<!DOCTYPE html>
<?php
session_start();

$pdo = new PDO('mysql:host=localhost;dbname=espace_formation', 'root', 'root');

if(isset($_GET['id']) AND $_GET['id'] > 0) {
    $get_id = intval($_GET['id']);
    $req_user = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $req_user->execute(array($get_id));
    $user_info = $req_user->fetch(PDO::FETCH_ASSOC);
  
?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.css" />
  <title>Profile</title>
</head>

<body>
  <div class="parent">
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
      Pseudo: <b><?php echo $user_info['username'] ?></b>
      <br />
      Mail: <b><?php echo $user_info['email'] ?></b>
      <br />
      Type: <b><?php echo $user_info['type'] ?></b>
      <br />
      <?php
    if(isset($_SESSION['id']) AND $user_info['id'] == $_SESSION['id']) {
      ?>
      <br />
      <button class="btn "><a href="edit_profil.php?id=<?php echo $_SESSION['id'] ?>">Editer mon
          profil</a></button><br />
      <button class="btn"><a href="deconnexion.php?id=<?php echo $_SESSION['id'] ?>">Se
          deconnecter</a></button><br />
      <?php
    }
    ?>
      <?php
    if(isset($_SESSION['id']) AND $user_info['type'] == 'administrateur') {
    ?>
      <button type="button" class="btn"><a href="add_user.php">Ajouter un
          apprenant/instructeur</a></button><br />
      <?php
    }
    ?>

    </div>


  </div>
  <?php
    }
    else {
    header("Location: connexion.php");
    }
    ?>
</body>

</html>