<?php
include_once 'classes/Database.php';
include_once 'classes/Game.php';

session_start();

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Création d'une instance de Game
$game = new Game($db);

// Récupération des scores
$selectedPairs = isset($_GET['pairs']) ? intval($_GET['pairs']) : 0;

if ($selectedPairs > 0) {
    $scores = $game->getTopScoresByPairs($selectedPairs);
    $pageTitle = "Meilleurs scores pour $selectedPairs paires";
} else {
    $scores = $game->getTopScores();
    $pageTitle = "Meilleurs scores";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creepy Memory - Scores</title>
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

    <!-- Bouton de retour à l'accueil -->
    <a href="index.php" class="btn btn-danger back-home">Retour à l'accueil</a>

    <div class="container mt-5">
        <div class="title-container">
            <h1 class="title-bordered text-danger"><?php echo $pageTitle; ?></h1>
        </div>
        
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="card bg-dark text-white">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Tableau des scores</h5>
                            <div class="dropdown">
                                <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Filtrer par paires
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="scores.php">Tous les scores</a></li>
                                    <?php for ($i = 3; $i <= 12; $i++): ?>
                                        <li><a class="dropdown-item" href="scores.php?pairs=<?php echo $i; ?>"><?php echo $i; ?> paires</a></li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-dark table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Joueur</th>
                                    <th scope="col">Paires</th>
                                    <th scope="col">Temps</th>
                                    <th scope="col">Mouvements</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($scores)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Aucun score enregistré pour le moment</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($scores as $index => $score): ?>
                                        <tr>
                                            <th scope="row"><?php echo $index + 1; ?></th>
                                            <td><?php echo htmlspecialchars($score['player_name']); ?></td>
                                            <td><?php echo $score['num_pairs']; ?></td>
                                            <td><?php echo $score['time_seconds']; ?> sec</td>
                                            <td><?php echo $score['moves']; ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($score['date_played'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
