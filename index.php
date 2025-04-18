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
    $playerName = trim($_POST['playerName']);
    
    if (empty($playerName)) {
        $playerName = 'Joueur Anonyme';
    }
    
    $game->startGame($numPairs);

    $_SESSION['cards'] = $game->cards;
    $_SESSION['player_name'] = $playerName;
    $_SESSION['start_time'] = time();
    $_SESSION['moves'] = 0;
    
    header("Location: play.php");
    exit();
}

// Récupération des meilleurs scores pour affichage
$topScores = $game->getTopScores(5);
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

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
                <div class="card bg-dark text-white mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-controller"></i> Nouvelle partie</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="index.php">
                            <div class="mb-3">
                                <label for="playerName" class="form-label">Votre nom :</label>
                                <input type="text" class="form-control" name="playerName" id="playerName" placeholder="Entrez votre nom" maxlength="50">
                            </div>
                            <div class="mb-3">
                                <label for="numPairs" class="form-label">Nombre de paires :</label>
                                <select class="form-select" name="numPairs" id="numPairs">
                                    <?php for ($i = 3; $i <= 12; $i++): ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?> paires</option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-danger btn-lg button-start">
                                    <i class="bi bi-play-fill"></i> Commencer le jeu
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="card bg-dark text-white">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-trophy"></i> Meilleurs scores</h5>
                        <a href="scores.php" class="btn btn-sm btn-outline-danger">Voir tous les scores</a>
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($topScores)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Aucun score enregistré pour le moment</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($topScores as $index => $score): ?>
                                        <tr>
                                            <th scope="row"><?php echo $index + 1; ?></th>
                                            <td><?php echo htmlspecialchars($score['player_name']); ?></td>
                                            <td><?php echo $score['num_pairs']; ?></td>
                                            <td><?php echo $score['time_seconds']; ?> sec</td>
                                            <td><?php echo $score['moves']; ?></td>
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