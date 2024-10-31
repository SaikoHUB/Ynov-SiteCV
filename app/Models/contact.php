<?php
session_start();
$pdo = require __DIR__ . '/../../config/database.php'; 


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id']; 
    $message = htmlspecialchars($_POST['message']);

    $query = "INSERT INTO messages (user_id, content) VALUES (:user_id, :content)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':content', $message);
    $stmt->execute();

    header('Location: /../app/models/profile.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="/../public/styles/contact.css">
</head>
<body>
<?php include __DIR__ . '/../../View/partials/header.php'; ?>
    </header>

    <form action="" method="POST">
        <label for="message">Message :</label>
        <textarea id="message" name="message" required></textarea>
        <button type="submit">Envoyer</button>
    </form>
    <?php include __DIR__ . '/../../View/partials/footer.php'; ?>
</body>
</html>