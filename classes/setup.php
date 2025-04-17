<?php
include_once 'Database.php';

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Création de la table des scores si elle n'existe pas
$query = "CREATE TABLE IF NOT EXISTS scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    player_name VARCHAR(50) NOT NULL,
    num_pairs INT NOT NULL,
    time_seconds INT NOT NULL,
    moves INT NOT NULL,
    date_played DATETIME DEFAULT CURRENT_TIMESTAMP
)";

try {
    $db->exec($query);
    echo "Table des scores créée ou déjà existante.";
} catch(PDOException $e) {
    echo "Erreur lors de la création de la table: " . $e->getMessage();
}
?>
