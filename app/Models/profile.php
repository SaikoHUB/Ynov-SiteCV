<?php
session_start();
$pdo = require __DIR__ . '/../../config/database.php'; 
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Récup info usr
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Mot de passe
    $admin_password_input = $_POST['admin_password']; // Mot de passe admin

    // Vérif mdp
    $admin_password = 'admin123'; // MOT DE PASS ADMIN
    
    if (!empty($admin_password_input) && $admin_password_input === $admin_password) {
        $_SESSION['role'] = 'admin';
        header("Location: /../app/Controllers/admin_dashboard.php");
        exit();
    }

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, password = ? WHERE id = ?";
        $stmt = $pdo->prepare($update_query);
        $stmt->execute([$first_name, $last_name, $email, $hashed_password, $user_id]);
    } else {
        $update_query = "UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE id = ?";
        $stmt = $pdo->prepare($update_query);
        $stmt->execute([$first_name, $last_name, $email, $user_id]);
    }
    
    if ($stmt->rowCount() > 0) {
        echo "Les informations ont été mises à jour avec succès.";
    } else {
        echo "Erreur lors de la mise à jour des informations.";
    }
}

$query = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../public/styles/profile.css">
    <title>Profil utilisateur</title>
</head>
<body>
    <header>
    <?php include __DIR__ . "/../../View/partials/header.php"; ?>
    </header>
    <h1>Profil de <?php echo htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name']); ?></h1>
    
    <form method="POST" action="profile.php">
        <label for="first_name">Prénom:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
        <br>

        <label for="last_name">Nom:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
        <br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        <br>

        <label for="password">Mot de passe (laisser vide pour ne pas changer):</label>
        <input type="password" id="password" name="password">
        <br>

        <label for="admin_password">Mot de passe administrateur:</label>
        <input type="password" id="admin_password" name="admin_password">
        <br>

        <button type="submit">Mettre à jour</button>
    </form>

    <p>Date de création du compte : <?php echo htmlspecialchars($user['created_at']); ?></p>
    <p>Rôle : <?php echo htmlspecialchars($user['role']); ?></p>
    <footer>
    <?php include __DIR__ . "/../../View/partials/footer.php"; ?>
    </footer>
</body>
</html>