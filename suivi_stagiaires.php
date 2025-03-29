<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Récupération des stagiaires
$stagiaires = $pdo->query('
    SELECT d.*, u.email as tuteur_email 
    FROM demandes_stage d
    LEFT JOIN users u ON d.tuteur_id = u.id
')->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suivi des Stagiaires</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }
        .status-approved {
            color: #28a745;
            font-weight: bold;
        }
        .status-rejected {
            color: #dc3545;
            font-weight: bold;
        }
        .action-btn {
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-size: 14px;
            margin-right: 5px;
        }
        .btn-info {
            background-color: #17a2b8;
        }
        .btn-success {
            background-color: #28a745;
        }
        .btn-warning {
            background-color: #ffc107;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .search-bar {
            margin-bottom: 20px;
        }
        .search-bar input {
            padding: 8px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 4px;
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
        <h1>Suivi des Stagiaires</h1>
        
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Rechercher un stagiaire...">
        </div>
        
        <table id="stagiairesTable">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Établissement</th>
                    <th>Type de stage</th>
                    <th>Période</th>
                    <th>Statut</th>
                    <th>Tuteur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stagiaires as $stagiaire): ?>
                <tr>
                    <td><?= htmlspecialchars($stagiaire['nom']) ?></td>
                    <td><?= htmlspecialchars($stagiaire['prenom']) ?></td>
                    <td><?= htmlspecialchars($stagiaire['email']) ?></td>
                    <td><?= htmlspecialchars($stagiaire['etablissement']) ?></td>
                    <td><?= htmlspecialchars($stagiaire['type_stage']) ?></td>
                    <td>
                        <?= date('d/m/Y', strtotime($stagiaire['date_debut'])) ?> - 
                        <?= date('d/m/Y', strtotime($stagiaire['date_fin'])) ?>
                    </td>
                    <td class="status-<?= strtolower($stagiaire['statut'] ?? 'pending') ?>">
                        <?= $stagiaire['statut'] ?? 'En attente' ?>
                    </td>
                    <td><?= htmlspecialchars($stagiaire['tuteur_email'] ?? 'Non assigné') ?></td>
                    <td>
                        <a href="#" class="action-btn btn-info">Détails</a>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="#" class="action-btn btn-success">Valider</a>
                        <a href="#" class="action-btn btn-warning">Modifier</a>
                        <a href="#" class="action-btn btn-danger">Refuser</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Fonction de recherche
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const input = this.value.toLowerCase();
            const rows = document.querySelectorAll('#stagiairesTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(input) ? '' : 'none';
            });
        });
    </script>
</body>
</html>