<?php
session_start();
$pdo = require __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /../View/auth/login.php');
    exit();
}

if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    die("ID de l'utilisateur manquant.");
}

$user_id = $_GET['user_id'];
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
    <link rel="stylesheet" href="/../public/styles/view_project.css">
    <title>Voir les projets de l'utilisateur</title>
</head>
<?php include __DIR__ . "/../../View/partials/admin_header.php"; ?>
<body>
    <div class="container">
        <h1>Voir les projets de l'utilisateur</h1>
        <?php if (count($projects) > 0): ?>
            <ul>
                <?php foreach ($projects as $project): ?>
                    <li>
                        <h2><?php echo htmlspecialchars($project['title']); ?></h2>
                        <p><?php echo htmlspecialchars($project['description']); ?></p>
                        <p>Créé le : <?php echo htmlspecialchars($project['created_at']); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Cet utilisateur n'a pas encore créé de projets.</p>
        <?php endif; ?>
    </div>
    <?php include __DIR__ . "/../../View/partials/footer.php"; ?>
</body>
</html>