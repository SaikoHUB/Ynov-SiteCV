<?php


$servername = "db";
$username = "root";
$password = "root";
$dbname = "portfolio";
try {
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    return $bdd;
    
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
    return "Connexion échouée";
}
?>