<?php
include_once 'classes/Database.php';
include_once 'classes/Game.php';

session_start();

if (!isset($_SESSION['cards']) || !isset($_SESSION['start_time'])) {
    header("Location: index.php");
    exit();
}

$cards = $_SESSION['cards'];
$playerName = isset($_SESSION['player_name']) ? $_SESSION['player_name'] : 'Joueur Anonyme';
$startTime = $_SESSION['start_time'];
$moves = isset($_SESSION['moves']) ? $_SESSION['moves'] : 0;

// Mélange les cartes pour l'affichage si ce n'est pas déjà fait
if (!isset($_SESSION['cards_shuffled'])) {
    shuffle($cards);
    $_SESSION['cards'] = $cards;
    $_SESSION['cards_shuffled'] = true;
}

// Calcul du nombre total de paires
$totalPairs = count($cards) / 2;

// Connexion à la base de données pour la sauvegarde du score à la fin
$database = new Database();
$db = $database->getConnection();
$game = new Game($db);

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
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
</head>

<body class="bg-light">

    <!-- Bouton de retour à l'accueil -->
    <a href="index.php" class="btn btn-danger back-home">Retour à l'accueil</a>

    <div class="container mt-5">
        <div class="title-container">
            <h1 class="title-bordered text-danger">Creepy Memory</h1>
        </div>
        
        <!-- Informations de jeu -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <div class="card bg-dark text-white">
                    <div class="card-body py-2">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <div class="game-info">
                                    <i class="bi bi-person-circle"></i> 
                                    <span id="player-name"><?php echo htmlspecialchars($playerName); ?></span>
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="game-info">
                                    <i class="bi bi-clock"></i> 
                                    <span id="timer">00:00</span>
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="game-info">
                                    <i class="bi bi-arrow-repeat"></i> 
                                    <span id="moves-count">0</span> mouvements
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="game-info">
                                    <i class="bi bi-grid-3x3"></i> 
                                    <span id="pairs-count">0</span>/<span id="total-pairs"><?php echo $totalPairs; ?></span> paires
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Grille de jeu -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row row-cols-2 row-cols-md-4 g-3" id="game-board">
                    <?php foreach ($cards as $card): ?>
                        <div class="col">
                            <div class="card memory-card" data-pair-id="<?php echo $card['pair_id']; ?>">
                                <div class="card-back"></div>
                                <div class="card-front">
                                    <img src="assets/img/<?php echo $card['image']; ?>" class="card-img-top"
                                        alt="Memory Card">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de fin de jeu -->
    <div class="modal fade" id="gameOverModal" tabindex="-1" aria-labelledby="gameOverModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="gameOverModalLabel">Partie terminée !</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Félicitations <span id="modal-player-name"></span> !</p>
                    <p>Vous avez terminé la partie en <span id="modal-time"></span> avec <span id="modal-moves"></span> mouvements.</p>
                </div>
                <div class="modal-footer">
                    <a href="index.php" class="btn btn-secondary">Retour à l'accueil</a>
                    <button type="button" class="btn btn-danger" id="play-again-btn">Rejouer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script>
        // Données du jeu
        const gameData = {
            playerName: '<?php echo htmlspecialchars($playerName); ?>',
            startTime: <?php echo $startTime; ?>,
            totalPairs: <?php echo $totalPairs; ?>,
            moves: <?php echo $moves; ?>
        };
    </script>
    <script src="js/scripts.js"></script>
</body>

</html>