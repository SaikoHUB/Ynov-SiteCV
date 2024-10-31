<?php
session_start();

// Connexion db
$pdo = require __DIR__ . '/../../config/database.php';

// Récup données form
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// valid form
if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    die("All fields are required.");
}
if ($password !== $confirm_password) {
    die("Passwords do not match.");
}

// Vérif emial
$sql = "SELECT COUNT(*) FROM users WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();
if ($stmt->fetchColumn() > 0) {
    die("Email already exists.");
}

// Hasher
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insér user
$sql = "INSERT INTO users (email, first_name, last_name, password, role) VALUES (:email, :first_name, :last_name, :password, 'user')";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':first_name', $username);
$stmt->bindParam(':last_name', $username);
$stmt->bindParam(':password', $hashed_password);

if ($stmt->execute()) {
    // Récup id user
    $user_id = $pdo->lastInsertId();

    // Créer session
    $_SESSION['user_id'] = $user_id;

    // Rediriger vers la page de index
    header("Location: /../public/index.php");
    exit();
} else {
    // error
    die("Error: " . $stmt->errorInfo()[2]);
}
?>