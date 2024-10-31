<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /../View/auth/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../../public/styles/admin_header.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="/../app/Models/profile.php">Mode Utilisateur</a></li>
            <li><a href="/../app/controllers/admin_dashboard.php">Admin Dashboard</a></li>
        </ul>
    </nav>
</header>
</body>
</html>