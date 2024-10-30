<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /../View/auth/login.php');
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de CV manquant.");
}

$cv_id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le style du PDF</title>
    <link rel="stylesheet" href="/../public/styles/cv.css">
</head>
<?php include __DIR__ . '/../../View/partials/header.php'; ?>
<body>
    <h1>Modifier le style du PDF</h1>
    <form method="POST" action="generate_pdf.php">
        <input type="hidden" name="id" value="<?= htmlspecialchars($cv_id) ?>">
        <label for="bg_color">Couleur de fond:</label>
        <input type="color" id="bg_color" name="bg_color" value="#ffffff">
        <br><br>
        <label for="text_color">Couleur du texte:</label>
        <input type="color" id="text_color" name="text_color" value="#000000">
        <br><br>
        <button type="submit">Générer le PDF</button>
    </form>
    <?php include __DIR__ . '/../../View/partials/footer.php'; ?>
</body>
</html>