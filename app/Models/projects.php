<?php
session_start();
$pdo = require __DIR__ . '/../../config/database.php'; // Chemin mis à jour

if (!isset($_SESSION['user_id'])) {
    header('Location: /../View/auth/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM projects WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../public/styles/project.css">
    <title>Mes Projets</title>
</head>
<header>
<?php include __DIR__ . "/../../View/partials/header.php"; ?>
</header>
<body>
    <h1>Mes Projets</h1>
    <a href="/../../View/project/create_projects.php">Ajouter un nouveau projet</a>
    <?php if (count($projects) > 0): ?>
        <ul>
            <?php foreach ($projects as $project): ?>
                <li>
                    <h2><?php echo htmlspecialchars($project['title']); ?></h2>
                    <p><?php echo htmlspecialchars($project['description']); ?></p>
                    <p>Créé le : <?php echo htmlspecialchars($project['created_at']); ?></p>
                    <p><?php echo $project['is_favorite'] ? "Favori" : ""; ?></p>
                    <p><?php echo $project['is_validated'] ? "Validé" : "En attente de validation"; ?></p>
                    <form method="POST" action="/../../View/project/delete_project.php">
                        <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
                        <button type="submit">Supprimer</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Vous n'avez pas encore ajouté de projets.</p>
    <?php endif; ?>
    <footer>
    <?php include __DIR__ . "/../../View/partials/footer.php"; ?>
    </footer>
</body>
</html>