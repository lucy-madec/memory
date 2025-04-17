<?php
include_once 'classes/Database.php';
include_once 'classes/Game.php';

session_start();

header('Content-Type: application/json');

// Vérifier si les données nécessaires sont présentes
if (!isset($_SESSION['player_name']) || !isset($_SESSION['cards']) || !isset($_POST['time']) || !isset($_POST['moves'])) {
    echo json_encode(['success' => false, 'message' => 'Données manquantes']);
    exit();
}

// Récupérer les données
$playerName = $_SESSION['player_name'];
$timeSeconds = intval($_POST['time']);
$moves = intval($_POST['moves']);
$numPairs = count($_SESSION['cards']) / 2;

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Sauvegarder le score
$game = new Game($db);
$game->startGame($numPairs); // Pour définir le nombre de paires
$result = $game->saveScore($playerName, $timeSeconds, $moves);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la sauvegarde du score']);
}
?>
