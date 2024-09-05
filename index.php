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
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creepy Memory</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/img/favicon.webp" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/styles.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Creepster&display=swap" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="title-container">
            <h1 class="title-bordered text-danger">Creepy Memory</h1>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <form method="POST" action="index.php">
                    <div class="mb-3">
                        <label for="numPairs" class="form-label text-danger label-bordered">Nombre de paires :</label>
                        <select class="form-select" name="numPairs" id="numPairs">
                            <?php for ($i = 3; $i <= 12; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?> paires</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-danger btn-lg">Commencer le jeu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>