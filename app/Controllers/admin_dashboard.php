<?php
session_start();
$pdo = require __DIR__ . '/../../config/database.php'; // Chemin mis à jour

// Vérification si l'utilisateur est administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /../View/auth/login.php');
    exit();
}

// Suppression d'un utilisateur si l'ID est fourni via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['delete_user_id'])) {
        $delete_user_id = $_POST['delete_user_id'];

        // Supprimer l'utilisateur
        $delete_query = "DELETE FROM users WHERE id = ?";
        $stmt = $pdo->prepare($delete_query);
        $stmt->execute([$delete_user_id]);

        if ($stmt->rowCount() > 0) {
            echo "Utilisateur supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression de l'utilisateur.";
        }
    } elseif (isset($_POST['delete_message_id'])) {
        $delete_message_id = $_POST['delete_message_id'];

        // Supprimer le message
        $delete_query = "DELETE FROM messages WHERE id = ?";
        $stmt = $pdo->prepare($delete_query);
        $stmt->execute([$delete_message_id]);

        if ($stmt->rowCount() > 0) {
            echo "Message supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression du message.";
        }
    }
}

// Récupération de tous les utilisateurs
$query = "SELECT * FROM users";
$stmt = $pdo->query($query);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération de tous les messages
$query = "SELECT * FROM messages";
$stmt = $pdo->query($query);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/../public/styles/admin_dashboard.css">
</head>
<body>
    <?php include __DIR__ . "/../../View/partials/admin_header.php"; ?>
    <h1>Tableau de bord administrateur</h1>

    <h2>Liste des utilisateurs</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td>
                    <a href="/../View/cv/edit_user_cv.php?user_id=<?php echo $user['id']; ?>">Modifier CV</a>
                    <a href="/../View/project/edit_user_project.php?user_id=<?php echo $user['id']; ?>">Modifier Projets</a>
                    <form method="POST" action="admin_dashboard.php" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');" style="display:inline;">
                        <input type="hidden" name="delete_user_id" value="<?php echo $user['id']; ?>">
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Messages de contact</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $message): ?>
            <tr>
                <td><?php echo htmlspecialchars($message['user_name']); ?></td>
                <td><?php echo htmlspecialchars($message['message']); ?></td>
                <td>
                    <form method="POST" action="admin_dashboard.php" onsubmit="return confirm('Voulez-vous vraiment supprimer ce message ?');" style="display:inline;">
                        <input type="hidden" name="delete_message_id" value="<?php echo $message['id']; ?>">
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <footer>
        <?php include __DIR__ . "/../../View/partials/footer.php"; ?>
    </footer>
</body>
</html>