<?php
// Démarrer la session
session_start();

// Connexion à la base de données
$pdo = require __DIR__ . '/../../config/database.php';

// Récupérer les données du formulaire
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Valider les données du formulaire
if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    die("All fields are required.");
}
if ($password !== $confirm_password) {
    die("Passwords do not match.");
}

// Vérifier si l'email existe déjà
$sql = "SELECT COUNT(*) FROM users WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();
if ($stmt->fetchColumn() > 0) {
    die("Email already exists.");
}

// Hasher le mot de passe
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insérer l'utilisateur dans la base de données
$sql = "INSERT INTO users (email, first_name, last_name, password, role) VALUES (:email, :first_name, :last_name, :password, 'user')";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':first_name', $username);
$stmt->bindParam(':last_name', $username);
$stmt->bindParam(':password', $hashed_password);

if ($stmt->execute()) {
    // Récupérer l'ID de l'utilisateur nouvellement créé
    $user_id = $pdo->lastInsertId();

    // Créer une session pour l'utilisateur
    $_SESSION['user_id'] = $user_id;

    // Rediriger vers la page de index
    header("Location: /../public/index.php");
    exit();
} else {
    // Afficher un message d'erreur si l'insertion échoue
    die("Error: " . $stmt->errorInfo()[2]);
}
?>