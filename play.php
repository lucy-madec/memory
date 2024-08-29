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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <div class="container mt-5">
        <h1 class="text-center">Memory</h1>
        <div class="memory-game row">
            <div class="col-3">
                <div class="memory-card" data-pair-id="1">
                    <div class="card-front">
                        <img src="assets/img/image1.png" alt="Card 1" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="1">
                    <div class="card-front">
                        <img src="assets/img/image1.png" alt="Card 1" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="2">
                    <div class="card-front">
                        <img src="assets/img/image2.png" alt="Card 2" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="2">
                    <div class="card-front">
                        <img src="assets/img/image2.png" alt="Card 2" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="3">
                    <div class="card-front">
                        <img src="assets/img/image3.png" alt="Card 3" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="3">
                    <div class="card-front">
                        <img src="assets/img/image3.png" alt="Card 3" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="4">
                    <div class="card-front">
                        <img src="assets/img/image4.png" alt="Card 4" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="4">
                    <div class="card-front">
                        <img src="assets/img/image4.png" alt="Card 4" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="5">
                    <div class="card-front">
                        <img src="assets/img/image5.png" alt="Card 5" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="5">
                    <div class="card-front">
                        <img src="assets/img/image5.png" alt="Card 5" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="6">
                    <div class="card-front">
                        <img src="assets/img/image6.png" alt="Card 6" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="6">
                    <div class="card-front">
                        <img src="assets/img/image6.png" alt="Card 6" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="7">
                    <div class="card-front">
                        <img src="assets/img/image7.png" alt="Card 7" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="7">
                    <div class="card-front">
                        <img src="assets/img/image7.png" alt="Card 7" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="8">
                    <div class="card-front">
                        <img src="assets/img/image8.png" alt="Card 8" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="8">
                    <div class="card-front">
                        <img src="assets/img/image8.png" alt="Card 8" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="9">
                    <div class="card-front">
                        <img src="assets/img/image9.png" alt="Card 9" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="9">
                    <div class="card-front">
                        <img src="assets/img/image9.png" alt="Card 9" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="10">
                    <div class="card-front">
                        <img src="assets/img/image10.png" alt="Card 10" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="10">
                    <div class="card-front">
                        <img src="assets/img/image10.png" alt="Card 10" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="11">
                    <div class="card-front">
                        <img src="assets/img/image11.png" alt="Card 11" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="11">
                    <div class="card-front">
                        <img src="assets/img/image11.png" alt="Card 11" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="12">
                    <div class="card-front">
                        <img src="assets/img/image12.png" alt="Card 12" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="memory-card" data-pair-id="12">
                    <div class="card-front">
                        <img src="assets/img/image12.png" alt="Card 12" class="img-fluid">
                    </div>
                    <div class="card-back"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lien vers Bootstrap JS, jQuery, et Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>