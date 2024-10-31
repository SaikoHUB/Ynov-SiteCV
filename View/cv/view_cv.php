<?php
session_start();
$pdo = require __DIR__ . '/../../config/database.php'; 

if (!isset($_SESSION['user_id'])) {
    header('Location: /../View/auth/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
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
    <link rel="stylesheet" href="styles/view_cv.css">
    <title>Voir mes CV</title>
</head>
<?php include __DIR__ . "/../partials/header.php"; ?>
<body>
    <div class="container">
        <h1>Voir mes CV</h1>
        <?php if (count($cvs) > 0): ?>
            <ul>
                <?php foreach ($cvs as $cv): ?>
                    <li>
                        <h2><?php echo htmlspecialchars($cv['title']); ?></h2>
                        <a href="view_single_cv.php?id=<?php echo $cv['id']; ?>" class="btn">Voir ce CV</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Vous n'avez pas encore créé de CV.</p>
        <?php endif; ?>
    </div>
  <?php include __DIR__ . "/../partials/footer.php"; ?>
</body>
</html>