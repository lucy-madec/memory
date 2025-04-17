<?php
class Game
{
    private $conn;
    private $table_name = "scores";

    public $player_name;
    public $num_pairs;
    public $time_seconds;
    public $moves;
    public $cards = [];

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function startGame($numPairs)
    {
        $this->cards = [];
        $this->num_pairs = $numPairs;

        for ($i = 1; $i <= $numPairs; $i++) {
            $this->cards[] = ['id' => $i * 2 - 1, 'image' => "image$i.png", 'pair_id' => $i];
            $this->cards[] = ['id' => $i * 2, 'image' => "image$i.png", 'pair_id' => $i];
        }

        shuffle($this->cards);
    }

    public function saveScore($playerName, $timeSeconds, $moves)
    {
        $query = "INSERT INTO " . $this->table_name . " 
                 (player_name, num_pairs, time_seconds, moves) 
                 VALUES (:player_name, :num_pairs, :time_seconds, :moves)";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":player_name", $playerName);
        $stmt->bindParam(":num_pairs", $this->num_pairs);
        $stmt->bindParam(":time_seconds", $timeSeconds);
        $stmt->bindParam(":moves", $moves);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
    
    public function getTopScores($limit = 10)
    {
        $query = "SELECT * FROM " . $this->table_name . " 
                 ORDER BY num_pairs DESC, time_seconds ASC, moves ASC 
                 LIMIT " . $limit;
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getTopScoresByPairs($numPairs, $limit = 10)
    {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE num_pairs = :num_pairs 
                 ORDER BY time_seconds ASC, moves ASC 
                 LIMIT " . $limit;
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":num_pairs", $numPairs);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
