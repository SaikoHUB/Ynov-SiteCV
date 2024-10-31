<?php
session_start();
$pdo = require __DIR__ . '/../../config/database.php'; 

// Vérif admin connect
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /../View/auth/login.php');
    exit();
}

if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    die("ID de l'utilisateur manquant.");
}

$user_id = $_GET['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['delete_cv_id'])) {
        $cv_id = $_POST['delete_cv_id'];
        $query = "DELETE FROM cvs WHERE id = :id AND user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $cv_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    } elseif (isset($_POST['cv_id'])) {
        $cv_id = $_POST['cv_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $profile_picture = $_POST['profile_picture'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $birth_date = $_POST['birth_date'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $passions = $_POST['passions'];
        $career = json_encode($_POST['career']);
        $education = json_encode($_POST['education']);
        $skills = json_encode($_POST['skills']);

        $query = "UPDATE cvs SET title = :title, description = :description, profile_picture = :profile_picture, first_name = :first_name, last_name = :last_name, birth_date = :birth_date, phone = :phone, email = :email, passions = :passions, career = :career, education = :education, skills = :skills WHERE id = :id AND user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':profile_picture', $profile_picture);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':birth_date', $birth_date);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':passions', $passions);
        $stmt->bindParam(':career', $career);
        $stmt->bindParam(':education', $education);
        $stmt->bindParam(':skills', $skills);
        $stmt->bindParam(':id', $cv_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    }
}

$query = "SELECT * FROM cvs WHERE user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$cvs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier CV de l'utilisateur</title>
    <link rel="stylesheet" href="/../public/styles/edit_user_cv.css">
</head>
<body>
    <div class="container">
        <?php include __DIR__ . "/../../View/partials/admin_header.php"; ?>
        <h1>Modifier CV de l'utilisateur</h1>
        <?php foreach ($cvs as $cv): ?>
        <form method="POST" action="edit_user_cv.php?user_id=<?php echo $user_id; ?>">
            <input type="hidden" name="cv_id" value="<?php echo $cv['id']; ?>">
            <label for="title">Titre:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($cv['title']); ?>" required>
            <br>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($cv['description']); ?></textarea>
            <br>
            <label for="profile_picture">Photo de profil:</label>
            <input type="text" id="profile_picture" name="profile_picture" value="<?php echo htmlspecialchars($cv['profile_picture']); ?>">
            <br>
            <label for="first_name">Prénom:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($cv['first_name']); ?>" required>
            <br>
            <label for="last_name">Nom:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($cv['last_name']); ?>" required>
            <br>
            <label for="birth_date">Date de naissance:</label>
            <input type="date" id="birth_date" name="birth_date" value="<?php echo htmlspecialchars($cv['birth_date']); ?>" required>
            <br>
            <label for="phone">Téléphone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($cv['phone']); ?>" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($cv['email']); ?>" required>
            <br>
            <label for="passions">Passions:</label>
            <textarea id="passions" name="passions" required><?php echo htmlspecialchars($cv['passions']); ?></textarea>
            <br>
            <label for="career">Carrière:</label>
            <textarea id="career" name="career[]" required><?php echo htmlspecialchars(implode("\n", json_decode($cv['career'], true))); ?></textarea>
            <br>
            <label for="education">Éducation:</label>
            <textarea id="education" name="education[]" required><?php echo htmlspecialchars(implode("\n", json_decode($cv['education'], true))); ?></textarea>
            <br>
            <label for="skills">Compétences:</label>
            <textarea id="skills" name="skills[]" required><?php echo htmlspecialchars(implode("\n", json_decode($cv['skills'], true))); ?></textarea>
            <br>
            <button type="submit">Mettre à jour</button>
        </form>
        <form method="POST" action="edit_user_cv.php?user_id=<?php echo $user_id; ?>" onsubmit="return confirm('Voulez-vous vraiment supprimer ce CV ?');">
            <input type="hidden" name="delete_cv_id" value="<?php echo $cv['id']; ?>">
            <button type="submit">Supprimer</button>
        </form>
        <hr>
        <?php endforeach; ?>
    </div>
</body>
</html>