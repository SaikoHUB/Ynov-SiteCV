<?php
session_start();
$pdo = require __DIR__ . '/../../config/database.php'; // Chemin mis à jour

if (!isset($_SESSION['user_id'])) {
    header('Location: /../View/auth/login.php');
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de CV manquant.");
}

$cv_id = $_GET['id'];
$query = "SELECT * FROM cvs WHERE id = :id AND user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $cv_id, PDO::PARAM_INT);
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$cv = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cv) {
    die("CV non trouvé.");
}

// Décoder les champs JSON
$career = json_decode($cv['career'], true);
$education = json_decode($cv['education'], true);
$skills = json_decode($cv['skills'], true);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':profile_picture', $profile_picture, PDO::PARAM_STR);
    $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
    $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
    $stmt->bindParam(':birth_date', $birth_date, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':passions', $passions, PDO::PARAM_STR);
    $stmt->bindParam(':career', $career, PDO::PARAM_STR);
    $stmt->bindParam(':education', $education, PDO::PARAM_STR);
    $stmt->bindParam(':skills', $skills, PDO::PARAM_STR);
    $stmt->bindParam(':id', $cv_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: view_single_cv.php?id=$cv_id");
        exit();
    } else {
        echo "Erreur lors de la mise à jour du CV.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../public/styles/edit_cv.css">
    <title>Modifier le CV</title>
    <script>
        function addField(section) {
            const container = document.getElementById(section + '-container');
            const input = document.createElement('textarea');
            input.name = section + '[]';
            input.placeholder = 'Ajouter ' + section;
            container.appendChild(input);
        }
    </script>
</head>
<?php include __DIR__ . "/../partials/header.php"; ?>

<body>
    <h1>Modifier le CV</h1>
    <form method="POST" action="edit_cv.php?id=<?php echo $cv_id; ?>">
        <label for="title">Titre:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($cv['title']); ?>" required>
        <br>
        <label for="description">Description:</label>
        <textarea id="description" name="description"><?php echo htmlspecialchars($cv['description']); ?></textarea>
        <br>
        <label for="profile_picture">Photo de profil :</label>
        <input type="text" id="profile_picture" name="profile_picture" value="<?php echo htmlspecialchars($cv['profile_picture']); ?>">
        <br>
        <label for="first_name">Prénom:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($cv['first_name']); ?>">
        <br>
        <label for="last_name">Nom:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($cv['last_name']); ?>">
        <br>
        <label for="birth_date">Date de naissance:</label>
        <input type="date" id="birth_date" name="birth_date" value="<?php echo htmlspecialchars($cv['birth_date']); ?>">
        <br>
        <label for="phone">Téléphone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($cv['phone']); ?>">
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($cv['email']); ?>">
        <br>
        <label for="passions">Passions:</label>
        <textarea id="passions" name="passions"><?php echo htmlspecialchars($cv['passions']); ?></textarea>
        <br>
        <div id="career-container">
            <label for="career">Carrière :</label>
            <?php foreach ($career as $item): ?>
                <textarea name="career[]"><?php echo htmlspecialchars($item); ?></textarea>
            <?php endforeach; ?>
        </div>
        <button type="button" onclick="addField('career')">Ajouter une carrière</button>
        <br>
        <div id="education-container">
            <label for="education">Éducation :</label>
            <?php foreach ($education as $item): ?>
                <textarea name="education[]"><?php echo htmlspecialchars($item); ?></textarea>
            <?php endforeach; ?>
        </div>
        <button type="button" onclick="addField('education')">Ajouter une éducation</button>
        <br>
        <div id="skills-container">
            <label for="skills">Compétences :</label>
            <?php foreach ($skills as $item): ?>
                <textarea name="skills[]"><?php echo htmlspecialchars($item); ?></textarea>
            <?php endforeach; ?>
        </div>
        <button type="button" onclick="addField('skills')">Ajouter une compétence</button>
        <br>
        <button type="submit">Mettre à jour le CV</button>
    </form>
    <?php include __DIR__ . "/../partials/footer.php"; ?>
</body>
</html>