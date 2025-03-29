<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: demande_stage.php');
    exit;
}

$id = $_GET['id'];

// Récupérer la demande de stage à modifier
$stmt = $pdo->prepare('SELECT * FROM demandes_stage WHERE id = ?');
$stmt->execute([$id]);
$demande = $stmt->fetch();

if (!$demande) {
    header('Location: demande_stage.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $etablissement = $_POST['etablissement'];
    $niveau_etudes = $_POST['niveau_etudes'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $type_stage = $_POST['type_stage'];

    // Mettre à jour la demande de stage
    $stmt = $pdo->prepare('UPDATE demandes_stage SET nom = ?, prenom = ?, email = ?, telephone = ?, etablissement = ?, niveau_etudes = ?, date_debut = ?, date_fin = ?, type_stage = ? WHERE id = ?');
    $stmt->execute([$nom, $prenom, $email, $telephone, $etablissement, $niveau_etudes, $date_debut, $date_fin, $type_stage, $id]);

    header('Location: demande_stage.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier la Demande de Stage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
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
            width: 90%;
            max-width: 1000px;
            margin: 2rem 0;
        }
        h1 {
            color: #333;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }
        form {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        input, select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        button {
            grid-column: span 2;
            padding: 0.75rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="menu">
        <a href="login.php">Connexion</a>
        <a href="signup.php">Inscription</a>
        <a href="demande_stage.php">Demande de Stage</a>
        
    </div>
    <div class="container">
        <h1>Modifier la Demande de Stage :</h1>
        <form method="post">
            Nom :<input type="text" name="nom" placeholder="Nom" value="<?= htmlspecialchars($demande['nom']) ?>" required>
            Prenom :<input type="text" name="prenom" placeholder="Prénom" value="<?= htmlspecialchars($demande['prenom']) ?>" required>
            Email :<input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($demande['email']) ?>" required>
            Telephone :<input type="number" name="telephone" placeholder="Téléphone" value="<?= htmlspecialchars($demande['telephone']) ?>" required>
            Etablissement :<input type="text" name="etablissement" placeholder="Établissement" value="<?= htmlspecialchars($demande['etablissement']) ?>" required>
            Niveau d'etude :<input type="text" name="niveau_etudes" placeholder="Niveau d'études" value="<?= htmlspecialchars($demande['niveau_etudes']) ?>" required>
            Date de debut :<input type="date" name="date_debut" placeholder="Date de début" value="<?= htmlspecialchars($demande['date_debut']) ?>" required>
            Date de fin :<input type="date" name="date_fin" placeholder="Date de fin" value="<?= htmlspecialchars($demande['date_fin']) ?>" required>
            Type de stage :<select name="type_stage" required>
                <option value="fin d'etude" <?= $demande['type_stage'] == "fin d'etude" ? 'selected' : '' ?>>fin d'etude</option>
                <option value="pre-embauche" <?= $demande['type_stage'] == 'pre-embauche' ? 'selected' : '' ?>>pre-embauche</option>
                <option value="d'application" <?= $demande['type_stage'] == "d'application" ? 'selected' : '' ?>>d'application</option>
                <option value="d'observation" <?= $demande['type_stage'] == "d'observation" ? 'selected' : '' ?>>d'observation</option>
            </select>
            <button type="submit">Enregistrer</button>
        </form>
    </div>
</body>
</html>
