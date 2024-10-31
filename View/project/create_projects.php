<?php
session_start();

$pdo = require __DIR__ . '/../../config/database.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: /../View/auth/login.php');
    exit();
}

// Récup id user
$user_id = $_SESSION['user_id'];

// Créer un nouveau projet
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $is_favorite = isset($_POST['is_favorite']) ? 1 : 0;
    
    $query = "INSERT INTO projects (user_id, title, description, is_favorite) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id, $title, $description, $is_favorite]);
    
    if ($stmt->rowCount() > 0) {
        header('Location: /../app/Models/projects.php'); 
        exit();
    } else {
        echo "Erreur lors de la création du projet.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../public/styles/project.css">
    <title>Créer un projet</title>
</head>
<?php include __DIR__ . "/../../View/partials/header.php"; ?>
<body>
    <h1>Créer un nouveau projet</h1>

    <form method="POST" action="/../View/project/create_projects.php">
        <label for="title">Titre:</label>
        <input type="text" id="title" name="title" required>
        <br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <br>

        <label for="is_favorite">Marquer comme favori:</label>
        <input type="checkbox" id="is_favorite" name="is_favorite">
        <br>

        <button type="submit">Créer le projet</button>
    </form>
  <?php include __DIR__ . "/../../View/partials/footer.php"; ?>
</body>
</html>