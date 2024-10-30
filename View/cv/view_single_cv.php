<?php
session_start();
$pdo = require __DIR__ . '/../../config/database.php'; // Chemin mis à jour

if (!isset($_SESSION['user_id'])) {
    header('Location: /../View/auth/login.php');
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de CV manquant.");
}

$cv_id = $_GET['id'];
$query = "SELECT * FROM cvs WHERE id = :id AND user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $cv_id, PDO::PARAM_INT);
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$cv = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cv) {
    die("CV non trouvé.");
}

// Décoder les champs JSON
$career = json_decode($cv['career'], true);
$education = json_decode($cv['education'], true);
$skills = json_decode($cv['skills'], true);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../public/styles/view_cv.css">
    <title>Voir le CV</title>
</head>
<?php include __DIR__ . "/../../View/partials/header.php"; ?>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($cv['title']); ?></h1>
        <p><strong>Nom:</strong> <?php echo htmlspecialchars($cv['first_name'] . ' ' . $cv['last_name']); ?></p>
        <p><strong>Date de naissance:</strong> <?php echo htmlspecialchars($cv['birth_date']); ?></p>
        <p><strong>Téléphone:</strong> <?php echo htmlspecialchars($cv['phone']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($cv['email']); ?></p>
        <p><strong>Passions:</strong> <?php echo htmlspecialchars($cv['passions']); ?></p>
        <h2>Carrière</h2>
        <ul>
            <?php foreach ($career as $item): ?>
                <li><?php echo htmlspecialchars($item); ?></li>
            <?php endforeach; ?>
        </ul>
        <h2>Éducation</h2>
        <ul>
            <?php foreach ($education as $item): ?>
                <li><?php echo htmlspecialchars($item); ?></li>
            <?php endforeach; ?>
        </ul>
        <h2>Compétences</h2>
        <ul>
            <?php foreach ($skills as $item): ?>
                <li><?php echo htmlspecialchars($item); ?></li>
            <?php endforeach; ?>
        </ul>
        <div class="buttons">
            <a href="edit_cv.php?id=<?php echo $cv_id; ?>" class="btn-primary">Modifier</a>
            <form method="POST" action="/../View/cv/delete_cv.php" style="display:inline;">
                <input type="hidden" name="cv_id" value="<?php echo $cv_id; ?>">
                <button type="submit" name="delete_cv" class="btn-delete">Supprimer</button>
            </form>
            <a href="/../app/Services/edit_style_pdf.php?id=<?php echo $cv_id; ?>" class="btn-primary">Télécharger en PDF</a>
        </div>
    </div>
    <?php include __DIR__ . "/../../View/partials/footer.php"; ?>
</body>
</html>