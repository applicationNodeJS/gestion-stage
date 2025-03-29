<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$type = $_GET['type'] ?? 'excel';

// Récupération des données
$stmt = $pdo->query('SELECT * FROM demandes_stage');
$demandes = $stmt->fetchAll();

if ($type === 'excel') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="demandes_stage.xlsx"');
    
    echo "<table border='1'>";
    echo "<tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Établissement</th>
            <th>Niveau d'études</th>
            <th>Date début</th>
            <th>Date fin</th>
            <th>Type de stage</th>
          </tr>";
    
    foreach ($demandes as $demande) {
        echo "<tr>";
        echo "<td>".htmlspecialchars($demande['nom'])."</td>";
        echo "<td>".htmlspecialchars($demande['prenom'])."</td>";
        echo "<td>".htmlspecialchars($demande['email'])."</td>";
        echo "<td>".htmlspecialchars($demande['telephone'])."</td>";
        echo "<td>".htmlspecialchars($demande['etablissement'])."</td>";
        echo "<td>".htmlspecialchars($demande['niveau_etudes'])."</td>";
        echo "<td>".htmlspecialchars($demande['date_debut'])."</td>";
        echo "<td>".htmlspecialchars($demande['date_fin'])."</td>";
        echo "<td>".htmlspecialchars($demande['type_stage'])."</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} elseif ($type === 'pdf') {
    require 'vendor/autoload.php';
    
    $pdf = new \Mpdf\Mpdf();
    $html = '<h1>Liste des Demandes de Stage</h1>';
    $html .= '<table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Établissement</th>
                    <th>Niveau</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Type</th>
                </tr>';
    
    foreach ($demandes as $demande) {
        $html .= '<tr>';
        $html .= '<td>'.htmlspecialchars($demande['nom']).'</td>';
        $html .= '<td>'.htmlspecialchars($demande['prenom']).'</td>';
        $html .= '<td>'.htmlspecialchars($demande['email']).'</td>';
        $html .= '<td>'.htmlspecialchars($demande['telephone']).'</td>';
        $html .= '<td>'.htmlspecialchars($demande['etablissement']).'</td>';
        $html .= '<td>'.htmlspecialchars($demande['niveau_etudes']).'</td>';
        $html .= '<td>'.htmlspecialchars($demande['date_debut']).'</td>';
        $html .= '<td>'.htmlspecialchars($demande['date_fin']).'</td>';
        $html .= '<td>'.htmlspecialchars($demande['type_stage']).'</td>';
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    
    $pdf->WriteHTML($html);
    $pdf->Output('demandes_stage.pdf', 'D');
}
?>