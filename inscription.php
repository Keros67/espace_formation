<!DOCTYPE html>
<?php
session_start();

$pdo = new PDO('mysql:host=localhost;dbname=espace_formation', 'root', 'root');
  
/*if ($pdo->exec('CREATE DATABASE IF NOT EXISTS espace_formation')) {
  $pdo_create = "CREATE TABLE `espace_formation`.`users` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `username` VARCHAR(100) NOT NULL , `email` VARCHAR(100) NOT NULL , `password` TEXT NOT NULL , `type` VARCHAR(100) NOT NULL , `photo_profil` VARCHAR(255) , PRIMARY KEY (`id`))";
  $pdo->exec($pdo_create);
} else {*/
  
if(isset($_POST['inscriptionform'])) {
  
  $username = htmlspecialchars($_POST['username']);
  $email = htmlspecialchars($_POST['email']);
  $conf_mail = htmlspecialchars($_POST['conf_mail']);
  $password = sha1($_POST['password']);
  $default_type = 'apprenant';
  $conf_password = sha1($_POST['conf_password']);

  if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['conf_mail']) && !empty($_POST['password']) &&
  !empty($_POST['conf_password'])) {

    $username_length = strlen($username);
    if ($username_length <= 100) { 
    $req_username = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $req_username->execute(array($username));
    $username_exist = $req_username->rowCount();
      if($username_exist == 0) {

        if($email == $conf_mail) {

          if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $req_email = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $req_email->execute(array($email));
            $email_exist = $req_email->rowCount();

              if($email_exist == 0) {

                if($password == $conf_password) {
                  $insert_users = $pdo->prepare("INSERT INTO users(username, email, password, type, photo_profil) VALUES(?, ?, ?, ?, ?)");
                  $insert_users->execute(array($username, $email, $password, $default_type, "default.png"));
                  $_SESSION['compte_ok'] = "Votre compte a bien été créé !";
                  header('Location: connexion.php');

                }
                  else {
                    $message = "Vos mots de passe ne correspondent pas !";
                  }
                }
                  else {
                    $message = "Cette adresse mail est déjà utilisée !";
                  }
          }
            else {
              $message = "Votre adresse mail n'est pas valide !";
              }
          }
                else {
                  $message = "Vos adresses mail ne correspondent pas !";
                }
        }

        else {
          $message = "Ce nom d'utilisateur est déjà utilisé ! ";
        }
    }
        else {
          $message = "Votre nom d'utilisateur est trop long !";
        }
}
        else {
          $message = "Tous les champs doivent être complétés !";
        }
}
//}


?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/style.css" />
  <title>Inscription</title>
</head>

<body>
  <div class="parent">
    <div class="container">
      <h2>Inscription</h2>
      <form method="POST" action="">
        <table>
          <tr>
            <td>
              <input type="text" placeholder="Pseudo" id="username" name="username"
                value="<?php if(isset($username)) { echo $username; } ?>" />
            </td>
          </tr>

          <td>
            <input type="email" placeholder="Email" id="email" name="email"
              value="<?php if(isset($email)) { echo $email; } ?>" />
          </td>
          </tr>

          <td>
            <input type="email" placeholder="Confirmez votre mail" id="conf_mail" name="conf_mail"
              value="<?php if(isset($conf_mail)) { echo $conf_mail; } ?>" />
          </td>
          </tr>

          <td>
            <input type="password" placeholder="Mot de passe" id="password" name="password" />
          </td>
          </tr>

          <td>
            <input type="password" placeholder="Confirmez le mot de passe" id="conf_password" name="conf_password" />
          </td>
          </tr>

          <tr>
            <td class="input_submit">
              <input type="submit" name="inscriptionform" value="S'inscrire" />
            </td>
          </tr>
        </table>
      </form>
      <p class="box-register">Déja inscrit ? <a href="connexion.php">Se connecter</a></p>
      <?php
    if (isset($message)){
      echo '<font color="red">'.$message.'</font>';
    }
    ?>
    </div>
    <h1 align="center">Inscription</h1>
  </div>
</body>

</html>