<?php
session_start();
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pdo = require __DIR__ . '/../../config/database.php';
    
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":email", $_POST["email"], PDO::PARAM_STR);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($_POST["password"], $user["password"])) {
        session_regenerate_id();
        $_SESSION["user_id"] = $user["id"];
        header("Location: /../public/index.php");
        exit();
    } else {
        $is_invalid = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>LogIn Page</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/../public/styles/index.css">
  <style>
    .button-container {
      display: flex;
      justify-content: center;
      gap: 10px;
    }
  </style>
</head>
<body>
  <h1>LogIn Page</h1>

  <?php if ($is_invalid): ?>
  <p>Invalid Email or Password</p>
  <?php endif; ?>

  <form method="post">
    <input autocomplete="off" type="email" placeholder="Email" name="email" id="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
    <br><br>
    <input autocomplete="off" type="password" placeholder="Password" name="password" id="password">
    <br><br>
    <div class="button-container">
      <button>Login</button>
      <a href="/../View/auth/signup.php" class="btn">Sign Up</a>
    </div>
  </form>
</body>
</html>