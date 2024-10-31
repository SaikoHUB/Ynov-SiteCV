<?php
session_start();
$pdo = require __DIR__ . '/../../config/database.php'; 

if (!isset($_SESSION['user_id'])) {
    header('Location: /../View/auth/login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cv_id = $_POST['cv_id'];
    $user_id = $_SESSION['user_id'];

    // Supprimer le CV
    $query = "DELETE FROM cvs WHERE id = :id AND user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $cv_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: /../app/Models/cv.php');
    exit();
}
?>