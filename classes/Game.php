<?php
class Game
{
    private $conn;
    private $table_name = "games";

    public $player_id;
    public $score;
    public $cards = [];

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function startGame($numPairs)
    {
        $this->cards = [];

        for ($i = 1; $i <= $numPairs; $i++) {
            $this->cards[] = ['id' => $i * 2 - 1, 'image' => "image$i.png", 'pair_id' => $i];
            $this->cards[] = ['id' => $i * 2, 'image' => "image$i.png", 'pair_id' => $i];
        }

        shuffle($this->cards);
    }


    public function endGame()
    {
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
