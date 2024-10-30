<?php
session_start();
$pdo = require __DIR__ . '/../../config/database.php'; // Chemin mis à jour

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_name = htmlspecialchars($_POST['user_name']);
    $message = htmlspecialchars($_POST['message']);

    $query = "INSERT INTO messages (user_name, message) VALUES (:user_name, :message)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_name', $user_name);
    $stmt->bindParam(':message', $message);
    $stmt->execute();

    header('Location: /../app/Controllers/admin_dashboard.php');
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
    <header>
        <nav>
            <ul>
                <li><a href="/../app/Models/profile.php">Profile</a></li>
                <li><a href="/../app/Models/cv.php">CV</a></li>
                <li><a href="/../app/Models/projects.php">Mes projets</a></li>
                <li><a href="/../View/auth/logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h1>Contact</h1>
        <form method="POST" action="contact.php">
            <label for="user_name">Nom:</label>
            <input type="text" id="user_name" name="user_name" required>
            <br>
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>
            <br>
            <button type="submit">Envoyer</button>
        </form>
    </div>

    <footer>
        <p>Ynov-CV web</p>
        <p>
            <a href="about-us.php" style="color: white;">A propos</a> |
            <a href="/../app/Models/contact.php" style="color: white;">Contact</a>
        </p>
    </footer>
</body>
</html>