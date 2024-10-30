<?php
session_start();
// Inclure le fichier database.php pour la connexion à la base de données
$pdo = require __DIR__ . '/../../config/database.php'; // Chemin mis à jour

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: /../View/auth/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $project_id = $_POST['project_id'];
    // Supprimer le projet de la base de données
    $query = "DELETE FROM projects WHERE id = ? AND user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$project_id, $user_id]);
    if ($stmt->rowCount() > 0) {
        header('Location: /../app/Models/projects.php');
        exit();
    } else {
        echo "Erreur lors de la suppression du projet.";
    }
}
?>