<?php
session_start();
$pdo = require __DIR__ . '/../../config/database.php'; 

// Vérif admin connect
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /../View/auth/login.php');
    exit();
}

if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    die("ID de l'utilisateur manquant.");
}

$user_id = $_GET['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['delete_project_id'])) {
        $project_id = $_POST['delete_project_id'];
        $query = "DELETE FROM projects WHERE id = :id AND user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $project_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    } elseif (isset($_POST['project_id'])) {
        $project_id = $_POST['project_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        

        $query = "UPDATE projects SET title = :title, description = :description WHERE id = :id AND user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $project_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    }
}

$query = "SELECT * FROM projects WHERE user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Projets de l'utilisateur</title>
    <link rel="stylesheet" href="/../public/styles/edit_user_project.css">
</head>
<body>
    <div class="container">
        <?php include __DIR__ . "/../../View/partials/admin_header.php"; ?>
        <h1>Modifier Projets de l'utilisateur</h1>
        <?php foreach ($projects as $project): ?>
        <form method="POST" action="edit_user_project.php?user_id=<?php echo $user_id; ?>">
            <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
            <label for="title">Titre:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($project['title']); ?>" required>
            <br>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($project['description']); ?></textarea>
            <br>
            <button type="submit">Mettre à jour</button>
        </form>
        <form method="POST" action="edit_user_project.php?user_id=<?php echo $user_id; ?>" onsubmit="return confirm('Voulez-vous vraiment supprimer ce projet ?');">
            <input type="hidden" name="delete_project_id" value="<?php echo $project['id']; ?>">
            <button type="submit">Supprimer</button>
        </form>
        <hr>
        <?php endforeach; ?>
    </div>
</body>
</html>