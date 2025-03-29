<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
    $stmt->execute([$email, $password]);
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }
        .menu {
            width: 100%;
            background-color: #007bff;
            padding: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .menu a {
            color: white;
            text-decoration: none;
            margin: 0 1rem;
            font-size: 1rem;
        }
        .menu a:hover {
            text-decoration: underline;
        }
        .container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            margin-top: 2rem;
        }
        h1 {
            margin-bottom: 1.5rem;
            color: #333;
            font-size: 1.5rem;
        }
        input {
            width: 100%;
            padding: 0.75rem;
            margin: 0.5rem 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        button {
            width: 100%;
            padding: 0.75rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 1rem;
        }
        button:hover {
            background-color: #0056b3;
        }
        .link {
            margin-top: 1rem;
            font-size: 0.9rem;
            color: #007bff;
            text-decoration: none;
        }
        .link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- <div class="menu">
        <a href="login.php">Connexion</a>
        <a href="signup.php">Inscription</a>
        <a href="demande_stage.php">Demande de Stage</a>
    </div> -->
    <div class="container">
        <h1>Inscription</h1>
        <form method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">S'inscrire</button>
        </form>
        <a href="login.php" class="link">J'ai déjà un compte</a>
    </div>
</body>
</html>