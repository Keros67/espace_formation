<!DOCTYPE html>

<?php
session_start();

$pdo = new PDO('mysql:host=localhost;dbname=espace_formation', 'root', 'root');

if(isset($_POST['inscriptionform'])) {
  
$username = htmlspecialchars($_POST['username']);
$email = htmlspecialchars($_POST['email']);
$password = sha1($_POST['password']);
  if(!empty($username) && !empty($password)) {
    
    $req_user = $pdo->prepare("SELECT * FROM users WHERE username = ? && password = ? && email = ?", array($username, $password, $email));
    $req_user->execute(array($username, $password, $email));
    $user_exist = $req_user->rowCount();
    
    if($user_exist == 1) {
      
      $_SESSION['username'] = $username;
      header('Location: index.php');
      if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $req_email = $pdo->prepare("SELECT * FROM users WHERE email = ?", array($email));
        $req_email->execute(array($email));
        $email_exist = $req_email->rowCount();
        if($email_exist == 1) {
          $message = "Cette adresse mail est déjà utilisée !";
        }
      }
      else{
        $message = "Votre adresse mail n'est pas valide !";
      }
      $user_infos = $req_user->fetch();
      $_SESSION['id'] = $user_infos['id'];
      $_SESSION['username'] = $user_infos['username'];
      $_SESSION['email'] = $user_infos['email'];
      header("Location: profil.php?id=".$_SESSION['id']);
    }
    else {
      $message = "Mauvais identifiant ou mot de passe !";
    }
  }else {
    $message = "Tous les champs doivent être complétés !";
  }
  }

?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/style.css" />

  <title>Connexion</title>
</head>

<body>
  <div class="parent">
    <div class="container">
      <h2>Connexion</h2>
      <form method="POST" action="" class="connexion_form">
        <table>
          <tr>

            <td>
              <input type="text" placeholder="Pseudo" id="username" name="username"
                value="<?php if(isset($username)) { echo $username; } ?>" />
            </td>
          </tr>

          <td>
            <input type="email" placeholder="Email" id="email" name="email" />
          </td>
          </tr>

          <td>
            <input type="password" placeholder="Mot de passe" id="password" name="password" />
          </td>
          </tr>

          <tr>
            <td class="input_submit">
              <input type="submit" name="inscriptionform" value="Se connecter" />
            </td>
          </tr>
        </table>
      </form>
      <p class="box-register">Nouveau ici ? <a href="inscription.php">S'inscrire</a></p>
      <?php
    if (isset($message)){
      echo '<font color="red">'.$message.'</font>';
    }
    ?>
    </div>
    <h1 align="center">Connexion</h1>
  </div>
</body>

</html>