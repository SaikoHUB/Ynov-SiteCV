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
$query = "SELECT * FROM cvs WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$cvs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../public/styles/view_cv.css">
    <title>Voir les CV de l'utilisateur</title>
</head>
<?php include __DIR__ . "/../../View/partials/admin_header.php"; ?>
<body>
    <div class="container">
        <h1>Voir les CV de l'utilisateur</h1>
        <?php if (count($cvs) > 0): ?>
            <ul>
                <?php foreach ($cvs as $cv): ?>
                    <li>
                        <h2><?php echo htmlspecialchars($cv['title']); ?></h2>
                        <p><?php echo htmlspecialchars($cv['description']); ?></p>
                        <p>Créé le : <?php echo htmlspecialchars($cv['created_at']); ?></p>
                        <a href="view_single_cv.php?id=<?php echo $cv['id']; ?>" class="btn">Voir le CV</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Cet utilisateur n'a pas encore créé de CV.</p>
        <?php endif; ?>
    </div>
    <?php include __DIR__ . "/../../View/partials/footer.php"; ?>
</body>
</html>