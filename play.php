<?php
session_start();

if (!isset($_SESSION['cards'])) {
    header("Location: index.php");
    exit();
}

$cards = $_SESSION['cards'];

// Mélange les cartes pour l'affichage
shuffle($cards);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <h1 class="text-center">Memory Game</h1>
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="row row-cols-4">
                    <?php foreach ($cards as $card): ?>
                        <div class="col mb-4">
                            <div class="card memory-card" data-pair-id="<?php echo $card['pair_id']; ?>">
                                <div class="card-front">
                                    <img src="assets/img/<?php echo $card['image']; ?>" class="card-img-top" alt="Memory Card">
                                </div>
                                <div class="card-back bg-secondary"></div>
                            </div>
                        </div>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>