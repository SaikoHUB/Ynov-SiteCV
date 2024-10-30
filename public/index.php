<?php
session_start();

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pdo = require __DIR__ . "/../config/database.php";
    
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":email", $_POST["email"], PDO::PARAM_STR);
    $stmt->execute();
    
    $user = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Connected</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <?php include __DIR__ . "/../View/partials/header.php"; ?>
  <?php include __DIR__ . "/../View/partials/footer.php"; ?>
</body>
</html>