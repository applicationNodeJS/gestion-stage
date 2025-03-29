<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
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

    $stmt = $pdo->prepare('INSERT INTO demandes_stage (nom, prenom, email, telephone, etablissement, niveau_etudes, date_debut, date_fin, type_stage) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$nom, $prenom, $email, $telephone, $etablissement, $niveau_etudes, $date_debut, $date_fin, $type_stage]);
}

$stmt = $pdo->query('SELECT * FROM demandes_stage');
$demandes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demande de Stage</title>
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
            margin-bottom: 2rem;
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
        .table-container {
            width: 100%;
            overflow-x: auto;
            margin-top: 2rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 0.75rem;
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
        .actions {
            display: flex;
            gap: 0.5rem;
        }
        .actions a {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-size: 0.9rem;
        }
        .actions .edit {
            background-color: #28a745;
        }
        .actions .edit:hover {
            background-color: #218838;
        }
        .actions .delete {
            background-color: #dc3545;
        }
        .actions .delete:hover {
            background-color: #c82333;
        }
        input[type="date"]::before {
    content: attr(placeholder);
    color: #999;
    margin-right: 0.5rem;
}
input[type="date"]:focus::before,
input[type="date"]:valid::before {
    content: "";
}


.export-buttons {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }
        .export-btn {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }
        .export-btn:hover {
            background-color: #218838;
        }
        .export-btn.pdf {
            background-color: #dc3545;
        }
        .export-btn.pdf:hover {
            background-color: #c82333;
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
        <h1>Demande de Stage :</h1>
        <form method="post">
            Nom : <input type="text" name="nom" placeholder="Nom" required>
            Prenom :<input type="text" name="prenom" placeholder="Prénom" required>
            Email :<input type="email" name="email" placeholder="Email" required>
            Telephone :<input type="number" name="telephone" placeholder="Téléphone" required>
            Etablissement :<input type="text" name="etablissement" placeholder="Établissement" required>
            Niveau D'etude :<input type="text" name="niveau_etudes" placeholder="Niveau d'études" required>
            Date de debut :<input type="date" name="date_debut" placeholder="Date de début" required>
            Date de fin :<input type="date" name="date_fin" placeholder="Date de fin" required>
           Type de stage :<select name="type_stage" placeholder="type" value='type de stage' required>
            <option value="" disabled selected>Selectionnez un type de stage</option>
                <option value="Fin d'etude">fin d'etude</option>
                <option value="pre-embauche">pre-embauche</option>
                <option value="d'application">d'application</option>
                <option value="d'observation">d'observation</option>
            </select>
            <button type="submit">Enregistrer</button>
        </form>

        <h1>Liste des Demandes de Stage :</h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Établissement</th>
                        <th>Niveau d'études</th>
                        <th>Date de début</th>
                        <th>Date de fin</th>
                        <th>Type de stage</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($demandes as $demande): ?>
                    <tr>
                        <td><?= htmlspecialchars($demande['nom']) ?></td>
                        <td><?= htmlspecialchars($demande['prenom']) ?></td>
                        <td><?= htmlspecialchars($demande['email']) ?></td>
                        <td><?= htmlspecialchars($demande['telephone']) ?></td>
                        <td><?= htmlspecialchars($demande['etablissement']) ?></td>
                        <td><?= htmlspecialchars($demande['niveau_etudes']) ?></td>
                        <td><?= htmlspecialchars($demande['date_debut']) ?></td>
                        <td><?= htmlspecialchars($demande['date_fin']) ?></td>
                        <td><?= htmlspecialchars($demande['type_stage']) ?></td>
                        <td class="actions">
                            <a href="edit.php?id=<?= $demande['id'] ?>" class="edit">Modifier</a>
                            <a href="delete.php?id=<?= $demande['id'] ?>" class="delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette demande ?')">Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                </tbody>
            </table>

        </div>
        <div class="export-buttons">
            <a href="export.php?type=excel" class="export-btn">Exporter en Excel</a>
            <a href="export.php?type=pdf" class="export-btn pdf">Exporter en PDF</a>
        </div>
    </div>
</body>
</html>