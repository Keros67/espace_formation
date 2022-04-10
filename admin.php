<?php
// Initialiser la session
session_start();
// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if(!isset($_SESSION["username"])){
    header("Location: connexion.php");
    exit();
}
// récupérer tous les utilisateurs

$username = 'root';
$password = 'root';
$mysqlDsn = 'mysql:host=localhost:8889;dbname=espace_formation';
try{
    $pdo = new PDO($mysqlDsn, $username, $password);
    $query = 'SELECT * FROM users';
    $stmt = $pdo->query($query);

    if($stmt === false){
        die("Erreur");
    }

}catch (PDOException $e){
    echo $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css" />
  <title>Administrateur</title>
</head>

<body>
  <div class="sucess">
    <h1>Bienvenue <?php echo $_SESSION['username']; ?>!</h1>
    <p>C'est votre espace Administrateur.</p>
    <a href="add_user.php">Ajouter un apprenant/instructeur</a> |
    <a href="../instructeur/index.php">Page Instructeur</a> |
    <a href="../apprenant/index.php">Page Apprenant</a> |
    <a href="../config/logout.php">Déconnexion</a>

  </div>

  <ul class="nav justify-content-center">
    <li class="nav-item">
      <a class="nav-link active" aria-current="page" href="../pages/acceuil.html">Acceuil</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="../pages/Mes-services.html">Mes services</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="../pages/contact.html">Contact</a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
        aria-expanded="false">Menu+</a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="../pages/a-propos.html">À propos</a></li>
        <li><a class="dropdown-item" href="../pages/Mentions-legales.html">Mentions Légales</a></li>
        <li>
          <hr class="dropdown-divider">
        </li>
        <li><a class="dropdown-item" href="../pages/Politique-de-confidentialite.html">Politiques de confidentialité</a>
        </li>
      </ul>
    </li>
  </ul>
  <div>

    <h2>Liste des utilisateurs</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Type</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
        <tr>
          <td><?php echo htmlspecialchars($row['id']); ?></td>
          <td><?php echo htmlspecialchars($row['username']); ?></td>
          <td><?php echo htmlspecialchars($row['email']); ?></td>
          <td><?php echo htmlspecialchars($row['type']); ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>

</html>