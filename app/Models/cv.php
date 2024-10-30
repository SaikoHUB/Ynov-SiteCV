<?php
session_start();
include __DIR__ . '/../../View/partials/header.php'; // Inclusion de l'en-tête
$pdo = require __DIR__ . '/../../config/database.php'; // Connexion à la base de données

// Vérification de la session utilisateur
if (!isset($_SESSION['user_id'])) {
    header("Location: /../View/auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupération des CV de l'utilisateur
$sql = "SELECT * FROM cvs WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$cvs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes CV</title>
    <link rel="stylesheet" href="/../public/styles/cv.css">
</head>
<body>
    <div class="container">
        <h1>Mes CV</h1>
        <div class="buttons">
            <a href="/../View/cv/create_cv.php" class="btn">Créer un nouveau CV</a>
        </div>
        <?php if (count($cvs) > 0): ?>
            <ul>
                <?php foreach ($cvs as $cv): ?>
                    <li>
                        <h2><?php echo htmlspecialchars($cv['title']); ?></h2>
                        <p><?php echo htmlspecialchars($cv['description']); ?></p>
                        <p>Créé le : <?php echo htmlspecialchars($cv['created_at']); ?></p>
                        <a href="/../View/cv/view_single_cv.php?id=<?php echo $cv['id']; ?>" class="btn">Voir le CV</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Vous n'avez pas encore créé de CV.</p>
        <?php endif; ?>
    </div>
    <?php include __DIR__ . '/../../View/partials/footer.php'; ?>
</body>
</html>