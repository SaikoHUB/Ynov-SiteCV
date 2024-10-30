<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        p {
            font-size: 1.2em;
            color: #555;
            text-align: justify;
        }

        footer {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
            margin-top: 40px;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
            margin-bottom: 20px;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin-right: 10px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<?php include __DIR__ . '/../../View/partials/header.php'; ?>
    </header>

    <div class="container">
        <h1>Contact</h1>
        <p>
            Ce projet est une application web pour créer et gérer des CV en utilisant PHP. Il permet aux utilisateurs de s'inscrire, de créer des CV, de les visualiser, de les modifier et de les supprimer. Les administrateurs peuvent gérer les utilisateurs et leurs projets.
        </p>
    </div>

    <footer>
    <?php include __DIR__ . '/../../View/partials/footer.php'; ?>
    </footer>
</body>
</html>