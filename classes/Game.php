<?php
class Game {
    private $conn;
    private $table_name = "games";

    public $player_id;
    public $score;
    public $cards = [];

    public function __construct($db) {
        $this->conn = $db;
    }

    public function startGame($numPairs) {
        // Logique pour initialiser les cartes du jeu
        $query = "SELECT * FROM cards ORDER BY RAND() LIMIT " . ($numPairs * 2);
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $this->cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function endGame() {
        $query = "INSERT INTO " . $this->table_name . " SET player_id=:player_id, score=:score";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":player_id", $this->player_id);
        $stmt->bindParam(":score", $this->score);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
