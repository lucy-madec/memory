<?php
session_start();

header('Content-Type: application/json');

// Vérifier si les données nécessaires sont présentes
if (!isset($_POST['moves'])) {
    echo json_encode(['success' => false, 'message' => 'Données manquantes']);
    exit();
}

// Mettre à jour le nombre de mouvements dans la session
$_SESSION['moves'] = intval($_POST['moves']);

echo json_encode(['success' => true]);
?>
