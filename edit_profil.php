<!DOCTYPE html>

<?php
session_start();

$pdo = new PDO('mysql:host=localhost;dbname=espace_formation', 'root', 'root');

if(isset($_SESSION['id'])) {
  $req_user = $pdo->prepare('SELECT * FROM users WHERE id = ?');
  $req_user->execute(array($_SESSION['id']));
  $user_info = $req_user->fetch();

  if(isset($_POST['edit_new_username']) && !empty($_POST['edit_new_username']) && $_POST['edit_new_username'] != $user['edit_username']) {
    $edit_new_username = htmlspecialchars($_POST['edit_new_username']);
    $insert_username = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
    $insert_username->execute(array($edit_new_username, $_SESSION['id']));
    header('Location: profil.php?id='.$_SESSION['id']);
    
  }

  if(isset($_POST['edit_new_email']) && !empty($_POST['edit_new_email']) && $_POST['edit_new_email'] != $user['edit_email']) {
    $edit_new_email = htmlspecialchars($_POST['edit_new_email']);
    $insert_email = $pdo->prepare("UPDATE users SET email = ? WHERE id = ?");
    $insert_email->execute(array($edit_new_email, $_SESSION['id']));
    header('Location: profil.php?id='.$_SESSION['id']);
    
  }

  if(isset($_POST['edit_new_password']) && !empty($_POST['edit_new_password']) && isset($_POST['edit_password']) && !empty($_POST['edit_password'])) {
    $edit_password = sha1($_POST['edit_password']);
    $edit_new_password = sha1($_POST['edit_new_password']);

    if($edit_password == $user['password']) {
      $insert_password = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
      $insert_password->execute(array($edit_password, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
    }
    else {
      $message = "Votre mot de passe actuel est incorrect";
    }
if($email_exist == 0) {
    $edit_new_email = htmlspecialchars($_POST['edit_new_email']);
    $insert_email = $pdo->prepare("UPDATE users SET email = ? WHERE id = ?");
    $insert_email->execute(array($edit_new_email, $_SESSION['id']));
    header('Location: profil.php?id='.$_SESSION['id']);
    
  
  
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $req_edit_email = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $req_edit_email->execute(array($email));
    $email_exist = $req_edit_email->rowCount();
  
    
      $insert_email = $pdo->prepare("UPDATE users SET email = ? WHERE id = ?");
      $insert_email->execute(array($email, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
    }
    else {
      $message = "Cette adresse mail est déjà utilisée !";
    }
}}
else {
  $message = "Votre adresse mail n'est pas valide !";
}
}
else {
  header('Location: connexion.php');
}
if(isset($_POST['edit_new_username']) && $_POST['edit_new_username'] == $user['edit_username']) {
  header('Location: profil.php?id='.$_SESSION['id']);
}

if(isset($_FILES['photo_profil']) && !empty($_FILES['photo_profil']['name']) ) {
  $taille_max = 2097152;
  $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
  
  if($_FILES['photo_profil']['size'] <= $taille_max) {
    $extension_upload = strtolower(substr(strrchr($_FILES['photo_profil']['name'], '.'), 1));
    
    if(in_array($extension_upload, $extensions_valides)) {
      $chemin = "utilisateurs/profil/".$_SESSION['id'].".".$extension_upload;
      $resultat = move_uploaded_file($_FILES['photo_profil']['tmp_name'], $chemin);
      
      if($resultat) {
        $update_photo = $pdo->prepare('UPDATE users SET photo_profil = :photo_profil WHERE id = :id');
        $update_photo->execute(array(
          'photo_profil' => $_SESSION['id'].".".$extension_upload,
          'id' => $_SESSION['id']
        ));
        header('Location: profil.php?id='.$_SESSION['id']);
      }
      else {
        $message = "Erreur durant l'importation de votre photo de profil";
      }
    }
    else {
      $message = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
    }
  }
  else {
    $message = "Votre photo de profil ne doit pas dépasser 2Mo";
  }
}


 

?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/style.css" />
  <title>Edit Profile</title>
</head>

<body class="edit_profil_css">
  <div align="right">
    <h2>Edition du profile de <?php echo $user_info['username'] ?> </h2>

    <form method="POST" action="" enctype="multipart/form-data">
      <table>
        <tr>

          <td align="right">
            <label for="username">Pseudo: </label>
          </td>
          <td>
            <input type="text" name="edit_username" placeholder="Pseudo"
              value="<?php echo $user_info['username']; ?>" />
          </td>
        </tr>

        <td align="right">
          <label for="text">Nouveau Pseudo: </label>
        </td>
        <td>
          <input type="text" name="edit_new_username" placeholder="Nouveau pseudo" />
        </td>
        </tr>

        <td align="right">
          <label for="email">Email: </label>
        </td>
        <td>
          <input type="email" name="edit_email" placeholder="Email" value="<?php echo $user_info['email']; ?>" />
        </td>
        </tr>

        <td align="right">
          <label for="email">Nouvel Email: </label>
        </td>
        <td>
          <input type="email" name="edit_new_email" placeholder="Nouvel email" />
        </td>
        </tr>

        <td align="right">
          <label for="password">Mot de passe: </label>
        </td>
        <td>
          <input type="password" name="edit_password" placeholder="Mot de passe" />
        </td>
        </tr>

        <td align="right">
          <label for="conf_password">Nouveau Mot de passe: </label>
        </td>
        <td>
          <input type=" password" name="edit_new_password" placeholder="Nouveau Mot de passe" />
        </td>
        </tr>

        <td align="right">
          <label for="file">Photo de Profile: </label>
        </td>
        <td>
          <input type="file" name="photo_profil" />
        </td>
        </tr>

        <tr>
          <td class="input_submit">
            <input type="submit" value="Mettre à jour">
          </td>
        </tr>
      </table>
    </form>
    <?php 
    if(isset($message)) {
      echo $message;
    }
    ?>
  </div>
</body>

</html>