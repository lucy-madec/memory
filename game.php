<?php
include_once 'classes/Database.php';
include_once 'classes/Game.php';

session_start();

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Création d'une nouvelle partie
$game = new Game($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numPairs = intval($_POST['numPairs']);
    $game->startGame($numPairs);

    $_SESSION['cards'] = $game->cards;
    header("Location: play.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Memory</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
    <h1>Memory</h1>
    <form method="POST" action="game.php">
        <label for="numPairs">Nombre de paires :</label>
        <select name="numPairs" id="numPairs">
            <?php for ($i = 3; $i <= 12; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?> paires</option>
            <?php endfor; ?>
        </select>
        <button type="submit">Commencer le jeu</button>
    </form>
</body>

</html>