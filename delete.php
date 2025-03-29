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

// Supprimer la demande de stage
$stmt = $pdo->prepare('DELETE FROM demandes_stage WHERE id = ?');
$stmt->execute([$id]);

header('Location: demande_stage.php');
exit;
?>