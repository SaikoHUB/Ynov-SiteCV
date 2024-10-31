<?php
session_start();
$pdo = require __DIR__ . '/../../config/database.php'; 

if (!isset($_SESSION['user_id'])) {
    header('Location: /../View/auth/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

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

    // Vérifier que la date de naissance n'est pas vide et est dans un format correct
    if (empty($birth_date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $birth_date)) {
        echo "Date de naissance invalide.";
        exit();
    }

    $query = "INSERT INTO cvs (user_id, title, description, profile_picture, first_name, last_name, birth_date, phone, email, passions, career, education, skills) VALUES (:user_id, :title, :description, :profile_picture, :first_name, :last_name, :birth_date, :phone, :email, :passions, :career, :education, :skills)";
    $stmt = $pdo->prepare($query); 
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
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

    if ($stmt->execute()) {
        $cv_id = $pdo->lastInsertId(); 
        header("Location: view_single_cv.php?id=$cv_id"); 
        exit();
    } else {
        echo "Erreur lors de la création du CV.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../public/styles/create_cv.css">
    <title>Créer un CV</title>
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
<body>
<?php include __DIR__ . "/../partials/header.php"; ?>

    <div class="form_cv">
    <h1>Créer un CV</h1>
    
    <form class="form_quest" method="POST" action="create_cv.php">
        <label for="title">Titre:</label>
        <input type="text" id="title" name="title" required>
        <br>
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>
        <br>
        <label for="profile_picture">Photo de profil (not working) :</label>
        <input type="text" id="profile_picture" name="profile_picture">
        <br>
        <label for="first_name">Prénom:</label>
        <input type="text" id="first_name" name="first_name">
        <br>
        <label for="last_name">Nom:</label>
        <input type="text" id="last_name" name="last_name">
        <br>
        <label for="birth_date">Date de naissance:</label>
        <input type="date" id="birth_date" name="birth_date" required>
        <br>
        <label for="phone">Téléphone:</label>
        <input type="text" id="phone" name="phone">
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
        <br>
        <label for="passions">Passions:</label>
        <textarea id="passions" name="passions"></textarea>
        <br>
        <div id="career-container">
            <label for="career">Carrière :</label>
            <textarea id="career" name="career[]"></textarea>
        </div>
        <button type="button" onclick="addField('career')">Ajouter une carrière</button>
        <br>
        <div id="education-container">
            <label for="education">Éducation :</label>
            <textarea id="education" name="education[]"></textarea>
        </div>
        <button type="button" onclick="addField('education')">Ajouter une éducation</button>
        <br>
        <div id="skills-container">
            <label for="skills">Compétences :</label>
            <textarea id="skills" name="skills[]"></textarea>
        </div>
        <button type="button" onclick="addField('skills')">Ajouter une compétence</button>
        <br>
        <button type="submit">Créer le CV</button>
    </form>
    </div>
    <?php include __DIR__ . "/../partials/footer.php"; ?>
</body>
</html>