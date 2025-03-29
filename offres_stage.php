<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Ajout d'une offre
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajouter'])) {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $entreprise = $_POST['entreprise'];
    $duree = $_POST['duree'];
    
    $stmt = $pdo->prepare('INSERT INTO offres_stage (titre, description, entreprise, duree) VALUES (?, ?, ?, ?)');
    $stmt->execute([$titre, $description, $entreprise, $duree]);
}

// Suppression d'une offre
if (isset($_GET['supprimer'])) {
    $id = $_GET['supprimer'];
    $stmt = $pdo->prepare('DELETE FROM offres_stage WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: offres_stage.php');
    exit;
}

// Récupération des offres
$offres = $pdo->query('SELECT * FROM offres_stage')->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Offres de Stage</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        /* .menu {
            background-color: #343a40;
            padding: 15px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .menu a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 16px;
            transition: all 0.3s;
        }
        .menu a:hover {
            color: #17a2b8;
        } */
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
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }
        h1 {
            color: #343a40;
            border-bottom: 2px solid #17a2b8;
            padding-bottom: 10px;
        }
        .offre-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            background: #f8f9fa;
        }
        .offre-card h3 {
            color: #17a2b8;
            margin-top: 0;
        }
        .btn {
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-size: 14px;
            margin-right: 10px;
        }
        .btn-primary {
            background-color: #17a2b8;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-success {
            background-color: #28a745;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn-submit {
            background-color: #17a2b8;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="menu">
        <a href="login.php">Connexion</a>
        <a href="signup.php">Inscription</a>
        <a href="demande_stage.php">Demande de Stage</a>
        <a href="offres_stage.php">Offres de Stage</a>
        <a href="suivi_stagiaires.php">Suivi Stagiaires</a>
    </div>
    
    <div class="container">
        <h1>Offres de Stage Disponibles</h1>
        
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?> 
        <div style="margin-bottom: 30px;">
            <h2>Ajouter une Offre</h2>
            <form method="post">
                <div class="form-group">
                    <label>Titre</label>
                    <input type="text" name="titre" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label>Entreprise</label>
                    <input type="text" name="entreprise" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Durée (mois)</label>
                    <input type="number" name="duree" class="form-control" required>
                </div>
                <button type="submit" name="ajouter" class="btn-submit">Ajouter l'offre</button>
            </form>
        </div>
        <?php endif; ?>
        
        <div class="offres-list">
            <?php foreach ($offres as $offre): ?>
            <div class="offre-card">
                <h3><?= htmlspecialchars($offre['titre']) ?></h3>
                <p><strong>Entreprise:</strong> <?= htmlspecialchars($offre['entreprise']) ?></p>
                <p><strong>Durée:</strong> <?= htmlspecialchars($offre['duree']) ?> mois</p>
                <p><?= nl2br(htmlspecialchars($offre['description'])) ?></p>
                
                <div style="margin-top: 15px;">
                    <a href="demande_stage.php?offre=<?= $offre['id'] ?>" class="btn btn-primary">Postuler</a>
                    
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="offres_stage.php?supprimer=<?= $offre['id'] ?>" class="btn btn-danger" 
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')">
                        Supprimer
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>